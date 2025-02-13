<?php

namespace App\Models;

use App\Models\HelpCenter\FormField;
use App\Observers\TicketFieldObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([TicketFieldObserver::class])]
class TicketField extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFieldFactory> */
    use HasFactory, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ticket_id',
        'form_field_id',
        'value',
        'sort',
    ];

    /**
     * TicketField belongs to a Ticket.
     *
     * @return BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * TicketField belongs to a FormField.
     *
     * @return BelongsTo
     */
    public function formField()
    {
        return $this->belongsTo(FormField::class);
    }
}
