import React, { useState, useEffect } from 'react';
import { useQuery } from '@apollo/client';
import { Table, message, Modal, Select } from 'antd';
import { GET_RATINGS } from '../../graphql/queries/getRatings';

interface RatingData {
    id: string;
    user_name: string;
    email: string;
    rating: number;
    comment: string;
}

function RatingsList() {
    const [modalVisible, setModalVisible] = useState(false);
    const [selectedImage, setSelectedImage] = useState('');
    const [sortBy, setSortBy] = useState('rating');
    const [orderBy, setOrderBy] = useState('desc');

    const { loading, error, data, refetch } = useQuery<{ratings: RatingData[]}>(GET_RATINGS, {
        variables: {
            sortBy,
            orderBy,
        },
    });

    useEffect(() => {
        refetch({ sortBy, orderBy });
    }, [sortBy, orderBy, refetch]);

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
                            alt="Thumb"
                            style={{ width: '100px', cursor: 'pointer' }}
                            onClick={() => handleImageClick(photo)}
                        />
                    )
                );
            },
        },
        {
            title: 'Created At',
            dataIndex: 'created_at',
            render: (date: string) => {
                return new Date(date).toLocaleString();
            },
        },
    ];

    return (
        <>
            <div style={{ display: 'flex', justifyContent: 'flex-end', marginBottom: '2em', marginTop: '-3.5em'}}>
                <Select defaultValue="rating" onChange={value => setSortBy(value)} style={{ marginRight: '1em' }}>
                    <Select.Option value="rating">Rating</Select.Option>
                    <Select.Option value="created_at">Created At</Select.Option>
                </Select>
                <Select defaultValue="desc" onChange={value => setOrderBy(value)}>
                    <Select.Option value="desc">Descending</Select.Option>
                    <Select.Option value="asc">Ascending</Select.Option>
                </Select>
            </div>

            <Table loading={loading} dataSource={data?.ratings} columns={columns} rowKey="id" />
            <Modal visible={modalVisible} onCancel={handleModalClose} footer={null}>
                <img src={selectedImage} alt="Selected" style={{ width: '100%' }} />
            </Modal>
        </>
    );
}

export default RatingsList;