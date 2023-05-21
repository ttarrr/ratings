<?php

namespace App\Rating\Infrastructure\GraphQL\Queries;

use App\Rating\Domain\Entities\Rating;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Rebing\GraphQL\Error\ValidationError;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class RatingsQuery extends Query
{
    protected $attributes = [
        'name' => 'RatingsQuery',
        'description' => 'Fetch all ratings',
        "model" => Rating::class,
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Rating'));
    }

    public function args(): array
    {
        return [
            'sortBy' => [
                'name' => 'sortBy',
                'type' => Type::string(),
                'description' => 'Field to sort by',
                'rules' => ['nullable', 'in:rating,created_at'],
            ],
            'orderBy' => [
                'name' => 'orderBy',
                'type' => Type::string(),
                'description' => 'Sort order (asc or desc)',
                'rules' => ['nullable', 'in:asc,desc'],
            ],
        ];
    }

    public function resolve($root, $args): Collection
    {
        $sortBy = $args['sortBy'] ?? 'rating';
        $orderBy = $args['orderBy'] ?? 'desc';

        $query = Rating::query();
        $query->orderBy($sortBy, $orderBy);

        return $query->get();
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
