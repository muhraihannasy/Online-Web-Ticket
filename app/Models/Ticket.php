<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Casts\MoneyCast;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'seller_id',
        'name',
        'slug',
        'thumbnail',
        'path_video',
        'about',
        'price',
        'open_at_time',
        'closed_at_time',
        'is_popular',
        'address',
    ];

    public function setNameAttribute($value) {
       $this->attributes['name'] = $value;
       $this->attributes['slug'] = \Str::slug($value);

       return $this;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function photos()
    {
        return $this->hasMany(TicketPhoto::class);
    }
}
