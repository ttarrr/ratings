import React from 'react';
import { useMutation } from '@apollo/client';
import { Form, Input, Rate, Button, message } from 'antd';
import { POST_RATING } from '../../graphql/mutations/postRating';

interface RatingFormValues {
    user_name: string;
    email: string;
    rating: number;
    comment: string;
}

function RatingForm() {
    const [createRating, { loading }] = useMutation(POST_RATING, {
        onCompleted: () => {
            message.success('Rating posted successfully!');
        },
        onError: () => {
            message.error('Something went wrong!');
        },
    });

    const onFinish = (values: RatingFormValues) => {
        createRating({ variables: { ...values, rating: values.rating } });
    };

    return (
        <Form layout="vertical" onFinish={onFinish} className="rating-form">
            <Form.Item name="user_name" rules={[{ required: true, message: 'Please input your name' }]}>
                <Input placeholder="Name" />
            </Form.Item>
            <Form.Item name="email" rules={[{ required: true, type: 'email', message: 'Please input a valid email' }]}>
                <Input placeholder="Email" />
            </Form.Item>
            <Form.Item name="rating" rules={[{ required: true, message: 'Please rate' }]}>
                <Rate />
            </Form.Item>
            <Form.Item name="comment">
                <Input.TextArea placeholder="Comment" />
            </Form.Item>
            <Form.Item>
                <Button type="primary" htmlType="submit" loading={loading}>
                    Submit
                </Button>
            </Form.Item>
        </Form>
    );
}

export default RatingForm;