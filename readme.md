# Gousto API Test
Gousto Backend API Technical Challenge as per `Backend API Technical Challenge - Instructions.pdf`  
The API is implemented with [Lumen](https://lumen.laravel.com]) 5.8.

## Requirements
- PHP7+
- sqlite3 and pdo_sqlite extensions enabled

## Installation
```
    composer install
```

## Run
Use the PHP webserver
```
    php -S localhost:8000 -t public
```
Or through Apache/Nginx

## Tests
```
    ./vendor/bin/phpunit
```

## Data
For data persistence I used Sqlite. I did the migration from the csv provided with the exercise (`database/recipe-data.csv`).  
The corresponding migration and seed files are in the `database/migrations` and `database/seeds` folders, respectively.

## API Endpoints
`GET /api/recipes/{id}` - Returns recipe details.

`GET /api/recipes?cuisine=...[&page=...]` - Fetches a paginated list of recipes filtered by cuisine. Returns the id,
title and description (marketing_description) fields only. Pagination starts from 0, so page=1 is the second page!

`PATCH /api/recipes/{id}` - Update recipe fields.

## Comments
- Testing is somewhat sloppy here. The storage engine should be mocked out to test the controllers but the whole setup 
would be more complicated than the actual code.
- For error handling I used Lumen's inbuilt default settings which is fine most of the time but could be somewhat tweaked.
(For example 404's don't return valid jason but a html error page etc.)
- At the moment if fields not whitelisted are sent to the update endpoint, those fields are silently discarded and only the rest of the data is used.
Whitelisted fields are the fields of the `recipes` table except the id, created_at and updated_at. This ensures no one can modify the id of a record
for example, but the attempt silently fails and no feedback.

## Possible Improvements/Functionality
- .env shouldn't be in the repo, I only added it for the sake of simplicity (There's not much sensitive data in it anyway).
- The update endpoint's field validation should be refactored into a validator from the controller for more complex validation rules.
- The most obvious thing missing here is some kind of authentication/authorization. Having all the endpoints publicly exposed
everyone can modify any recipe in the database.
- API documentation for swagger (or the other way around: using swagger documentation to generate the boilerplate for the API).