<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_done',
        'project_id',
    ];

    protected $casts = [
        'is_done' => 'boolean',
    ];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project() :BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    protected static function booted()
    {
        static::addGlobalScope('member', function(Builder $builder){
            $builder->where('user_id', Auth::id())->orWhereIn('project_id', Auth::user()->memberships->pluck('id'));
        });
    }
}
