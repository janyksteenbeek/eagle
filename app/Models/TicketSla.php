<?php

namespace App\Models;

use App\Enums\Tickets\TicketSlaStatus;
use App\Enums\Tickets\TicketSlaType;
use App\Settings\WorkflowSettings;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * The ticket that the SLA belongs to.
     *
     * @return BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * The group that the SLA belongs to.
     *
     * @return BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function createSlas(WorkflowSettings $workflowSettings)
    {
        $slaPolicies = collect($workflowSettings->sla_policies);

        $slaPolicy = $slaPolicies->firstWhere('priority', $this->priority);

        $this->slas()->createMany([[
            'group_id' => $this->group_id,
            'type' => TicketSlaType::INITIAL_RESPONSE,
            'started_at' => now(),
            'expires_at' => now()->addMinutes($slaPolicy['first_response_time']),
        ], [
            'group_id' => $this->group_id,
            'type' => TicketSlaType::NEXT_RESPONSE,
            'started_at' => now(),
            'expires_at' => now()->addMinutes($slaPolicy['every_response_time']),
        ], [
            'group_id' => $this->group_id,
            'type' => TicketSlaType::RESOLUTION,
            'started_at' => now(),
            'expires_at' => now()->addMinutes($slaPolicy['resolution_time']),
        ]]);
    }

    /**
     * Close the SLA.
     *
     * @return void
     */
    public function close()
    {
        $this->update([
            'status' => TicketSlaStatus::CLOSED,
        ]);
    }
}
