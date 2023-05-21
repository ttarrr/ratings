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
                'rules' => ['required', 'email']
            ],
            'user_name' => [
                'name' => 'user_name',
                'type' => Type::nonNull(Type::string()),
                'description' => 'User Name',
                'rules' => ['required', 'string']
            ],
            'rating' => [
                'name' => 'rating',
                'type' => Type::nonNull(Type::int()),
                'description' => 'Rating Value',
                'rules' => ['required', 'integer', 'min:0', 'max:5']
            ],
            'comment' => [
                'name' => 'comment',
                'type' => Type::nonNull(Type::string()),
                'description' => 'Comment',
                'rules' => ['required', 'string']
            ],
            'photo' => [
                'name' => 'photo',
                'type' => Type::string(),
                'description' => 'Photo',
                'rules' => ['nullable', 'image']
            ],
        ];
    }

    public function resolve($root, $args): Rating
    {
        $rating = new Rating([
            'email' => $args['email'],
            'user_name' => $args['user_name'],
            'rating' => $args['rating'],
            'comment' => $args['comment'],
            'photo' => $args['photo'] ?? null,
        ]);

        $rating->save();

        return $rating;
    }

    /**
     * @throws ValidationError
     */
    protected function validateArguments(array $arguments, array $rules): void
    {
        $validator = $this->getValidator($arguments, $rules);

        if ($validator->fails()) {
            throw new ValidationError($validator->errors(), $validator);
        }
    }
}
