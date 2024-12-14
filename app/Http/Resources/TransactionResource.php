<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "transactionId" => $this["transaction"]["merchant"]["transactionId"]??"",
            "transactionReferenceNo" => $this["transaction"]["merchant"]["referenceNo"]??"",
            "transactionOperation" => $this["transaction"]["merchant"]["operation"]??"",
            "acquirerName" => $this["acquirer"]["name"]??"",
            "customerEmail" => !empty($this["customerInfo"])?$this["customerInfo"]["email"]??"":"",
            "customerName" => !empty($this["customerInfo"])?$this["customerInfo"]["billingFirstName"]?? " " . $this["customerInfo"]["billingLastName"]??"":"",
            "merchantName" => $this["merchant"]["name"]??"",
            "merchantAmount" => $this["fx"]["merchant"]["convertedAmount"]??"" . $this["fx"]["merchant"]["convertedCurrency"]??"",

        ];
    }
}
