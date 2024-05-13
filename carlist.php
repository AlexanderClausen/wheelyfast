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
    echo '<p>&#8594; Searching for "' . $_GET['search'] . '"</p>';
}

if ($_GET['nav-key'] != '' && $_GET['nav-value'] != '') {
    echo '<p>&#8594; Filtering by ' . $_GET['nav-key'] . ': ' . $_GET['nav-value'] . '</p>';
}

if ($number_days > 1) {
    echo '<p>&#8594; ' . $number_days . ' calendar days from '. date_format($start_date, 'd M Y') . ' to ' . date_format($end_date, 'd M Y') . '</p>';
} elseif ($number_days == 1) {
    echo '<p>&#8594; 1 calendar day on ' . date_format($start_date, 'd M Y') . '</p>';
}

if ($exclude_unavailable) {
    echo '<p>&#8594; Excluding unavailable cars</p>';
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
    echo '<div class="car">';
    // echo '<img src="data/' . $car->image . '" alt="' . $car->name . '">';
    echo '<h3 class="detail-link" data-id="' . $car->id . '">' . $car->name . ' (ID #' . $car->id . ')</h3>';
    // echo '<p>' . $car->year . '</p>';
    echo '<p>$' . number_format($car->price, 2) . '/day</p>';
    echo '<p>' . ($car->booked ? 'Unavailable' : 'Available') . '</p>';
    // echo '<button>Book</button>';
    echo '</div>';
}