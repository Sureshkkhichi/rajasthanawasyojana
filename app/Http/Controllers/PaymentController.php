<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Deal;
use App\Models\Inventory;
use App\Mail\PaymentConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Handle user redirect back from PhonePe (GET).
     */
    public function redirect(Request $request)
    {
        $transactionId = $request->input('transactionId');

        if (!$transactionId) {
            Log::error('PhonePe redirect accessed without transactionId.');
            return redirect()->route('front')->with('error', 'Invalid transaction reference.');
        }

        $lead = Lead::where('transaction_id', $transactionId)->first();

        if (!$lead) {
            Log::error('Lead not found for transactionId: ' . $transactionId);
            return redirect()->route('front')->with('error', 'Booking record not found.');
        }

        // Check payment status from PhonePe Status API
        $statusData = $this->checkTransactionStatus($transactionId);

        if ($statusData && ($statusData['code'] ?? '') === 'PAYMENT_SUCCESS') {
            $this->processSuccessfulPayment($lead);
            return view('payment.success', compact('lead'));
        } elseif ($statusData && ($statusData['code'] ?? '') === 'PAYMENT_PENDING') {
            $this->processPendingPayment($lead);
            return view('payment.failed', [
                'lead' => $lead,
                'message' => 'Your payment is pending confirmation. Please check back later.'
            ]);
        } else {
            $this->processFailedPayment($lead);
            return view('payment.failed', [
                'lead' => $lead,
                'message' => 'The payment transaction failed or was cancelled.'
            ]);
        }
    }

    /**
     * Handle server-to-server webhook callback from PhonePe (POST).
     */
    public function callback(Request $request)
    {
        $response = $request->input('response');

        if (!$response) {
            Log::error('PhonePe callback accessed without response payload.');
            return response()->json(['success' => false, 'message' => 'Missing payload'], 400);
        }

        // Verify checksum header
        $headerXVerify = $request->header('X-VERIFY');
        $saltKey = config('phonepe.salt_key');
        $saltIndex = config('phonepe.salt_index');
        $expectedHash = hash('sha256', $response . $saltKey) . '###' . $saltIndex;

        if ($headerXVerify !== $expectedHash) {
            Log::warning('PhonePe callback checksum verification failed.');
            return response()->json(['success' => false, 'message' => 'Invalid checksum'], 400);
        }

        $decoded = json_decode(base64_decode($response), true);
        $transactionId = $decoded['data']['merchantTransactionId'] ?? null;
        $code = $decoded['code'] ?? null;

        if (!$transactionId) {
            Log::error('PhonePe callback payload did not contain merchantTransactionId.');
            return response()->json(['success' => false, 'message' => 'Invalid data'], 400);
        }

        $lead = Lead::where('transaction_id', $transactionId)->first();

        if (!$lead) {
            Log::error('Lead not found in PhonePe callback for transactionId: ' . $transactionId);
            return response()->json(['success' => false, 'message' => 'Lead not found'], 404);
        }

        if ($code === 'PAYMENT_SUCCESS') {
            $this->processSuccessfulPayment($lead);
        } elseif ($code === 'PAYMENT_PENDING') {
            $this->processPendingPayment($lead);
        } else {
            $this->processFailedPayment($lead);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Query PhonePe Transaction Status API.
     */
    private function checkTransactionStatus(string $transactionId): ?array
    {
        $merchantId = config('phonepe.merchant_id');
        $saltKey = config('phonepe.salt_key');
        $saltIndex = config('phonepe.salt_index');
        $statusUrl = config('phonepe.status_url') . '/' . $merchantId . '/' . $transactionId;

        $stringToHash = '/pg/v1/status/' . $merchantId . '/' . $transactionId . $saltKey;
        $sha256 = hash('sha256', $stringToHash);
        $xVerify = $sha256 . '###' . $saltIndex;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-VERIFY' => $xVerify,
                'X-MERCHANT-ID' => $merchantId,
            ])->timeout(10)->get($statusUrl);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('PhonePe Status API returned error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('PhonePe Status API request failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Process successful payment: Update Lead, Create Deal, and Send Confirmation Mail.
     */
    private function processSuccessfulPayment(Lead $lead): void
    {
        DB::transaction(function () use ($lead) {
            // Lock the lead record to prevent double processing
            $lead = Lead::where('id', $lead->id)->lockForUpdate()->first();

            if ($lead->payment_status === 'paid') {
                return;
            }

            // Update Lead
            $lead->update([
                'status' => 'paid',
                'payment_status' => 'paid',
            ]);

            // Determine unit price or fallback to project price
            $project = $lead->project;
            $unitPrice = null;

            if ($project->inventory_type === 'flat') {
                $matchingUnit = Inventory::query()
                    ->where('project_id', $project->id)
                    ->where('inventory_type', 'flat')
                    ->where('unit_type', $lead->flat_size)
                    ->first();
                if ($matchingUnit) {
                    $unitPrice = $matchingUnit->price;
                }
            } else {
                $matchingUnit = Inventory::query()
                    ->where('project_id', $project->id)
                    ->where('inventory_type', 'plot')
                    ->where('area_sq_yards', $lead->flat_size)
                    ->first();
                if ($matchingUnit) {
                    $unitPrice = $matchingUnit->price;
                }
            }

            if (!$unitPrice) {
                $unitPrice = $project->price;
            }

            // Create Deal
            $deal = Deal::create([
                'project_id' => $project->id,
                'first_name' => $lead->first_name,
                'last_name' => $lead->last_name,
                'father_husband_name' => $lead->father_husband_name,
                'pan_number' => $lead->pan_number,
                'gender' => $lead->gender,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'date_of_birth' => $lead->date_of_birth,
                'occupation' => $lead->occupation,
                'address' => $lead->address,
                'state_id' => $lead->state_id,
                'state_name' => $lead->state_name,
                'city_id' => $lead->city_id,
                'city' => $lead->city,
                'co_applicant_name' => $lead->co_applicant_name,
                'flat_size' => $lead->flat_size,
                'waiver_code' => $lead->waiver_code,
                'booking_date' => now(),
                'booking_amount' => (float) \App\Models\FrontendSetting::getVal('booking_amount', 21100.00),
                'total_amount' => $unitPrice,
                'status' => 'Paid',
                'remarks' => null,
            ]);

            // Send Confirmation Mail
            try {
                Mail::to($lead->email)->cc('suresh5313@gmail.com')->send(new PaymentConfirmationMail($lead, $deal));
            } catch (\Exception $e) {
                Log::error('Failed to send payment confirmation email for lead ' . $lead->id . ': ' . $e->getMessage());
            }
        });
    }

    /**
     * Process failed payment.
     */
    private function processFailedPayment(Lead $lead): void
    {
        if ($lead->payment_status !== 'paid') {
            $lead->update([
                'status' => 'unpaid',
                'payment_status' => 'failed',
            ]);
        }
    }

    /**
     * Process pending payment.
     */
    private function processPendingPayment(Lead $lead): void
    {
        if ($lead->payment_status !== 'paid') {
            $lead->update([
                'status' => 'unpaid',
                'payment_status' => 'pending',
            ]);
        }
    }
}
