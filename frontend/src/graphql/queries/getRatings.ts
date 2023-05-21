import { gql } from '@apollo/client';

export const GET_RATINGS = gql`
  query ratings($sortBy: String, $orderBy: String) {
    ratings(sortBy: $sortBy, orderBy: $orderBy) {
      id
      email
      user_name
      rating
      comment
      photo
    }
  }
`;