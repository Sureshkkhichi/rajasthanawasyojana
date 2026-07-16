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
        'in_process' => 'In Process',
        'unpaid' => 'Unpaid',
        'paid' => 'Paid',
    ],
    'lead_status_colors' => [
        'in_process' => 'primary',
        'unpaid' => 'warning',
        'paid' => 'success',
    ],
    'payment_statuses' => [
        'paid' => 'Paid',
        'unpaid' => 'Unpaid',
        'failed' => 'Failed',
        'refunded' => 'Refund',
        'partial' => 'Partial',
    ],
    'occupations' => [
        'State Govt. Employee' => 'State Govt. Employee',
        'Center Govt. Employee' => 'Center Govt. Employee',
        'Army/Force' => 'Army/Force',
        'Private Salary Employee' => 'Private Salary Employee',
        'self Employee' => 'Self Employeed',
        'Other' => 'Other',
    ],
];