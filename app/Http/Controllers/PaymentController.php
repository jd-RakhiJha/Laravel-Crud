<?php

namespace App\Http\Controllers;

use App\Data\PaymentData;
use App\Models\Payment;
use App\Repositories\Payment\PaymentRepository;
use App\Models\User;


class PaymentController extends Controller
{
    public function __construct(private PaymentRepository $payments) {}

    public function index()
    {
        return $this->payments->all();
    }

    public function show(Payment $payment)
    {
        return $this->payments->findById($payment->id);
    }

    public function store(PaymentData $paymentData)
    {
        return $this->payments->create($paymentData);
    }

    public function update(Payment $payment, PaymentData $paymentData)
    {
        return $this->payments->update($payment, $paymentData);
    }

    public function destroy(Payment $payment)
    {
        return $this->payments->delete($payment->id);
    }

    public function getUserPayments(User $user, Payment $payments)
    {
        $payments = $payments->getUserPayments($user->id);
        return $payments;
    }
}
