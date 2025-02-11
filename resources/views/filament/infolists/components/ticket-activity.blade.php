@use(App\Enums\Tickets\TicketPriority)
@use(App\Enums\Tickets\TicketType)
@use(App\Enums\Tickets\TicketStatus)

@php
    $enumMap = [
        'status'   => TicketStatus::class,
        'priority' => TicketPriority::class,
        'type'     => TicketType::class,
    ];

    $activities = $getRecord()->activity()
        ->with('user')
        ->whereIn('column', array_keys($enumMap))
        ->get();
@endphp

<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        <ul class="flex flex-col space-y-4">
            @foreach($activities as $ticketActivity)
                @php
                    $enumClass = $enumMap[$ticketActivity->column->value];
                    $enumInstance = $enumClass::from($ticketActivity->value);
                    $color = method_exists($enumInstance, 'getColor') ? $enumInstance->getColor() : null;
                    $icon = method_exists($enumInstance, 'getIcon') ? $enumInstance->getIcon() : null;
                    $causer = $ticketActivity->user ? $ticketActivity->user->name : 'System';
                @endphp

                <li>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm">
                            {!! __(':name changed ticket :column to', [
                                'name'   => '<strong>' . $causer . '</strong>',
                                'column' => $ticketActivity->column->value,
                            ]) !!}
                        </span>

                        <x-filament::badge :color="$color" :icon="$icon" class="inline-block">
                            {{ $enumInstance->getLabel() }}
                        </x-filament::badge>
                    </div>

                    <p class="text-sm text-gray-500">{{ $ticketActivity->reason }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</x-dynamic-component>
