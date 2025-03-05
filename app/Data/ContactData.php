<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Exists;

class ContactData extends Data
{
    #[Required, StringType]
    public string $email;

    #[Required, StringType]
    public string $phone;

    #[Required, StringType]
    public string $address;

    #[Required, IntegerType, Exists('users', 'id')]
    public int $user_id;
}
