<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasUuids, HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        '*',
    ];

    protected function casts(): array
    {
        return [
            'read' => 'boolean',
        ];
    }
}
