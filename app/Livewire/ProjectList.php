<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
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

class ProjectList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;


    public string $icon = "building-2";
    public string $createUrl = "project.create";
    
    public function table(Table $table): Table
    {
        return $table
            ->query(Project::query()->filterByRole(auth()->user()))
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('developer.name')->searchable()->label('Developer')->badge(),
                TextColumn::make('created_at')->since(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('edit')
                        ->icon('heroicon-s-pencil')
                        ->url(fn (Project $record): string => route('project.edit', $record)),
                    DeleteAction::make('delete'),
                ])->size('sm'),
            ])
            ->emptyStateActions([
                Action::make('create')
                    ->label('Create project')
                    ->url(route($this->createUrl))
                    ->icon('heroicon-m-plus')
                    ->button(),
            ]);
    }

    public function delete(Project $record)
    {
        $record->delete();
    }

    public function render()
    {
        return view('livewire.pages.datatable');
    }
}
