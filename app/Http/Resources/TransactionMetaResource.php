<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionMetaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'currentPage' => $this['current_page']??0,
            'from' => $this['from']??1,
            'to' => $this['to']??1,
            'nextPageUrl' => $this['next_page_url']??null,
            'prevPageUrl' => $this['prev_page_url']??null,
            'perPage' => $this['per_page']??null
        ];
    }
}
