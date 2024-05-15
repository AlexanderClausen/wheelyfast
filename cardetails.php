<?php

// // DEBUG: GET parameters
// echo '<details>';
// echo '<summary>GET parameters</summary>';
// echo '<pre>';
// print_r($_GET);
// echo '</pre>';
// echo '</details>';

if ($_GET['id'] == '') {
    echo '<p>No car selected</p>';
} else {
    include 'functions.php';

    $car = getCarDetails($_GET['id'], $_GET['start_date'], $_GET['end_date']);

    echo '<div class="car-details">';
        echo '<img id="car-image" src="./images/' . $car->image . '" alt="' . $car->name . '">';
        echo '<p class="chip ' . ($car->booked ? 'unavailable' : 'available') .'" id="car-availability">' . ($car->booked ? 'Booked' : 'Available') . '</p>';
        echo '<p id="car-name">' . $car->name . ' (' . $car->year . ')</p>';
        echo '<p id="car-infoline">' . $car->class . ' car | ' . $car->type . '</p>';
        echo '<p id="car-description">' . $car->description . '</p>';

        echo '<table><tr>';
            echo '<td><p class="feature ' . ($car->features->aircon ? 'true' : 'false') . ' tooltip" id="car-aircon"><span class="material-symbols-outlined">mode_fan</span><span class="tooltiptext">A/C: ' . ($car->features->aircon ? '&check;' : '&cross;') . '</span></p></td>';
            echo '<td><p class="feature ' . ($car->features->bluetooth ? 'true' : 'false') . ' tooltip" id="car-bluetooth"><span class="material-symbols-outlined">bluetooth</span><span class="tooltiptext">Bluetooth: ' . ($car->features->bluetooth ? '&check;' : '&cross;') . '</span></p></td>';
            echo '<td><p class="feature ' . ($car->features->carplay ? 'true' : 'false') . ' tooltip" id="car-carplay"><span class="material-symbols-outlined">ios</span><span class="tooltiptext">Apple CarPlay: ' . ($car->features->carplay ? '&check;' : '&cross;') . '</span></p></td>';
            echo '<td><p class="feature ' . ($car->features->androidauto ? 'true' : 'false') . ' tooltip" id="car-androidauto"><span class="material-symbols-outlined">android</span><span class="tooltiptext">Android Auto: ' . ($car->features->androidauto ? '&check;' : '&cross;') . '</span></p></td>';
            echo '<td><p class="feature ' . ($car->features->gps ? 'true' : 'false') . ' tooltip" id="car-gps"><span class="material-symbols-outlined">near_me</span><span class="tooltiptext">GPS: ' . ($car->features->gps ? '&check;' : '&cross;') . '</span></p></td>';
            echo '<td><p class="feature ' . ($car->features->parkingassistant ? 'true' : 'false') . ' tooltip" id="car-parkingassistant"><span class="material-symbols-outlined">local_parking</span><span class="tooltiptext">Parking assistant: ' . ($car->features->parkingassistant ? '&check;' : '&cross;') . '</span></p></td>';
            echo '<td><p class="feature ' . ($car->features->cruisecontrol ? 'true' : 'false') . ' tooltip" id="car-cruisecontrol"><span class="material-symbols-outlined">speed</span><span class="tooltiptext">Cruise Control: ' . ($car->features->cruisecontrol ? '&check;' : '&cross;') . '</span></p></td>';
        echo '</tr></table>';

        echo '<p id="car-price">$' . number_format($car->price, 2) . '/day</p>';
        echo '<button>Book</button>';
    echo '</div>';
}