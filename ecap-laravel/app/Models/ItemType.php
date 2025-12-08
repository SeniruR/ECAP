<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use HasFactory;

    protected $table = 'itemtypes';
    protected $primaryKey = 'no';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'inactive_status',
        'short_discription',
        'discription',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'type', 'no');
    }
}
