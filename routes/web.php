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
use App\Livewire\Invoice\Index as InvoiceIndex;
use App\Livewire\Refund\Index as RefundIndex;
use App\Livewire\HomeSlider\Index as HomeSliderIndex;
use App\Livewire\HomeSlider\Form as HomeSliderForm;
use App\Livewire\Report\Purchase as PurchaseReport;
use App\Livewire\Report\Sales as SalesReport;
use App\Livewire\Report\Expense as ExpenseReport;
use App\Livewire\Report\Profit as ProfitReport;

// Frontend
use App\Livewire\Frontend\Home as Home;
use App\Livewire\Frontend\Project as FrontProject;
use App\Livewire\Frontend\Booking;
// Route::view('/', 'welcome')->name('front');
Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/dashboard', \App\Livewire\Dashboard\Index::class)
        ->middleware(['auth'])
        ->name('dashboard');


    Route::prefix('project-types')->name('project-types.')->group(function () {
        Route::get('/', ProjectTypeIndex::class)->name('index');
        Route::get('/create', ProjectTypeForm::class)->name('create');
        Route::get('/{projectType}/edit', ProjectTypeForm::class)->name('edit');
    });
    // Home Slider
    Route::prefix('home-sliders')->name('home-sliders.')->group(function () {
        // HomeSlider Listing
        Route::get('/', HomeSliderIndex::class)->name('index');
        // Create HomeSlider
        Route::get('/create', HomeSliderForm::class)->name('create');
        // Edit HomeSlider
        Route::get('/{homeSlider:id}/edit', HomeSliderForm::class)->name('edit');
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
    });
    // Deals
    Route::prefix('deals')->name('deals.')->group(function () {
        // Deal Listing
        Route::get('/', DealIndex::class)->name('index');
        // Create Deal
        Route::get('/create', DealForm::class)->name('create');
        // Edit Deal
        Route::get('/{deal:id}/edit', DealForm::class)->name('edit');
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

    Route::view('profile', 'profile')->middleware(['auth'])->name('profile');
});
Route::get('/', Home::class)->name('front');
Route::get('/projects/{slug}', FrontProject::class)->name('project.show');
Route::get('/projects/{project}/registration', Booking::class)->name('booking');
require __DIR__ . '/auth.php';
