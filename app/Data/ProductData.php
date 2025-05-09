<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\StringType;

class ProductData extends Data
{
  #[Required, StringType]
  public string $name;

  #[Required, Numeric]
  public float $price;

  #[StringType]
  public ?string $description = null;
}
