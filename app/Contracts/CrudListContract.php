<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface CrudListContract
{
    public function getTableName(): string;

    public function getWith(): string|array|null;

    public function getExtraQuery($query): ?Builder;

    public function getSearchOptions(): array;

    public function buildFilters(): array;

    public function buildTable(): array;

    public function hasPagination(): bool;

    public function getPerPageOptions(): array;
}
