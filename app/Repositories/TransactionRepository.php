<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class TransactionRepository implements \App\Interfaces\ITransaction
{

    public function getTransactions($filter = null)
    {
        // TODO: Implement getTransactions() method.
        $data=Http::financial()->post('/transactions/list', [
            'fromDate' => $filter['fromDate'],
            'toDate' => $filter['toDate'],
            'merchantId' => $filter['merchantId'],
            'acquirerId' => $filter['acquirerId'],
            'status' => $filter['status'],
            'paymentMethod' => $filter['paymentMethod'],
            'errorCode' => $filter['errorCode'],
            'filterField' => $filter['filterField'],
            'filterValue' => $filter['filterValue'],
            'page' => $filter['page'],
            'perPage' => $filter['perPage'],
        ]);
        return $data->json();
    }

    public function getTransaction($id)
    {
        // TODO: Implement getTransaction() method.
    }

    public function reportTransactions($filter = null)
    {
        // TODO: Implement reportTransactions() method.
    }

    public function getClient($id)
    {
        // TODO: Implement getClient() method.
    }
}
