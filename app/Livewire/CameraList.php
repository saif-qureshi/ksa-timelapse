<?php

namespace App\Livewire;

use App\Models\Camera;
use Livewire\Component;
use Illuminate\Support\Str;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class CameraList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public string $icon = 'cctv';
    public string $createUrl = "camera.create";

    public function table(Table $table): Table
    {
        return $table
            ->query(Camera::query()->filterByRole(auth()->user()))
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('project.name')->searchable()->label('Project')->badge(),
                TextColumn::make('developer.name')->searchable()->label('Developer')->badge(),
                TextColumn::make('access_token')
                    ->copyable()
                    ->copyMessage('Access token copied')
                    ->label('Access Token')
                    ->formatStateUsing(fn (Camera $record) => Str::mask($record->access_token, '*', 6, 40,)),
                TextColumn::make('latitude'),
                TextColumn::make('longitude'),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('edit')
                        ->icon('heroicon-s-pencil')
                        ->url(fn (Camera $record): string => route('camera.edit', $record)),
                    DeleteAction::make('delete'),
                    // Action::make('refresh')
                    //     ->label('Refresh Token')
                    //     ->icon('heroicon-s-arrow-path')
                    //     ->requiresConfirmation()
                    //     ->action(fn (Camera $record) => $record->refreshAccessToken()),

                ])->size('sm'),
            ])
            ->emptyStateActions([
                Action::make('create')
                    ->label('Create camera')
                    ->url(route('camera.create'))
                    ->icon('heroicon-m-plus')
                    ->button(),
            ]);
    }

    public function delete(Camera $record)
    {
        $record->delete();
    }

    public function render()
    {
        return view('livewire.pages.datatable');
    }
}
