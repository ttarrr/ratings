import React from 'react';
import RatingsList from '../../components/RatingsList';
import './RatingsListPage.css';

function RatingsListPage() {
    return (
        <div className="ratings-list-page">
            <h1>Ratings</h1>
            <RatingsList />
        </div>
    );
}

export default RatingsListPage;