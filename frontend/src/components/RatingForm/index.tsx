import React from 'react';
import { useMutation } from '@apollo/client';
import { Form, Input, Rate, Button, message, Upload } from 'antd';
import { UploadOutlined } from '@ant-design/icons';
import { UploadChangeParam } from 'antd/lib/upload';
import { POST_RATING } from '../../graphql/mutations/postRating';

const RatingForm: React.FC = () => {
    const [form] = Form.useForm();

    const [createRating, { loading }] = useMutation(POST_RATING, {
        onCompleted: () => {
            message.success('Rating posted successfully!');
            window.location.href = "/";
        },
        onError: () => {
            message.error('Something went wrong!');
        },
    });

    const onFinish = (values: any) => {
        createRating({
            variables: {
                user_name: values.user_name,
                email: values.email,
                rating: values.rating,
                comment: values.comment,
                photo: values.photo
            },
        });
    };

    const onFileChange = (info: UploadChangeParam) => {
        let fileList = [...info.fileList];

        fileList = fileList.slice(-1);

        fileList = fileList.map(file => {
            if (file.response) {
                file.url = file.response.url;
            }
            return file;
        });

        form.setFieldsValue({
            photo: fileList[0]?.originFileObj
        });
    };

    return (
        <Form layout="vertical" onFinish={onFinish} className="rating-form" form={form}>
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
            <Form.Item name="photo">
                <Upload name="file" maxCount={1} onChange={onFileChange} beforeUpload={() => false}>
                    <Button icon={<UploadOutlined />}>Click to Upload</Button>
                </Upload>
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