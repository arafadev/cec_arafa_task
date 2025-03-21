# CEC - Arafa's Task

This task collects room data from multiple advertiser apis, processes it, removes duplicates, and sorts the results by price in ascending order.

## Project Structure    

```
cec-arafa-task/
│── app/
│   ├── Factories/
│   │   ├── AdvertiserFactory.php
│   ├── Interfaces/
│   │   ├── AdvertiserInterface.php
│   ├── Services/
│   │   ├── AdvertiserAPI.php
│   │   ├── HotelRoomService.php
│── config/
│   ├── app.php
│── public/
│   ├── index.php
│── tests/
    ├── Integration/
│   │   ├── HotelRoomServiceTest.php
│── vendor/
│── composer.json
│── README.md
```

## Installation

1. Clone the repository:
   ```sh
   git clone https://github.com/arafadev/cec_arafa_task.git
   ```
2. Navigate to the project directory:
   ```sh
   cd cec_arafa_task
   ```
3. Install dependencies:
   ```sh
   composer install
   ```

## Usage

1. Start a local server:
   ```sh
   php -S localhost:8000 -t public
   ```
2. Access the API:
   ```sh
    http://localhost:8000/
   ```
3. The API will return a JSON response with the sorted and filtered rooms.

## Code Explanation

### `HotelRoomService.php`
- Fetches data from multiple advertisers.
- Normalizes the data format.
- Removes duplicate rooms based on `hotel_name` and `room_code`, keeping the cheapest price.
- Sorts rooms by price in ascending order.

### `AdvertiserAPI.php`
- Makes http requests to fetch data from advertiser apis.
- Parses json responses and extracts room information.
- Handles errors gracefully.

### `AdvertiserFactory.php`
- Creates instances of `AdvertiserAPI` dynamically based on configured API URLs.

### `index.php`
- Initializes services and outputs the processed hotel room data as a JSON response.

## Testing

- Run the test suite using PHPUnit:
  ```sh
  ./vendor/bin/phpunit tests/
  ```
- The test suite validates:
  - The API response is not empty.
  - Room prices are sorted in ascending order.
  - No duplicate room codes exist.

## Error Handling

- If an API request fails, an error is logged, and the service continues processing other apis.
- If the API response is invalid, it is skipped.
- A `500` response is returned in case of an unexpected error.

## Dependencies

- PHP 7.4+
- Composer
- GuzzleHTTP (for making API requests)
- PHPUnit (for testing)

## License



## Author

Developed by [Ahmed Arafa](https://github.com/arafadev).

