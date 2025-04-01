<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\BooleanType;

class ClassesData extends Data
{
    #[Required, StringType]
    public string $name;

    #[StringType]
    public ?string $description;

    #[Required, Date]
    public string $start_date;

    #[Required, Date]
    public string $end_date;

    #[Required, BooleanType]
    public bool $status;
}
