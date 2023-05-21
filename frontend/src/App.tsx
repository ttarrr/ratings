import React from 'react';
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import { Menu } from 'antd';
import RatingPage from './pages/RatingPage';
import RatingsListPage from './pages/RatingsListPage';
import './App.css';

function App() {
    return (
        <Router>
            <div>
                <Menu theme="dark" mode="horizontal">
                    <Menu.Item key="1">
                        <Link to="/">Ratings List</Link>
                    </Menu.Item>
                    <Menu.Item key="2">
                        <Link to="/rate">Post a Rating</Link>
                    </Menu.Item>
                </Menu>
                <Routes>
                    <Route path="/rate" element={<RatingPage />} />
                    <Route path="/" element={<RatingsListPage />} />
                </Routes>
            </div>
        </Router>
    );
}

export default App;