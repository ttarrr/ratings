<?php

namespace Tests\Rating\GraphQL\Mutations;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Testing\FileFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CreateRatingMutationTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldCreateRecordWithValidData()
    {
        $data = $this->givenValidData();

        $response = $this->whenQueryGraphQL([
            'query' => 'mutation createRating($email: String!, $user_name: String!, $rating: Int!, $comment: String!, $photo: Upload) {
                        createRating(email: $email, user_name: $user_name, rating: $rating, comment: $comment, photo: $photo) {
                            id
                            email
                            user_name
                            rating
                            comment
                            photo
                        }
                    }',
            'variables' => [
                'email' => 'example@example.com',
                'user_name' => 'John Doe',
                'rating' => 5,
                'comment' => 'Great service!',
                'photo' => null,
            ],
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
            'query' => 'mutation createRating($email: String!, $user_name: String!, $rating: Int!, $comment: String!, $photo: Upload) {
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

    public function testShouldCreateRecordWithFile()
    {
        Storage::fake('public');
        $fakeFile = $this->givenFakeImage();
        $mutationVariables = $this->givenValidDataWithFile($fakeFile);

        $response = $this->whenQueryGraphQL([
            'query' => 'mutation createRating($email: String!, $user_name: String!, $rating: Int!, $comment: String!, $photo: Upload) {
                    createRating(email: $email, user_name: $user_name, rating: $rating, comment: $comment, photo: $photo) {
                        id
                        email
                        user_name
                        rating
                        comment
                        photo
                    }
                }',
            'variables' => $mutationVariables,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('ratings', [
            'email' => $mutationVariables['email'],
            'user_name' => $mutationVariables['user_name'],
            'rating' => $mutationVariables['rating'],
            'comment' => $mutationVariables['comment'],
        ]);

        $this->thenFileWasStored($response);
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

    protected function givenValidDataWithFile($fakeFile): array
    {
        return [
            'email' => 'example@example.com',
            'user_name' => 'John Doe',
            'rating' => 5,
            'comment' => 'Great service!',
            'photo' => new UploadedFile(
                $fakeFile->getPathname(),
                $fakeFile->getClientOriginalName(),
                $fakeFile->getClientMimeType(),
                null,
                true
            ),
        ];
    }

    protected function givenFakeImage(): UploadedFile
    {
        $temp_file = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($temp_file, 'such fake. many image. wow');

        return new UploadedFile(
            $temp_file,
            'doge.jpg',
            'image/jpeg',
            null,
            true
        );
    }

    protected function thenFileWasStored(TestResponse $response)
    {
        $uploadedPhotoPath = \json_decode($response->getContent())->data->createRating->photo;
        $uploadedPhotoFilename = Str::after($uploadedPhotoPath, '/storage/');
        Storage::disk('public')->assertExists($uploadedPhotoFilename);
    }

    protected function whenQueryGraphQL(array $data, array $headers = []): TestResponse
    {
        return $this->postJson('/graphql', $data, $headers);
    }

    protected function whenQueryGraphQLWithFile(array $data, array $headers = []): TestResponse
    {
        return $this->post('/graphql', $data, $headers);
    }
}
