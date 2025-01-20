<?php

namespace App\Models;

use App\Enums\Tickets\TicketSlaStatus;
use App\Enums\Tickets\TicketSlaType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class TicketSla extends Model
{
    use HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ticket_id',
        'group_id',
        'type',
        'started_at',
        'expires_at',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => TicketSlaType::class,
            'started_at' => 'datetime',
            'expires_at' => 'datetime',
            'status' => TicketSlaStatus::class,
        ];
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
