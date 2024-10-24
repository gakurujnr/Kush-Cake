<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    //Add [user_id] to fillable property to allow mass assignment
    protected $fillable = ['user_id', 'status', 'total_amount', 'customization_value_id'];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function Address()
    {
        return $this->belongsTo(Address::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Payments()
    {
        return $this->hasMany(Payment::class);
    }
}
