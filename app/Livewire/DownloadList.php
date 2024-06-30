<?php

namespace App\Livewire;

use App\Models\Video;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class DownloadList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public string $icon = 'download';

    public function table(Table $table): Table
    {
        return $table
            ->query(Video::query()
                ->with('camera', 'camera.project', 'user')
                ->where('status', 'completed')
                ->filterByRole(auth()->user())
            )
            ->columns([
                TextColumn::make('camera.name')
                    ->label('Camera')
                    ->badge()
                    ->searchable(),
                TextColumn::make('camera.project.name')
                    ->label('Project')
                    ->badge()
                    ->searchable(),
                TextColumn::make('user.full_name')
                    ->label('Created By')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
            ])
            ->actions([
                Action::make('download')
                    ->view('filament.pages.download-page-download-action')
            ]);
    }

    public function render()
    {
        return view('livewire.pages.datatable');
    }
}
