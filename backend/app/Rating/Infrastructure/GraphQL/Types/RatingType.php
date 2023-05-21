<?php

namespace App\Rating\Infrastructure\GraphQL\Types;

use App\Rating\Domain\Entities\Rating;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class RatingType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Rating',
        'description' => 'Product rating',
        "model" => Rating::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID',
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Email',
            ],
            'user_name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'User Name',
            ],
            'rating' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Rating Value',
            ],
            'comment' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Comment',
            ],
            'photo' => [
                'type' => Type::string(),
                'description' => 'Photo Url',
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Created At',
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Updated At',
            ],
        ];
    }

    protected function resolveEmailField($root, array $args): string
    {
        return strtolower($root->email);
    }
}
