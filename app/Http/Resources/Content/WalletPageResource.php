<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text_hello' => $this->text_hello,
            'title_main_balance' => $this->title_main_balance,
            'label_withdraw' => $this->label_withdraw,
            'label_transfer' => $this->label_transfer,
            'title_latest_transactions' => $this->title_latest_transactions,
            'button_view_all' => $this->button_view_all,
        ];
    }
}
