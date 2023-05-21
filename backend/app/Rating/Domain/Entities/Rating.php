<?php

namespace App\Rating\Domain\Entities;

use App\Rating\Infrastructure\Database\Factories\RatingFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\ExecutionStatus;

class Rating extends Model
{
    use HasFactory;

    /** @var string */
    protected $table = 'ratings';

    /** @var array */
    protected $fillable = [
        'email',
        'user_name',
        'rating',
        'comment',
        'photo',
    ];

    public static function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'user_name' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
            'comment' => ['required', 'string'],
            'photo' => ['nullable', 'image'],
        ];
    }

    public static function newFactory(): Factory
    {
        return RatingFactory::new();
    }
}
