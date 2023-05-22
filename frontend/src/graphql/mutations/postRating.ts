import { gql } from '@apollo/client';

export const POST_RATING = gql`
    mutation createRating($user_name: String!, $email: String!, $rating: Int!, $comment: String!, $photo: Upload) {
        createRating(user_name: $user_name, email: $email, rating: $rating, comment: $comment, photo: $photo) {
            id
            email
            user_name
            rating
            comment
            photo
        }
    }
`;