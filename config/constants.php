<?php
return [
    'site_name' => 'JDA - Rajasthan Awas Yojana',
    'site_description' => 'A comprehensive housing scheme for the residents of Rajasthan, providing affordable and quality housing solutions to improve the living standards of the people.',
    'site_author' => 'Suresh Khichi',
    'copyright' => "Copyright " . date('Y') . " © " . config('constants.site_name') . ". All right reserved.",
    'project_status' => [
        'upcoming' => 'Upcoming',
        'active' => 'Active',
        'completed' => 'Completed',
        'hold' => 'Hold',
        'cancelled' => 'Cancelled'
    ],
    'lead_statuses' => [
        'awaiting_closed' => 'Awaiting/Closed',
        'in_process' => 'In Process',
        'cancelled' => 'Cancelled',
        'site_visited' => 'Site Visited',
        'document_collected' => 'Document Collected',
    ],
    'lead_status_colors' => [
        'awaiting_closed' => 'secondary',
        'in_process' => 'primary',
        'cancelled' => 'danger',
        'site_visited' => 'warning',
        'document_collected' => 'success',
    ],
    'payment_statuses' => [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'failed' => 'Failed',
    ],
];