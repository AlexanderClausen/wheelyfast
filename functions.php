<?php
    session_start();

    $conn = new mysqli('localhost', 'root', '', 'rentalcar');
    if ($conn->connect_error) {
        print($conn->connect_error);
        die('Connection failed: ' . $conn->connect_error);
    }

    function getCarsList($start_date, $end_date, $exclude_booked = false, $premium_filter = "all", $search = '', $nav_key = '', $nav_value = '') {
        $cars = json_decode(file_get_contents('cars.json'));

        global $conn;

        if ($start_date == null || $end_date == null) {
            return $cars;
        }

        else {
            // Convert DateTime onjects to strings
            if ($start_date instanceof DateTime) {
                $start_date = $start_date->format('Y-m-d');
            }
            if ($end_date instanceof DateTime) {
                $end_date = $end_date->format('Y-m-d');
            }

            // Get all cars that are booked between start_date and end_date
            foreach ($cars as $car) {
                $car->booked = checkCarAvailability($car->id, $start_date, $end_date, 'lowest') == 0;
                $car->name = $car->make . ' ' . $car->model;
            }

            // Filter out cars that do not match search query
            if ($search != '') {
                $cars = array_filter($cars, function($car) use ($search) {
                    return stripos($car->name, $search) !== false;
                });
            }

            // Filter out booked cars if $exclude_booked is true
            if ($exclude_booked) {
                $cars = array_filter($cars, function($car) {
                    return !$car->booked;
                });
            }

            // Filter out cars that do not match the premium filter
            if ($premium_filter != 'all') {
                $cars = array_filter($cars, function($car) use ($premium_filter) {
                    return $car->premium == ($premium_filter == 'only');
                });
            }

            // Filter out cars that do not match the navigation menu
            if ($nav_key != '' && $nav_value != '') {
                $cars = array_filter($cars, function($car) use ($nav_key, $nav_value) {
                    return $car->$nav_key == $nav_value;
                });
            }

            return $cars;
        }
    }

    function getCarDetailsMin($id) {
        $cars = json_decode(file_get_contents('cars.json'));

        foreach ($cars as $car) {
            if ($car->id == $id) {
                $car->name = $car->make . ' ' . $car->model;
                return $car;
            }
        }

        return null;
    }

    function checkCarAvailability($id, $start_date, $end_date, $output = 'lowest') {
        global $conn;
        $car = getCarDetailsMin($id);
        $totalQuantity = $car->quantity;

        $sql = "
            WITH RECURSIVE date_series AS (
                SELECT '$start_date' AS date
                UNION ALL
                SELECT DATE_ADD(date, INTERVAL 1 DAY)
                FROM date_series
                WHERE DATE_ADD(date, INTERVAL 1 DAY) <= '$end_date'
            )
            SELECT date_series.date, IFNULL(SUM(orders.quantity), 0) as booking_count
            FROM date_series
            LEFT JOIN orders ON date_series.date BETWEEN orders.start_date AND orders.end_date AND orders.car_id = $id AND orders.status NOT IN ('cancelled', 'returned')
            GROUP BY date_series.date
        ";
        $result = $conn->query($sql);

        $availability = [];
        while($row = $result->fetch_assoc()) {
            $availabilityForDate = $totalQuantity - $row['booking_count'];
            $availability[$row['date']] = $availabilityForDate;
        }

        if ($output == 'all') {
            return $availability;
        } elseif ($output == 'lowest') {
            return min($availability);
        }
    }

    function getCarDetails($id, $start_date, $end_date) {
        $car = getCarDetailsMin($id);
        $car->booked = checkCarAvailability($id, $start_date, $end_date, 'lowest') == 0;
        return $car;
    }

    function getNav($key) {
        // Read the contents of cars.json
        $carsData = file_get_contents('cars.json');

        // Decode the JSON data into an associative array
        $cars = json_decode($carsData, true);

        // Get all the unique values from the cars array
        $values = array_unique(array_column($cars, $key));

        // Sort the values in ascending alphabetical order
        sort($values);

        // Display the unique classes in the navigation menu
        foreach ($values as $value) {
            echo '<li class="nav-link sub-item" data-key="' . $key . '"><span class="nav-text">' . $value . '</span></li>';
        }
    }

    function saveBooking($id, $start_date, $end_date, $name, $email, $phone, $price, $number) {
        global $conn;
        $verification_code = bin2hex(random_bytes(8));
        $sql = "INSERT INTO orders (car_id, code, status, name, phone, email, licence, start_date, end_date, price_day, quantity) VALUES ($id, '$verification_code', 'unconfirmed', '$name', '$phone', '$email', 1, '$start_date', '$end_date', $price, $number)";
        $conn->query($sql);
        $order_id = $conn->insert_id;
        return array('order_id' => $order_id, 'code' => $verification_code);
    }

    function clearSession() {
        session_start();
        session_unset();
        session_destroy();
    }

    function getConfirmation ($id, $code) {
        global $conn;
        $sql = "SELECT * FROM orders WHERE order_id = $id AND code = '$code'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    function changeBookingStatus ($id, $code, $newstatus) {
        global $conn;
        $sql = "UPDATE orders SET status = '$newstatus' WHERE order_id = $id AND code = '$code'";
        $conn->query($sql);

        // cars.json update number of confirmed_bookings
        $car_id = getConfirmation($id, $code)['car_id'];
        
        if ($newstatus == 'confirmed') {
            $carsData = file_get_contents('cars.json');
            $cars = json_decode($carsData, true);
            foreach ($cars as $key => $car) {
                if ($car['id'] == $car_id) {
                    $cars[$key]['confirmed_bookings'] += 1;
                    break;
                }
            }
            file_put_contents('cars.json', json_encode($cars, JSON_PRETTY_PRINT));
        }
    }