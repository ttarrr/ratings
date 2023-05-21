import React from 'react';
import RatingForm from '../../components/RatingForm';
import './RatingPage.css';

function RatingPage() {
    return (
        <div className="rating-page">
            <h1>Post a Rating</h1>
            <RatingForm />
        </div>
    );
}

export default RatingPage;