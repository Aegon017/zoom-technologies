<?php

namespace App\Models;

use App\Mail\ScheduleUpdatedMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;

class OrderSchedule extends Model
{
    protected $fillable = [
        'order_id',
        'schedule_id',
        'admin_name',
        'admin_email',
        'ip_address',
        'proof',
    ];

    protected static function booted()
    {
        static::updated(function ($orderSchedule) {
            if ($orderSchedule->isDirty('schedule_id')) {
                $admin = Auth::user();
                $orderSchedule->admin_name = $admin->name;
                $orderSchedule->admin_email = $admin->email;
                $orderSchedule->ip_address = Request::ip();
                $user = $orderSchedule->order->user;
                $order = $orderSchedule->order;
                Mail::to($user->email)->send(new ScheduleUpdatedMail($order));
            }
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
