<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $primaryKey = 'no';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'short_dis',
        'long_dis',
        'type',
        'inactive_status',
        'content',
        'benefits',
        'trademark',
        'price',
        'created',
    ];

    protected $casts = [
        'inactive_status' => 'boolean',
        'created' => 'datetime',
    ];

    public function itemType()
    {
        return $this->belongsTo(ItemType::class, 'type', 'no');
    }

    public function images()
    {
        return $this->hasMany(ItemImage::class, 'itemno', 'no')->orderBy('no');
    }

    public function itemImage()
    {
        return $this->hasMany(ItemImage::class, 'itemno', 'no')->orderBy('no');
    }
}
