<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;

class PaymentData extends Data
{

    #[Required, Numeric]
    public float $amount;

    #[Required, StringType]
    public string $payment_method;

    #[Required, StringType]
    public string $status;
}
