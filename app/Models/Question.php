<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    //Mutator function
    public function setTitleAttribute(string $title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    }

    public function getUrlAttribute()
    {
        return "/questions/$this->slug";
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getAnswerStylesAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return 'has-best-answer';
            }
            return 'answered';
        }
        return 'unanswered';
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class);
    }
    public function markAsBest(Answer $answer)
    {
        $this->update(['best_answer_id' => $answer->id]);
    }

    public function isBestAnswer(Answer $answer)
    {
        return $this->best_answer_id === $answer->id;
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }

    public function getIsFavoriteAttribute()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }
}
