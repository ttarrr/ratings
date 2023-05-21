<?php

namespace App\Rating\Infrastructure\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Validator;
use Rebing\GraphQL\Error\ValidationError;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use App\Rating\Domain\Entities\Rating;

class CreateRatingMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateRatingMutation',
        'description' => 'Create a new rating',
    ];

    public function type(): Type
    {
        return GraphQL::type('Rating');
    }

    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
                'description' => 'Email',
            ],
            'user_name' => [
                'name' => 'user_name',
                'type' => Type::nonNull(Type::string()),
                'description' => 'User Name',
            ],
            'rating' => [
                'name' => 'rating',
                'type' => Type::nonNull(Type::int()),
                'description' => 'Rating Value',
            ],
            'comment' => [
                'name' => 'comment',
                'type' => Type::nonNull(Type::string()),
                'description' => 'Comment',
            ],
            'photo' => [
                'name' => 'photo',
                'type' => Type::string(),
                'description' => 'Photo',
            ],
        ];
    }

    /**
     * @throws ValidationError
     */
    public function resolve($root, $args): Rating
    {
        $validatedArgs = $this->validate($args);

        $rating = new Rating([
            'email' => $validatedArgs['email'],
            'user_name' => $validatedArgs['user_name'],
            'rating' => $validatedArgs['rating'],
            'comment' => $validatedArgs['comment'],
            'photo' => $validatedArgs['photo'] ?? null,
        ]);

        $rating->save();

        return $rating;
    }

    /**
     * @throws ValidationError
     */
    private function validate(array $args): array
    {
        $validator = Validator::make($args, Rating::rules());

        if ($validator->fails()) {
            throw new ValidationError($validator->errors(), $validator);
        }

        return $args;
    }
}
