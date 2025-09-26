# Sports Venue API - BFNL back-end assignment

### Symfony 7.1 + PHP 8.3 API providing a list of sport venues with geolocation. Built with API Platform, Docker, and MySQL.

## Features

#### List sport venues with JSON response

#### Filter by lat/lng and maximum distance (km) via:

- Optimized /within_distance endpoint (database-side Haversine, ideal for large datasets)

- Search by name

- Order by name or coordinates

- API Key authentication (X-API-KEY)

- OpenAPI/Swagger documentation automatically generated

## Requirements

#### Docker & Docker Compose

#### PHP 8.3 (inside container)

#### Composer (inside container)

## Installation

#### Clone the project

#### Install PHP dependencies

```shell
composer install
```

#### Start Docker containers

```shell
docker compose up -d
```

#### Run Doctrine migrations

```shell
docker compose exec php-fpm bin/console doctrine:migrations:migrate
```

#### Load fixtures

```shell
docker compose exec php-fpm bin/console doctrine:fixtures:load
```

### API Key Configuration

#### The project uses simple API Key authentication:

- Set the API key in .env.local:

*****
API_KEY=super_secret_key_123
*****

- Add this header to all API requests:

*****
X-API-KEY: super_secret_key_123
*****

### API Endpoints

GET /api/sport_venues?page=1&itemsPerPage=5&lat=48.8566&lng=2.3522&distance=5
Headers: X-API-KEY: super_secret_key_123

GET /api/sport_venues/within_distance?lat=48.8566&lng=2.3522&distance=10
Headers: X-API-KEY: super_secret_key_123

- Uses database-side Haversine formula for efficient distance filtering.

- Returns associative arrays with precomputed distance.

- Ideal for large datasets.

### Example response:

```shell
[
    {
        "id": 9,
        "name": "Lubowitz, Reynolds and Kris",
        "lat": 51.906832,
        "lng": 0.260687,
        "distance": 0
    },
    {
        "id": 1,
        "name": "Stadium A",
        "lat": 48.8566,
        "lng": 2.3522,
        "distance": 370.135161144017
    },
    {
        "id": 6,
        "name": "Schimmel, Hilpert and McLaughlin",
        "lat": 54.233867,
        "lng": -4.897715,
        "distance": 430.778705915223
    }
]
````

## OpenAPI / Swagger Docs

### Visit the auto-generated documentation at:

http://localhost:49000/api

### Running Tests

```shell
docker compose exec php-fpm bin/phpunit
```

### Index added on lat + lng:

- CREATE INDEX idx_lat_lng ON sport_venue(lat, lng);

## Optional: usage of spatial POINT + SPATIAL INDEX for even larger datasets.