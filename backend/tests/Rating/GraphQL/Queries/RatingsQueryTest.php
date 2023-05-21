<?php

namespace Tests\Rating\GraphQL\Queries;

use App\Rating\Domain\Entities\Rating;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class RatingsQueryTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldFetchAllRatings()
    {
        $this->givenRatingInstance();

        $response = $this->whenQueryGraphQL([
            'query' => 'query ratings($sortBy: String, $orderBy: String) {
                ratings(sortBy: $sortBy, orderBy: $orderBy) {
                    id
                    email
                    user_name
                    rating
                    comment
                    photo
                }
            }',
            'variables' => [
                'sortBy' => 'rating',
                'orderBy' => 'desc',
            ],
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'ratings' => [
                        '*' => [
                            'id',
                            'email',
                            'user_name',
                            'rating',
                            'comment',
                            'photo',
                        ],
                    ],
                ],
            ]);
    }

    private function givenRatingInstance()
    {
        Rating::create([
            'email' => 'example@example.com',
            'user_name' => 'John Doe',
            'rating' => 5,
            'comment' => 'Great service!',
            'photo' => 'photo.jpg',
        ]);
    }

    protected function whenQueryGraphQL(array $data, array $headers = []): TestResponse
    {
        return $this->postJson('/graphql', $data, $headers);
    }
}
