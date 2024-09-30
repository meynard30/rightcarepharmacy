<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price'];

    // Relationship to the user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
