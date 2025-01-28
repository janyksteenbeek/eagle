<?php

namespace App\Filament\Clusters\Settings\Pages;

use App\Filament\Clusters\Settings;
use App\Settings\GeneralSettings;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageGeneral extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationLabel = 'General';

    protected static ?string $slug = 'general';

    protected static ?string $title = 'General Settings';

    protected ?string $heading = 'General Settings';

    protected static string $settings = GeneralSettings::class;

    protected static ?string $cluster = Settings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Basics'))
                    ->description(__('This information will appear on your public pages.'))
                    ->schema([
                        //
                    ]),
                Section::make(__('Notifications'))
                    ->description(__('Select which notifications you would like to receive.'))
                    ->schema([
                        //
                    ]),
                Section::make(__('Allowlisted domains'))
                    ->description(__('These domains are allowed to access Eagle.'))
                    ->schema([
                        //
                    ]),
                Section::make(__('Branding'))
                    ->description(__('Customize your branding settings.'))
                    ->schema([
                        Grid::make()
                            ->schema([
                                ColorPicker::make('branding_from_color')
                                    ->regex('/^#([a-f0-9]{6}|[a-f0-9]{3})\b$/'),
                                ColorPicker::make('branding_via_color')
                                    ->regex('/^#([a-f0-9]{6}|[a-f0-9]{3})\b$/'),
                                ColorPicker::make('branding_to_color')
                                    ->regex('/^#([a-f0-9]{6}|[a-f0-9]{3})\b$/'),
                            ])->columns(3),
                    ]),
            ]);
    }
}
