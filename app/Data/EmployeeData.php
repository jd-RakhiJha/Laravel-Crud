<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Max;

class EmployeeData extends Data
{
    #[Required, StringType]
    public string $name;

    #[Required, Email, StringType]
    public string $email;

    #[Required, StringType]
    public string $position;

    #[Required, Numeric]
    public float $salary;
}
