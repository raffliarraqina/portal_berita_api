<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // protected $guarded[];
    // protected $fillable[];

    protected $fillable = [
        'name', 'phone', 'address'
    ];
}
