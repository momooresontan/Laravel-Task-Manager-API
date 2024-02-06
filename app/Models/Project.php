<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function tasks() :HasMany
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members() :BelongsToMany
    {
        return $this->belongsToMany(User::class, Member::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('user', function(Builder $builder){
            $builder->where('user_id', Auth::id());
        });
    }
}
