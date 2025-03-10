<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CacheLock extends Model
{
    protected $table = 'cache_locks';
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'key', 'owner', 'expiration'
    ];
}