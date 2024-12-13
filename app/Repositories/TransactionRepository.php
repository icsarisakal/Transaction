<?php

namespace App\Repositories;

use App\Http\Resources\TransactionResource;
use Illuminate\Support\Facades\Http;

class TransactionRepository implements \App\Interfaces\ITransaction
{

    public function getTransactions($filter = null)
    {

        // TODO: Implement getTransactions() method.
        $data=Http::financial()->post('/transaction/list', [
            'fromDate' => $filter['fromDate']??'',
            'toDate' => $filter['toDate']??'',
            'merchantId' => $filter['merchantId']??'',
            'acquirerId' => $filter['acquirerId']??'',
            'status' => $filter['status']??'',
            'paymentMethod' => $filter['paymentMethod']??'',
            'errorCode' => $filter['errorCode']??'',
            'filterField' => $filter['filterField']??'',
            'filterValue' => $filter['filterValue']??'',
            'page' => $filter['page']??'',
            'perPage' => $filter['perPage']??'',
        ]);
        return TransactionResource::collection($data->json()["data"]??[])->response()->getData(true);
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
