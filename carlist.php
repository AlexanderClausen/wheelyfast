<?php
include 'functions.php';

// Set start_date and end_date to today if they are not set
$start_date = date_create($_GET['start-date'] ?? null);
$end_date = date_create($_GET['end-date'] ?? null);
$exclude_unavailable = isset($_GET['exclude-unavailable']) ? true : false;
$number_days = date_diff($start_date, $end_date)->days + 1;

if ($start_date == null || $end_date == null) {
    echo '<h2>All Cars</h2>';
} elseif ($number_days > 1) {
    echo '<h2>Available cars for ' . $number_days . ' calendar days from '. date_format($start_date, 'd M Y') . ' to ' . date_format($end_date, 'd M Y') . '</h2>';
} elseif ($number_days == 1) {
    echo '<h2>Available cars for 1 calendar day on ' . date_format($start_date, 'd M Y') . '</h2>';
}

// $cars = getCarsList($start_date, $end_date, $exclude_unavailable);
$cars = array();
$cars = getCarsList($start_date, $end_date, $exclude_unavailable, $_GET['search'] ?? '');

// DEBUG: Output raw car list
echo '<details>';
echo '<summary>DEBUG OUTPUT (exclude_unavailable: ' . ($exclude_unavailable ? 'true' : 'false') . ')</summary>';
echo '<pre>';
print_r($cars);
echo '</pre>';
echo '</details>';

// DEBUG: GET parameters
echo '<details>';
echo '<summary>GET parameters</summary>';
echo '<pre>';
print_r($_GET);
echo '</pre>';
echo '</details>';

foreach ($cars as $car) {
    echo '<div class="car">';
    // echo '<img src="data/' . $car->image . '" alt="' . $car->name . '">';
    echo '<h3>' . $car->name . ' (ID #' . $car->id . ')</h3>';
    // echo '<p>' . $car->year . '</p>';
    echo '<p>$' . number_format($car->price, 2) . '/day</p>';
    echo '<p>' . ($car->booked ? 'Unavailable' : 'Available') . '</p>';
    // echo '<button>Book</button>';
    echo '</div>';
}