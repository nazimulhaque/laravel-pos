<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Department extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::user();
            $model->created_by = $user->first_name . ' ' . $user->last_name;
            $model->last_modified_by = $user->first_name . ' ' . $user->last_name;
            $model->record_status = 1;
        });

        static::updating(function ($model) {
            $user = Auth::user();
            $model->last_modified_by = $user->first_name . ' ' . $user->last_name;
        });

        static::deleting(function ($model) {
            // $model->photos()->delete();
            // do the rest of the cleanup...
        });
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'department';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'department_id';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_modified_date';

    protected $fillable = [
        'department_name',
        'parent_department_id',
        'description'
    ];
}
