<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cache extends Model
{
    protected $table = 'cache';
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'key', 'value', 'expiration'
    ];
}