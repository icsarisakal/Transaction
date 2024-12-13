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
        return view("transaction",[
            "transactions"=>$this->transactionInterface->getTransactions([
                'fromDate' => Carbon::now()->subYear(3)->format('Y-m-d'),
                'toDate' => Carbon::now()->format('Y-m-d'),
            ])
        ]);
    }
}
