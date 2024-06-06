<?php

namespace App\Livewire;

use App\Models\User;
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

class UserList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public string $icon = 'users'; 
    public string $createUrl = "user.create";

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->where('role', '!=', 'super_admin'))
            ->columns([
                TextColumn::make('first_name')
                    ->label('Name')
                    ->formatStateUsing(fn (User $record) => $record->full_name)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('role')
                    ->formatStateUsing(fn (User $record) => Str::of($record->role)->replace('_', ' ')->ucfirst()),
                TextColumn::make('last_login_at')
                    ->since(),
                TextColumn::make('created_at')->since(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('edit')
                        ->icon('heroicon-s-pencil')
                        ->url(fn (User $record): string => route('user.edit', $record)),
                    DeleteAction::make('delete'),
                ])->size('sm'),
            ])
            ->emptyStateActions([
                Action::make('create')
                    ->label('Create User')
                    ->url(route('user.create'))
                    ->icon('heroicon-m-plus')
                    ->button(),
            ]);
    }

    public function delete(User $record)
    {
        $record->delete();
    }

    public function render()
    {
        return view('livewire.pages.datatable');
    }
}
