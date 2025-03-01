<?php

namespace App\Repositories\Payment;

use App\Models\Payment;
use App\Data\PaymentData;
use Illuminate\Support\Collection;

class PaymentRepository
{
    public function all()
    {
        return Payment::all();
    }

    public function findById($id)
    {
        return Payment::findOrFail($id);
    }

    public function create(PaymentData $paymentData)
    {
        return Payment::create($paymentData->toArray());
    }

    public function update(Payment $payment, PaymentData $paymentData)
    {
        $payment->update($paymentData->toArray());
        return $payment;
    }

    public function delete($id)
    {
        return Payment::destroy($id);
    }
}
