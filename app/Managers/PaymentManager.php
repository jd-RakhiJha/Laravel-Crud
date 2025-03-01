<?php

namespace App\Managers;

use App\Repositories\Payment\PaymentRepository;


class PaymentManager
{
    protected PaymentRepository $payments;

    public function __construct()
    {
        $this->payments = new PaymentRepository;
    }
}
