<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SearchHistory extends Model
{
    use HasFactory;

    protected function SearchTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('d-m-Y h:i:s A', strtotime($this->attributes['search_time'])),
        );
    }
}
