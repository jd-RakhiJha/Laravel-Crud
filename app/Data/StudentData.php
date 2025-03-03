<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;

class StudentData extends Data
{
    #[Required, StringType]
    public string $name;

    #[Required, Email, Unique('students', 'email')]
    public string $email;

    #[Required, StringType]
    public string $phone;
}
