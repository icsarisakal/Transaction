<?php

namespace App\Repositories;

use App\Http\Resources\TransactionMetaResource;
use App\Http\Resources\TransactionResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class TransactionRepository implements \App\Interfaces\ITransaction
{

    public function getTransactions($filter = null)
    {
        $data = Http::financial()->post('/transaction/list', [
            'fromDate' => $filter['fromDate'] ?? '',
            'toDate' => $filter['toDate'] ?? '',
            'merchant' => $filter['merchantId'] ?? '',
            'acquirer' => $filter['acquirerId'] ?? '',
            "operation" => isset($filter['operation'])&&!is_null($filter['operation']) ?[$filter['operation']]: null,
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
        $data = Http::financial()->post('/transactions/report', [
            'fromDate' => $filter['fromDate'] ?? '',
            'toDate' => $filter['toDate'] ?? '',
        ]);
        $dataResp = $data->json();
        $labels = [];
        $values = [];
        $counts = [];
        Arr::map($dataResp['response'], function ($item) use (&$labels, &$values, &$counts) {
            $labels[] = $item['currency'];
            $values[] = $item['total'];
            $counts[] = $item['count'];
        });
        return [
            "raw" => $dataResp,
            "proceeds"=>[
                "labels"=>$labels,
                "values"=>$values,
                "counts"=>$counts
            ],
            "status"=>$dataResp['status']??[],
        ];
    }

    public function getClient($id)
    {
        // TODO: Implement getClient() method.
    }
}
