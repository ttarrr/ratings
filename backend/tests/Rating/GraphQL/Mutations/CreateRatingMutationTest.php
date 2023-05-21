<?php

namespace Tests\Rating\GraphQL\Mutations;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CreateRatingMutationTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldCreateRecordWithValidData()
    {
        $data = $this->givenValidData();

        $response = $this->whenQueryGraphQL([
            'query' => 'mutation createRating($email: String!, $user_name: String!, $rating: Int!, $comment: String!, $photo: String) {
                        createRating(email: $email, user_name: $user_name, rating: $rating, comment: $comment, photo: $photo) {
                            id
                            email
                            user_name
                            rating
                            comment
                            photo
                        }
                    }',
            'variables' => $data,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'createRating' => $data,
                ],
            ]);
        $this->assertDatabaseHas('ratings', $data);
    }

    public function testShouldFailWithInvalidData()
    {
        $invalidData = $this->givenInvalidData();

        $response = $this->whenQueryGraphQL([
            'query' => 'mutation createRating($email: String!, $user_name: String!, $rating: Int!, $comment: String!, $photo: String) {
                        createRating(email: $email, user_name: $user_name, rating: $rating, comment: $comment, photo: $photo) {
                            id
                            email
                            user_name
                            rating
                            comment
                            photo
                        }
                    }',
            'variables' => $invalidData,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'errors' => [
                    [
                        'extensions' => [
                            'category' => 'validation',
                            'validation' => [
                                'email' => [
                                    'The email field must be a valid email address.',
                                ],
                                'rating' => [
                                    'The rating field must not be greater than 5.',
                                ],
                                'comment' => [
                                    'The comment field is required.',
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    }

    protected function givenValidData(): array
    {
        return [
            'email' => 'example@example.com',
            'user_name' => 'John Doe',
            'rating' => 5,
            'comment' => 'Great service!',
            'photo' => null,
        ];
    }

    protected function givenInvalidData(): array
    {
        return [
            'email' => 'examp^Y#@le@example.com',
            'user_name' => 'John Doe',
            'rating' => 7,
            'comment' => '',
            'photo' => null,
        ];
    }

    protected function whenQueryGraphQL(array $data, array $headers = []): TestResponse
    {
        return $this->postJson('/graphql', $data, $headers);
    }
}
