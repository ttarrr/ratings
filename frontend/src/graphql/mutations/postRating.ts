import { gql } from '@apollo/client';

export const POST_RATING = gql`
  mutation createRating($email: String!, $user_name: String!, $rating: Int!, $comment: String!, $photo: String) {
    createRating(email: $email, user_name: $user_name, rating: $rating, comment: $comment, photo: $photo) {
      id
      email
      user_name
      rating
      comment
      photo
    }
  }
`;