<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\StringType;

class CategoryData extends Data
{
  public function __construct(

    #[Required, StringType] public string $name,
    #[Required, StringType] public string $type

  ) {}
}
