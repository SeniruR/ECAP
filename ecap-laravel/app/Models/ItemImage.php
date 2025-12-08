<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
    use HasFactory;

    protected $table = 'itemimages';
    protected $primaryKey = 'no';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'image',
        'itemno',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemno', 'no');
    }
}
