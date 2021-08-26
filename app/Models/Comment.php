<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    public $fillable = [
        'name', 'message', 'parent_id'
    ];

    public $appends = [
        'initials',
        'age'
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->orderBy('created_at', 'DESC')
            ->with(['children']);
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getInitialsAttribute()
    {
        $nameArray = collect(explode(' ', strtoupper($this->name)))->map(function ($word) {
            return $word[0];
        });

        if ($nameArray->count() > 1) {
            return "{$nameArray[0]} {$nameArray[$nameArray->count() - 1]}";
        }

        return $nameArray[0];
    }
}
