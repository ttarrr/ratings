import React, { useState } from 'react';
import { useQuery } from '@apollo/client';
import { Table, message, Modal } from 'antd';
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

    const [modalVisible, setModalVisible] = useState(false);
    const [selectedImage, setSelectedImage] = useState('');

    if (error) {
        message.error('Something went wrong!');
        return null;
    }

    const handleImageClick = (photo: string) => {
        setSelectedImage(photo);
        setModalVisible(true);
    };

    const handleModalClose = () => {
        setModalVisible(false);
    };

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
        {
            title: 'Photo',
            dataIndex: 'photo',
            render: (photo: string | undefined) => {
                return (
                    photo && (
                        <img
                            src={photo}
                            alt="Rating Photo"
                            style={{ width: '100px', cursor: 'pointer' }}
                            onClick={() => handleImageClick(photo)}
                        />
                    )
                );
            },
        },
    ];

    return (
        <>
            <Table loading={loading} dataSource={data?.ratings} columns={columns} rowKey="id" />
            <Modal visible={modalVisible} onCancel={handleModalClose} footer={null}>
                <img src={selectedImage} alt="Selected Photo" style={{ width: '100%' }} />
            </Modal>
        </>
    );
}

export default RatingsList;