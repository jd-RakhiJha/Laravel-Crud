<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Date;

class StudentData extends Data
{
    #[Required, StringType]
    public string $name;

    #[Required, IntegerType]
    public int $age;

    #[Required, Email]
    public string $email;

    #[Required, StringType]
    public string $address;

    #[Required, Date]
    public string $enrollment_date;
}
