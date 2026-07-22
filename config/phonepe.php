<?php

return [
    'env' => env('PHONEPE_ENV', 'sandbox'), // sandbox or production
    'merchant_id' => env('PHONEPE_MERCHANT_ID', 'PGTESTPAYUAT86'),
    'salt_key' => env('PHONEPE_SALT_KEY', '96434309-7796-489d-8924-ab56988a6076'),
    'salt_index' => env('PHONEPE_SALT_INDEX', '1'),
    'pay_url' => env('PHONEPE_ENV', 'sandbox') === 'production' 
        ? 'https://api.phonepe.com/apis/hermes/pg/v1/pay' 
        : 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay',
    'status_url' => env('PHONEPE_ENV', 'sandbox') === 'production'
        ? 'https://api.phonepe.com/apis/hermes/pg/v1/status'
        : 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status',
];
