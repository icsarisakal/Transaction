<?php

namespace App\Repositories;

use App\Http\Resources\TransactionMetaResource;
use App\Http\Resources\TransactionResource;
use Illuminate\Support\Facades\Http;

class TransactionRepository implements \App\Interfaces\ITransaction
{

    public function getTransactions($filter = null)
    {

        $data = Http::financial()->post('/transaction/list', [
            'fromDate' => $filter['fromDate'] ?? '',
            'toDate' => $filter['toDate'] ?? '',
            'merchantId' => $filter['merchantId'] ?? '',
            'acquirerId' => $filter['acquirerId'] ?? '',
            'status' => $filter['status'] ?? '',
            'paymentMethod' => $filter['paymentMethod'] ?? '',
            'errorCode' => $filter['errorCode'] ?? '',
            'filterField' => $filter['filterField'] ?? '',
            'filterValue' => $filter['filterValue'] ?? '',
            'page' => $filter['page'] ?? '',
        ]);
        $dataResp = $data->json();
        try {
            return [
                'data' => TransactionResource::collection($dataResp['data'] ?? [])->response()->getData(true),
                'meta' => (new TransactionMetaResource($dataResp))->response()->getData(true)
            ];
        } catch (\Exception $e) {
            dd($e,$dataResp);
        }
    }

    public function getTransaction($id)
    {
        $data = Http::financial()->post('/transaction', [
            'transactionId' => $id ?? ''
        ]);
        return $data->json();
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
