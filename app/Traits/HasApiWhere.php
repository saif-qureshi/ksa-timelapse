<?php

namespace App\Traits;

use App\Models\Bundle;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Builder|Bundle applyWhere($array)
 */
trait HasApiWhere
{
    public static function scopeApplyWhere($query, $wheres = [], $isFilter = false)
    {
        if (count((array)$wheres)) {
            $query->where(function ($q) use ($wheres, $isFilter) {
                $whereType = $isFilter ? 'where' : "orWhere";

                foreach ($wheres as $key => $where) {
                    $search = $where['value'];

                    if ($where['operator'] === 'like') {
                        $search = "%$search%";
                    }

                    $wh = explode('.', $key);

                    if (count($wh) > 1) {
                        $q->orWhereHas($wh[0], function ($wHQ) use ($wh, $where, $search) {

                            if (isset($wh[2])) {
                                $wHQ->orWhereHas($wh[1], function ($wHQHQ) use ($wh, $where, $search) {
                                    $wHQHQ->where(
                                        $wh[2],
                                        $where['operator'],
                                        $search
                                    );
                                });
                            } else {
                                $wHQ->where(
                                    $wh[1],
                                    $where['operator'],
                                    $search
                                );
                            }

                        });
                        continue;
                    }


                    $q->$whereType(
                        $key,
                        $where['operator'],
                        $search
                    );
                }
            });
        }

        return $query;
    }
}
