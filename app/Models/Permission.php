<?php

namespace App\Models;

use Shanmuga\LaravelEntrust\Models\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $fillable = ['name', 'display_name', 'description', 'parent_id', 'order_index'];

    public function hasRole($roleName)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $roleName) {
                return true;
            }
        }
        return false;
    }

    public function parent()
    {
        return $this->belongsTo(Permission::class, 'parent_id')->orderBy('order_index', 'ASC');
    }

    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id')->orderBy('order_index', 'ASC');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('display_name', 'like', '%' . $search . '%');
            });
        });
    }
}
