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

    public static function newFactory(): Factory
    {
        return RatingFactory::new();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUserName(): string
    {
        return $this->user_name;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }
}
