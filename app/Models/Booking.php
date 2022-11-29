<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_CONFIRMED = 1;
    public const STATUS_CANCELED = 2;
    public const STATUS_RESERVED = 3;

    public const ALL_STATUS = [
        self::STATUS_CONFIRMED,
        self::STATUS_CANCELED,
        self::STATUS_RESERVED,
    ];

    protected $fillable = [
        'room_id',
        'user_id',
        'check_in',
        'status'
    ];

    protected $dates = [
        'check_in'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Скоуп для лимитированного вывода
     *
     * @param $q
     * @return void
     */
    public function scopeUserLimit($q): void
    {
        $limit = request('limit', 10);
        $offset = request('offset', 0);

        $q->take($limit)
            ->offset(($offset - 1) * $limit);
    }

    public function scopeFilter($q)
    {
        $q->when(request('status'), static fn($q, $status) => $q->whereStatus($status));
    }
}
