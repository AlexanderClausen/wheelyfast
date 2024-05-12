<?php

$cars = json_decode(file_get_contents('cars.json'));
$autocomplete_data = [];
foreach ($cars as $car) {
    $autocomplete_data[] = $car->make;
    $autocomplete_data[] = $car->make . ' ' . $car->model;
}

echo json_encode(array_unique($autocomplete_data));