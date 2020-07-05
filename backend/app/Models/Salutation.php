<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Salutation extends Model
{
    use HasTranslations;

    protected $translatable = ['prefix', 'name', 'gender'];
}
