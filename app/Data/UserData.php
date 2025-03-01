<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UserData extends Data
{
  #[Required, StringType]
  public string $name;

  #[Required, StringType]
  public string $email;
}
