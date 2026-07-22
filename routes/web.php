<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProjectType\Index as ProjectTypeIndex;
use App\Livewire\ProjectType\Form as ProjectTypeForm;
use App\Livewire\Project\Index as ProjectIndex;
use App\Livewire\Project\Form as ProjectForm;
use App\Livewire\Lead\Index as LeadIndex;
use App\Livewire\Lead\Form as LeadForm;
use App\Livewire\Lead\Show as LeadShow;
use App\Livewire\Deal\Index as DealIndex;
use App\Livewire\Deal\Form as DealForm;
use App\Livewire\Deal\Show as DealShow;
use App\Livewire\Invoice\Index as InvoiceIndex;
use App\Livewire\Refund\Index as RefundIndex;
use App\Livewire\Flat\Index as FlatIndex;
use App\Livewire\Flat\Form as FlatForm;
use App\Livewire\StaticPage\Index as StaticPageIndex;
use App\Livewire\Inventory\Index as InventoryIndex;
use App\Livewire\Inventory\Form as InventoryForm;

use App\Livewire\Report\Purchase as PurchaseReport;
use App\Livewire\Report\Sales as SalesReport;
use App\Livewire\Report\Expense as ExpenseReport;
use App\Livewire\Report\Profit as ProfitReport;

// Frontend
use App\Livewire\Frontend\Home as Home;
use App\Livewire\Frontend\Project as FrontProject;
use App\Livewire\Frontend\Booking;
use App\Livewire\Frontend\StaticPage as FrontStaticPage;
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Cache cleared successfully!';
});

Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/dashboard', \App\Livewire\Dashboard\Index::class)
        ->middleware(['auth'])
        ->name('dashboard');


    Route::prefix('project-types')->name('project-types.')->group(function () {
        Route::get('/', ProjectTypeIndex::class)->name('index');
        Route::get('/create', ProjectTypeForm::class)->name('create');
        Route::get('/{projectType}/edit', ProjectTypeForm::class)->name('edit');
    });

    Route::prefix('flats')->name('flats.')->group(function () {
        Route::get('/', FlatIndex::class)->name('index');
        Route::get('/create', FlatForm::class)->name('create');
        Route::get('/{flat:id}/edit', FlatForm::class)->name('edit');
    });

    // Inventory
    Route::prefix('inventories')->name('inventories.')->group(function () {
        Route::get('/', InventoryIndex::class)->name('index');
        Route::get('/create', InventoryForm::class)->name('create');
        Route::get('/{inventory:id}/edit', InventoryForm::class)->name('edit');
    });

    // Projects
    Route::prefix('projects')->name('projects.')->group(function () {
        // Project Listing
        Route::get('/', ProjectIndex::class)->name('index');
        // Create Project
        Route::get('/create', ProjectForm::class)->name('create');
        // Edit Project
        Route::get('/{project:id}/edit', ProjectForm::class)->name('edit');
    });
    // Leads
    Route::prefix('leads')->name('leads.')->group(function () {
        // Lead Listing
        Route::get('/', LeadIndex::class)
            ->name('index');
        // Create Lead
        Route::get('/create', LeadForm::class)
            ->name('create');
        // View Lead
        Route::get('/{lead:id}', LeadShow::class)->name('show');
        // Edit Lead
        Route::get('/{lead:id}/edit', LeadForm::class)
            ->name('edit');
        // Download Lead Details PDF
        Route::get('/{lead:id}/download-pdf', [\App\Http\Controllers\DealDocumentController::class, 'leadPdf'])->name('download-pdf');
    });
    // Agents
    Route::prefix('agents')->name('agents.')->group(function () {
        Route::get('/', \App\Livewire\Agent\Index::class)->name('index');
        Route::get('/create', \App\Livewire\Agent\Form::class)->name('create');
        Route::get('/{agent}/edit', \App\Livewire\Agent\Form::class)->name('edit');
    });
    // Deals
    Route::prefix('deals')->name('deals.')->group(function () {
        // Deal Listing
        Route::get('/', DealIndex::class)->name('index');
        // Create Deal
        Route::get('/create', DealForm::class)->name('create');
        // Edit Deal
        Route::get('/{deal:id}/edit', DealForm::class)->name('edit');
        // View Deal Details
        Route::get('/{deal:id}', DealShow::class)->name('show');
        // Download Allotment Letter
        Route::get('/{deal:id}/allotment-letter', [\App\Http\Controllers\DealDocumentController::class, 'allotmentLetter'])->name('allotment-letter');
        // Download Demand Letter
        Route::get('/{deal:id}/demand-letter', [\App\Http\Controllers\DealDocumentController::class, 'demandLetter'])->name('demand-letter');
        // Download Deal Details PDF
        Route::get('/{deal:id}/download-pdf', [\App\Http\Controllers\DealDocumentController::class, 'dealPdf'])->name('download-pdf');
        // Allot Unit Page
        Route::get('/{deal:id}/allot', \App\Livewire\Deal\Allot::class)->name('allot');
    });
    // Invoices
    Route::prefix('invoices')->name('invoices.')->group(function () {
        // Invoice Listing
        Route::get('/', InvoiceIndex::class)->name('index');
    });
    // Refunds
    Route::prefix('refunds')->name('refunds.')->group(function () {
        // Refund Listing
        Route::get('/', RefundIndex::class)->name('index');
    });
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {

        Route::get('/purchase', PurchaseReport::class)
            ->name('purchase');

        Route::get('/sales', SalesReport::class)
            ->name('sales');

        Route::get('/expense', ExpenseReport::class)
            ->name('expense');

        Route::get('/profit', ProfitReport::class)
            ->name('profit');
    });

    Route::get('/frontend-configuration', \App\Livewire\FrontendConfiguration\Index::class)
        ->name('frontend.index');

    Route::get('/pages', StaticPageIndex::class)
        ->name('pages.index');

    Route::view('profile', 'profile')->middleware(['auth'])->name('profile');
});
Route::get('/', Home::class)->name('front');
Route::get('/terms-and-conditions', FrontStaticPage::class)
    ->defaults('slug', 'terms-and-conditions')
    ->name('pages.terms');
Route::get('/privacy-policy', FrontStaticPage::class)
    ->defaults('slug', 'privacy-policy')
    ->name('pages.privacy');
Route::get('/cancellation-refund-policy', FrontStaticPage::class)
    ->defaults('slug', 'cancellation-refund-policy')
    ->name('pages.refund-policy');
Route::get('/projects/{slug}', FrontProject::class)->name('project.show');
Route::get('/projects/{project}/registration', Booking::class)->name('booking');

// PhonePe Payment Routes
use App\Http\Controllers\PaymentController;
Route::get('/payment/phonepe/redirect', [PaymentController::class, 'redirect'])->name('phonepe.redirect');
Route::post('/payment/phonepe/callback', [PaymentController::class, 'callback'])->name('phonepe.callback');

require __DIR__ . '/auth.php';
