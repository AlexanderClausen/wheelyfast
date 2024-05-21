<?php
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
            $sql = "SELECT car_id FROM orders WHERE ((start_date BETWEEN '$start_date' AND '$end_date') OR (end_date BETWEEN '$start_date' AND '$end_date')) AND (status NOT IN ('cancelled', 'returned'))";
            $result = $conn->query($sql);
            $booked_cars = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $booked_cars[] = $row['car_id'];
                }
            }

            foreach ($cars as $car) {
                $car->booked = in_array($car->id, $booked_cars);
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

    function checkCarBooked($id, $start_date, $end_date) {
        global $conn;
        $sql = "SELECT * FROM orders WHERE car_id = $id AND status NOT IN ('cancelled', 'returned') AND ((start_date BETWEEN '$start_date' AND '$end_date') OR (end_date BETWEEN '$start_date' AND '$end_date'))";
        $result = $conn->query($sql);
        return $result->num_rows > 0;
    }

    function getCarDetails($id, $start_date, $end_date) {
        $cars = json_decode(file_get_contents('cars.json'));

        foreach ($cars as $car) {
            if ($car->id == $id) {
                $car->booked = checkCarBooked($id, $start_date, $end_date);
                $car->name = $car->make . ' ' . $car->model;
                return $car;
            }
        }

        return null;
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