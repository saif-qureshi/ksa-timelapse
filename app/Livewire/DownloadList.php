<?php

namespace App\Livewire;

use App\Models\Video;
use Livewire\Component;
use Illuminate\Support\Str;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class DownloadList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public string $icon = 'download';

    public function table(Table $table): Table
    {
        return $table
            ->query(Video::query()->with('camera', 'camera.project', 'user')->where('status', '!=', 'failed')->filterByRole(auth()->user()))
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
                    ->label('Download')
                    ->action(fn (Video $record) => $this->download($record))
                    ->button(),
            ]);
    }

    public function download(Video $record)
    {
        return response()->streamDownload(function () use ($record) {
            $stream = Storage::readStream($record->file);
            fpassthru($stream);
            fclose($stream);
        }, Str::replace('videos/', '', $record->file));
    }

    public function render()
    {
        return view('livewire.pages.datatable');
    }
}
