# Ratings
Ratings is a test application built with Laravel, GraphQL, and React. It provides functionality to create ratings and view a ratings list.

## Installation
To set up the Ratings application, follow these steps:

1. Clone this repository to your local machine:

```
git clone <repository_url>
```
2. Build the application dependencies by running the following command:
```
make build
```
3. Start the Docker containers:
```
make start
```
4. Run the database migrations:
```
make migrate
```
*Please allow a few seconds after running 'make start' to ensure that the MySQL service is up and running before executing the migrations.

5. Seed the database with sample data:
```
make seed
```
6. Run the frontend application:
```
make run_frontend
```
You can access the application by navigating to http://localhost:3000 in your browser.

## Features

* Docker-compose + Makefile builder
* Domain-Driven Design
* GraphQL API
* Given-When-Then Testing Approach
* React/ANTd frontend

## Tests
To run backend tests:
```
make test
```