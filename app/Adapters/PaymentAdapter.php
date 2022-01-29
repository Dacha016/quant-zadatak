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
       if ( $this->card->pay()) {
       return true;
       }
       return false;
    }

    public function isValid()
    {
        if ($this->card->isValid()) {
            return true;
        } else {
            return false;
        }


    }
}