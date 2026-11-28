<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'user_id',
        'status',
        'delivery_address',
        'notes',
        'loaded_unit_photo',
        'delivery_receipt_photo',
        'is_deleted',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Order $order) {
            $order->is_deleted = true;
            $order->saveQuietly();
        });

        static::restoring(function (Order $order) {
            $order->is_deleted = false;
            $order->saveQuietly();
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}