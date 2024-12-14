<?php

namespace App\Http\Controllers;

use App\Interfaces\ITransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    private ITransaction $transactionInterface;
    public function __construct(ITransaction $transactionInterface)
    {
        $this->transactionInterface = $transactionInterface;
    }

    public function index(){
        $data=$this->transactionInterface->getTransactions([
            'fromDate' => Carbon::now()->subYear(10)->format('Y-m-d'),
            'toDate' => Carbon::now()->format('Y-m-d'),
        ]);
        return view("transaction",[
            "transactions"=>$data['data'],
            "meta"=>$data['meta']
        ]);
    }

    public function filter(Request $request){
        $data=$this->transactionInterface->getTransactions([
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
            'merchantId' => $request->merchantId,
            'acquirerId' => $request->acquirerId,
            'status' => $request->status,
            'paymentMethod' => $request->paymentMethod,
            'errorCode' => $request->errorCode,
            'filterField' => $request->filterField,
            'filterValue' => $request->filterValue,
            'page' => $request->page,
        ]);
        return response()->json([
            "transactions"=>$data['data'],
            "meta"=>$data['meta']
        ]);
    }

    public function show($id){
        $data=$this->transactionInterface->getTransaction($id);
        return response()->json($data);
    }

    public function report(Request $request){
        $data=$this->transactionInterface->reportTransactions([
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
        ]);
        return response()->json($data);
    }


}
