<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\StringType;

class ProductData extends Data
{
  public function __construct(
    #[Required, StringType]
    public string $name,

    #[Required, Numeric]
    public float $price,

    #[StringType]
    public ?string $description = null

  ) {}
}
