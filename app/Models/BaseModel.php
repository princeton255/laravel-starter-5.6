<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class BaseModel extends Model
{
    use Filterable;

    /**
     * Scope to get all rows filtered, sorted and paginated.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $sort
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCollect ($query, $sort = 'name')
    {
        $request = request();

        // Apply pagination
        $limit = $request->get('limit', 25);

        return $query->filter($request->all())
            ->latest()
            // ->sortable($sort)
            ->paginate($limit);
    }

    public function modelFilter()
    {
        // Check if is api or web
        $request = request();

        list($file, $folder) = array_reverse(explode('\\', explode('@', $request->route()->getActionName())[0]));
        $file = str_replace('Controller', 'Filter', $file);

        if (empty($folder) || empty($file)) {
            return $this->provideFilter();
        }

        $class = '\\App\\Filters\\' . ucfirst($folder) . '\\' . ucfirst($file);

        return $this->provideFilter($class);
    }
}
