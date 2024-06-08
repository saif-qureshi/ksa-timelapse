<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Str;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class CommentList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public string $icon = 'message-square-text';

    public function table(Table $table): Table
    {
        return $table
            ->query(Comment::query()->with('user', 'photo'))
            ->columns([
                TextColumn::make('user.full_name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('photo.image'),
                TextColumn::make('message')->searchable()->label('Comment'),
                TextColumn::make('photo.camera.name')->searchable()->label('Camera')->badge(),
                IconColumn::make('is_approved')
                    ->label('Approved')
                    ->boolean()
            ])
            ->actions([
                Action::make('approve')
                    ->visible(fn (Comment $record) => ! $record->is_approved)
                    ->icon('heroicon-s-check')
                    ->requiresConfirmation()
                    ->action(fn (Comment $record) => $record->update(['is_approved' => true])),
            ]);
    }

    public function render()
    {
        return view('livewire.pages.datatable');
    }
}
