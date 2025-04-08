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

    #[Required, StringType]
    public string $phone;

    #[Required, Date]
    public string $dob;

    #[Required, Email]
    public string $email;

    #[Required, StringType]
    public string $address;

    #[Required, IntegerType]
    public int $section_id;

    #[Required, IntegerType]
    public int $class_id;
}
