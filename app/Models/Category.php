<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','user_id']; 

    protected static function booted()
    {
        static::addGlobalScope('by_user', function (Builder $builder){
            $builder->where('user_id', auth()->id());
        });
    }
}
