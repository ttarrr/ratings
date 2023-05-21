import React from 'react';
import { useQuery } from '@apollo/client';
import { Table, message } from 'antd';
import { GET_RATINGS } from '../../graphql/queries/getRatings';

interface RatingData {
    id: string;
    user_name: string;
    email: string;
    rating: number;
    comment: string;
}

function RatingsList() {
    const { loading, error, data } = useQuery<{ratings: RatingData[]}>(GET_RATINGS, {
        variables: {
            sortBy: 'rating',
            orderBy: 'desc',
        },
    });

    if (error) {
        message.error('Something went wrong!');
        return null;
    }

    const columns = [
        {
            title: 'Name',
            dataIndex: 'user_name',
        },
        {
            title: 'Email',
            dataIndex: 'email',
        },
        {
            title: 'Rating',
            dataIndex: 'rating',
        },
        {
            title: 'Comment',
            dataIndex: 'comment',
        },
    ];

    return <Table loading={loading} dataSource={data?.ratings} columns={columns} rowKey="id" />;
}

export default RatingsList;