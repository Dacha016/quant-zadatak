<?php

namespace App\Adapters;

use App\Interfaces\Card;
use App\Interfaces\Payment;

class PaymentAdapter implements Payment
{

    private Card $card;

    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    public function pay()
    {
        $this->card->pay();
    }

    public function isValid()
    {

        $this->card->isValid();
        $this->card->update($_SESSION["id"]);
    }
}