<?php
include 'functions.php';

// Set start_date and end_date to today if they are not set
$start_date = date_create($_GET['start-date'] ?? null);
$end_date = date_create($_GET['end-date'] ?? null);
$exclude_unavailable = isset($_GET['exclude-unavailable']) ? true : false;
$number_days = date_diff($start_date, $end_date)->days + 1;

$cars = getCarsList($start_date, $end_date, $exclude_unavailable, $_GET['search'] ?? '', $_GET['nav-key'] ?? '', $_GET['nav-value'] ?? '');
$cars_length = count($cars);

// Query and results info
echo '<h1>Available cars (' . $cars_length . ' results)</h1>';

if ($_GET['search'] != '') {
    echo '<p class="results-factor">&#8594; Searching for "' . $_GET['search'] . '"</p>';
}

if ($_GET['nav-key'] != '' && $_GET['nav-value'] != '') {
    echo '<p class="results-factor">&#8594; Filtering by ' . $_GET['nav-key'] . ': ' . $_GET['nav-value'] . '</p>';
}

if ($number_days > 1) {
    echo '<p class="results-factor">&#8594; ' . $number_days . ' calendar days from '. date_format($start_date, 'd M Y') . ' to ' . date_format($end_date, 'd M Y') . '</p>';
} elseif ($number_days == 1) {
    echo '<p class="results-factor">&#8594; 1 calendar day on ' . date_format($start_date, 'd M Y') . '</p>';
}

if ($exclude_unavailable) {
    echo '<p class="results-factor">&#8594; Excluding unavailable cars</p>';
}

// // DEBUG: Output raw car list
// echo '<details>';
// echo '<summary>DEBUG OUTPUT (exclude_unavailable: ' . ($exclude_unavailable ? 'true' : 'false') . ')</summary>';
// echo '<pre>';
// print_r($cars);
// echo '</pre>';
// echo '</details>';

// // DEBUG: GET parameters
// echo '<details>';
// echo '<summary>GET parameters</summary>';
// echo '<pre>';
// print_r($_GET);
// echo '</pre>';
// echo '</details>';

foreach ($cars as $car) {
    echo '<div class="car detail-link" data-id="' . $car->id . '">';
        echo '<div class="car-chips">';
            echo '<p class="chip chip-neutral">ID: ' . $car->id . '</p>'; // DEBUG
            echo '<p class="chip chip-neutral">' . $car->class . ' car</p>';
            echo '<p class="chip ' . ($car->booked ? 'unavailable' : 'available') .'" id="car-availability">' . ($car->booked ? 'Booked' : 'Available') . '</p>';
        echo '</div>';
        echo '<img class="car-image-preview" src="./images/' . $car->image . '" alt="' . $car->name . '">';
        echo '<p id="car-make" class="list-smalltext uppercase bold">' . $car->type . '</p>';
        echo '<div class="container-spacebetween">';
            echo '<p id="car-model" class="list-bigtext">' . $car->name . ' (' . $car->year . ')</p>';
            echo '<div id="car-price" class="right-align" style="margin: 10px 0;">';
                echo '<span class="list-bigtext">$' . number_format($car->price, 2) . '</span>';
                echo '<span class="list-smalltext"> / day</span>';
            echo '</div>';
        echo '</div>';
        echo '<div class="list-properties">';
            // echo '<div class="list-property"><span class="material-symbols-outlined list-property-icon">directions_car</span><p class="list-property-text">' . $car->type . '</p></div>';
            echo '<div class="list-property"><span class="material-symbols-outlined list-property-icon">auto_transmission</span><p class="list-property-text">' . $car->transmission . '</p></div>';
            echo '<div class="list-property"><span class="material-symbols-outlined list-property-icon">local_gas_station</span><p class="list-property-text">' . $car->fuel . '</p></div>';
            echo '<div class="list-property"><span class="material-symbols-outlined list-property-icon">group</span><p class="list-property-text">' . $car->seats . '</p></div>';
            echo '<div class="list-property"><span class="material-symbols-outlined list-property-icon">luggage</span><p class="list-property-text">' . $car->luggage . '</p></div>';
        echo '</div>';
    echo '</div>';
}