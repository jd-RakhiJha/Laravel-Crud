<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\BooleanType;

class SectionData extends Data
{
    #[Required, IntegerType]
    public int $class_id;

    #[Required, StringType]
    public string $name;

    #[Required, IntegerType]
    public int $capacity;

    #[Required, BooleanType]
    public bool $status;
}
