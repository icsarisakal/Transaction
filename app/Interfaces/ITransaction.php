<?php

namespace App\Interfaces;

interface ITransaction
{
    //
    public function getTransactions($filter = null);
    public function getTransaction($id);

    public function reportTransactions($filter = null);

    public function getClient($id);

}
