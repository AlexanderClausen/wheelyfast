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

    $start_date = date_create($_GET['start-date'] ?? null);
    $end_date = date_create($_GET['end-date'] ?? null);
    $number_days = date_diff($start_date, $end_date)->days + 1;

    echo '<div class="car-details">';
        echo '<div id="car-images-container">';
            echo '<button id="scroll-left" class="scroll-button" data-content="&lt;"></button>';
            echo '<button id="scroll-right" class="scroll-button" data-content="&gt;"></button>';
            echo '<div id="car-images">';
                echo '<img id="car-image-exterior" class="car-image" src="./images/' . $car->image . '" alt="' . $car->name . '">';
                if ($car->year >= 2000) {
                    echo '<img id="car-image-interior" class="car-image" src="./images/interior_new.webp" alt="' . $car->name . '">';
                } else {
                    echo '<img id="car-image-interior" class="car-image" src="./images/interior_old.webp" alt="' . $car->name . '">';
                }
            echo '</div>';
        echo '</div>';
        // echo '<p class="chip ' . ($car->booked ? 'unavailable' : 'available') .'" id="car-availability">' . ($car->booked ? 'Booked' : 'Available') . '</p>';
        echo '<p id="car-type" class="smalltext">' . $car->class . ' car | ' . $car->type . '</p>';
        // echo '<p id="car-name" class="bigtext">' . $car->name . ' (' . $car->year . ')</p>';
        echo '<div class="container-spacebetween">';
            echo '<p id="car-model" class="bigtext">' . $car->name . ' (' . $car->year . ')</p>';
            echo '<div id="car-price" class="right-align" style="margin-left: 10px;">';
                echo '<span class="bigtext">$' . number_format($car->price, 2) . '</span>';
                echo '<span class="smalltext"> / day</span>';
            echo '</div>';
        echo '</div>';

        echo '<hr>';

        echo '<div class="container">';
            echo '<div id="car-properties-container">';
                if ($car->booked) {
                    echo '<button class="big-button rentnow unavailable">Unavailable</button>';
                } else {
                    echo '<form action="reservation.php" method="get">';
                        echo '<input type="hidden" name="id" value="' . $_GET['id'] . '">';
                        echo '<input type="hidden" name="start_date" value="' . $_GET['start_date'] . '">';
                        echo '<input type="hidden" name="end_date" value="' . $_GET['end_date'] . '">';
                        echo '<button type="submit" class="big-button rentnow available">Rent now</button>';
                    echo '</form>';
                }
                // echo '<p>' . implode(", ", checkCarAvailability($_GET['id'], $_GET['start_date'], $_GET['end_date'], 'all')) . '</p>';
                // echo '<p>' . checkCarAvailability($_GET['id'], $_GET['start_date'], $_GET['end_date'], 'lowest') . '</p>';
                // echo '<p>' . ($car->booked ? 'Car is booked' : 'Car is available') . '</p>';
                echo '<div class="container-spacebetween">';
                    echo '<span class="feature ' . ($car->features->aircon ? 'true' : 'false') . ' tooltip" id="car-aircon"><span class="material-symbols-outlined">mode_fan</span><span class="tooltiptext">A/C: ' . ($car->features->aircon ? '&check;' : '&cross;') . '</span></span>';
                    echo '<span class="feature ' . ($car->features->bluetooth ? 'true' : 'false') . ' tooltip" id="car-bluetooth"><span class="material-symbols-outlined">bluetooth</span><span class="tooltiptext">Bluetooth: ' . ($car->features->bluetooth ? '&check;' : '&cross;') . '</span></span>';
                    echo '<span class="feature ' . ($car->features->carplay ? 'true' : 'false') . ' tooltip" id="car-carplay"><span class="material-symbols-outlined">ios</span><span class="tooltiptext">Apple CarPlay: ' . ($car->features->carplay ? '&check;' : '&cross;') . '</span></span>';
                    echo '<span class="feature ' . ($car->features->androidauto ? 'true' : 'false') . ' tooltip" id="car-androidauto"><span class="material-symbols-outlined">android</span><span class="tooltiptext">Android Auto: ' . ($car->features->androidauto ? '&check;' : '&cross;') . '</span></span>';
                    echo '<span class="feature ' . ($car->features->gps ? 'true' : 'false') . ' tooltip" id="car-gps"><span class="material-symbols-outlined">near_me</span><span class="tooltiptext">GPS: ' . ($car->features->gps ? '&check;' : '&cross;') . '</span></span>';
                    echo '<span class="feature ' . ($car->features->parkingassistant ? 'true' : 'false') . ' tooltip" id="car-parkingassistant"><span class="material-symbols-outlined">local_parking</span><span class="tooltiptext">Parking assistant: ' . ($car->features->parkingassistant ? '&check;' : '&cross;') . '</span></span>';
                    echo '<span class="feature ' . ($car->features->cruisecontrol ? 'true' : 'false') . ' tooltip" id="car-cruisecontrol"><span class="material-symbols-outlined">speed</span><span class="tooltiptext">Cruise Control: ' . ($car->features->cruisecontrol ? '&check;' : '&cross;') . '</span></span>';
                echo '</div>';
                echo '<table id="car-properties" class="flex">';
                    echo '<tr>';
                        echo '<td><span class="material-symbols-outlined">auto_transmission</span><span>Transmission:</span></td>';
                        echo '<td>' . $car->transmission . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><span class="material-symbols-outlined">local_gas_station</span><span>Fuel type:</span></td>';
                        echo '<td>' . $car->fuel . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><span class="material-symbols-outlined">group</span><span>Seats:</span></td>';
                        echo '<td>' . $car->seats . ' seats</td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><span class="material-symbols-outlined">luggage</span><span>Luggage:</span></td>';
                        echo '<td>' . $car->luggage . ' bags</td>';
                    echo '</tr>';
                echo '</table>';
            echo '</div>';
            echo '<p id="car-description" class="flex">' . $car->description . '</p>';
        echo '</div>';

        // echo '<p id="car-price">$' . number_format($car->price, 2) . '/day</p>';
        // echo '<button>Book</button>';
    echo '</div>';
}