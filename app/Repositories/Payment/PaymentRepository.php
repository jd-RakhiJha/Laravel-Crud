<?php

namespace App\Repositories\Payment;

use App\Models\Payment;
use App\Data\PaymentData;
use Illuminate\Support\Collection;

class PaymentRepository
{
    public function all(): Collection
    {
        return Payment::all();
    }

    public function findById(int $id): ?Payment
    {
        return Payment::find($id);
    }

    public function create(PaymentData $paymentData): Payment
    {
        return Payment::create($paymentData->toArray());
    }

    public function update(Payment $payment, PaymentData $paymentData): Payment
    {
        $payment->update($paymentData->toArray());
        return $payment;
    }

    public function delete($id): bool
    {
        return Payment::destroy($id);
    }
}
