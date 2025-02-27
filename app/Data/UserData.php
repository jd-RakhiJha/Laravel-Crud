<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Required;

class UserData extends Data
{
  public function __construct(
    //
    #[Required, StringType]
    public string $name,

    #[Required, StringType]
    public string $email,

  ) {}
}
