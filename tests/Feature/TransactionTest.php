<?php

use Illuminate\Support\Facades\Http;

it('returns data and meta when getting transactions', function () {
    $raw="
    {
    \"data\":[{
            \"fx\": {
                \"merchant\": {
                    \"originalAmount\": 2222,
                    \"originalCurrency\": \"EUR\",
                    \"convertedAmount\": 2222,
                    \"convertedCurrency\": \"EUR\"
                }
            },
            \"updated_at\": \"2017-07-05 07:09:22\",
            \"created_at\": \"2017-07-05 07:09:22\",
            \"transaction\": {
                \"merchant\": {
                    \"referenceNo\": \"api_595c9089c04a7\",
                    \"status\": \"APPROVED\",
                    \"message\": \"Approved\",
                    \"operation\": \"REFUND\",
                    \"type\": \"AUTH\",
                    \"customData\": null,
                    \"created_at\": \"2017-07-05 07:09:22\",
                    \"transactionId\": \"981872-1499238562-111\"
                }
            },
            \"acquirer\": {
                \"id\": 12,
                \"name\": \"Mergen Bank\",
                \"code\": \"MB\",
                \"type\": \"CREDITCARD\"
            },
            \"customerInfo\": {
                \"number\": \"401288XXXXXX1881\",
                \"email\": \"oconnor@bumin.com.tr\",
                \"billingFirstName\": \"John\",
                \"billingLastName\": \"O'Connor\"
            },
            \"merchant\": {
                \"id\": 111,
                \"name\": \"testing\",
                \"allowPartialRefund\": false,
                \"allowPartialCapture\": false
            },
            \"ipn\": {
                \"sent\": true,
                \"merchant\": {
                    \"transactionId\": \"981872-1499238562-111\",
                    \"referenceNo\": \"api_595c9089c04a7\",
                    \"amount\": 2222,
                    \"currency\": \"EUR\",
                    \"date\": 1499238562,
                    \"code\": \"00\",
                    \"message\": \"Approved\",
                    \"operation\": \"REFUND\",
                    \"type\": \"AUTH\",
                    \"status\": \"APPROVED\",
                    \"customData\": null,
                    \"chainId\": \"595c90a1bb2a6\",
                    \"paymentType\": \"CREDITCARD\",
                    \"descriptor\": \"API Dynamic Descriptor\",
                    \"token\": \"fea146f083276c3057f2962b199dd364aa2e1b6e4bbfa5b965b7470755d298f2\",
                    \"convertedAmount\": 2222,
                    \"convertedCurrency\": \"EUR\",
                    \"IPNUrl\": \"https://sandbox-checkout.rpdpymnt.com/ipn\",
                    \"ipnType\": \"MERCHANTIPN\"
                }
            }
        }],
        \"current_page\": 1,
    \"first_page_url\": \"http://sandbox-reporting.rpdpymnt.com/api/v3/transaction/list?page=1\",
    \"from\": 1,
    \"next_page_url\": null,
    \"path\": \"http://sandbox-reporting.rpdpymnt.com/api/v3/transaction/list\",
    \"per_page\": 50,
    \"prev_page_url\": null,
    \"to\": 3
    }";
    Http::fake([
        '/transaction/list' => Http::response(json_encode($raw), 200)
    ]);

    $repository = new \App\Repositories\TransactionRepository();
    $result = $repository->getTransactions();

    expect($result)->toHaveKeys(['data', 'meta']);
    expect($result['data'])->toHaveCount(1);
});

it('handles empty response when getting transactions', function () {
    $raw="
    {
    \"data\":[],
        \"current_page\": 1,
    \"first_page_url\": \"http://sandbox-reporting.rpdpymnt.com/api/v3/transaction/list?page=1\",
    \"from\": 1,
    \"next_page_url\": null,
    \"path\": \"http://sandbox-reporting.rpdpymnt.com/api/v3/transaction/list\",
    \"per_page\": 50,
    \"prev_page_url\": null,
    \"to\": 3
    }";
    Http::fake([
        '/transaction/list' => Http::response($raw, 200)
    ]);

    $repository = new \App\Repositories\TransactionRepository();
    $result = $repository->getTransactions();
    expect($result)->toHaveKeys(['data', 'meta']);
    expect($result['data']['data'])->toBeEmpty();
});

it('returns transaction data when getting a transaction', function () {
    Http::fake([
        '/transaction' => Http::response(['id' => 1, 'amount' => 100], 200)
    ]);

    $repository = new \App\Repositories\TransactionRepository();
    $result = $repository->getTransaction(1);

    expect($result['id'])->toBe(1);
    expect($result['amount'])->toBe(100);
});

it('returns report data when reporting transactions', function () {
    Http::fake([
        '/transactions/report' => Http::response([
            'response' => [
                ['currency' => 'USD', 'total' => 1000, 'count' => 10],
                ['currency' => 'EUR', 'total' => 2000, 'count' => 20],
            ],
            'status' => 'success'
        ], 200)
    ]);

    $repository = new \App\Repositories\TransactionRepository();
    $result = $repository->reportTransactions();

    expect($result)->toHaveKeys(['raw', 'proceeds']);
    expect($result['proceeds']['labels'])->toBe(['USD', 'EUR']);
    expect($result['proceeds']['values'])->toBe([1000, 2000]);
    expect($result['proceeds']['counts'])->toBe([10, 20]);
});
