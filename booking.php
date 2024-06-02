<?php
include 'functions.php';

if (isset($_GET['id'], $_GET['code'])) {
    $id = $_GET['id'];
    $code = $_GET['code'];

    $booking = getConfirmation($id, $code);
    if ($booking == null) {
        header("Location: index.php");
        exit();
    }
    
    $car = getCarDetailsMin($booking['car_id']);
    $start_date = date_create($booking['start_date']);
    $end_date = date_create($booking['end_date']);
    $number_days = date_diff($start_date, $end_date)->days + 1;
    $past_booking = $end_date < date_create('today');
    $status = $past_booking ? 'returned' : $booking['status'];
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Booking | WheelyFast</title>
    
    <link rel='stylesheet' type='text/css' media='screen' href='minimal.css'>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js" integrity="sha256-sw0iNNXmOJbQhYFuC9OF2kOlD5KQKe1y5lfBn4C9Sjg=" crossorigin="anonymous"></script>
</head>
<body>
    <header id="header">
        <a style="text-decoration: none" href="./"><div id="logo-div">
            <span id="top-bar-logo" class="material-symbols-outlined">speed</span>
            <span id="top-bar-logo-text">WheelyFast</span>
            <span id="top-bar-location">Sydney</span>
        </div></a>
        <div id="reservation-div">
            <?php
            if (!empty($_SESSION)) {
                echo '<form style="height: 100%;" action="reservation.php" method="get"><button id="reservation-button" class="big-button">Finish reservation</button></form>';
            }
            ?>
        </div>
    </header>

    <main>
        <div id="left-column">
            <div id="booking-intro" class="rounded-block">
                <?php if ($status == 'unconfirmed') {
                    echo '<div class="warning">Your booking is pending. Please confirm your booking by clicking here: <a href="status.php?id=' . $id . '&code=' . $code . '&newstatus=confirmed">Confirm booking.</a></div>';
                } ?>
                <p id="booking_status" class="<?php echo $status ?>"><?php echo strtoupper($status) ?></p>
                <h1>Your car hire booking</h1>
                <?php
                if ($status == 'cancelled') {
                    echo '<p>Your booking has been cancelled. Your payment will be refunded according to our cancellation policy shortly. If you did not mean to cancel, please start a new booking.</p>';
                } elseif ($status == 'returned') {
                    echo '<p>Your booking has been returned and is paid in full. Any potential fines for traffic violations will be charged directly. Thank you for choosing WheelyFast.</p>';
                } elseif ($status == 'confirmed') {
                    echo '<p>All set, your booking is confirmed. Please present this booking number and your valid driver licence at the counter when you pick up your car(s).</p>';
                } elseif ($status == 'unconfirmed') {
                    echo '<p>Your booking is pending. Please confirm your booking. If you do not confirm your booking on this page, we are not able to reserve the car(s) for you.</p>';
                }
                ?>
                <hr style="width: 100%;">
                <table>
                    <tr>
                        <td>Customer name:</td>
                        <td><?php echo $booking['name'] ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?php echo $booking['email'] ?></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><?php echo $booking['phone'] ?></td>
                    </tr>
                    <tr>
                        <td>Valid driving licence:</td>
                        <td><?php echo $booking['licence'] == 1 ? "Yes" : "No" ?></td>
                    </tr>
                    <tr>
                        <td>Booking number:</td>
                        <td><?php echo $id ?></td>
                    </tr>
                </table>
            </div>
            <div id="confirmation-car" class="rounded-block">
                <span><?php echo $car->class . ' car | ' . $car->type ?></span>
                <h2><?php echo $car->make . ' ' . $car->model . ' (' . $car->year . ')'; ?></h2>
                <img id="car-img" src="./images/<?php echo $car->image; ?>" alt="<?php echo $car->make . ' ' . $car->model; ?>">
                <div class="list-properties">
                    <?php
                    echo '<div class="list-property"><span class="material-symbols-outlined list-property-icon">auto_transmission</span><p class="list-property-text">' . $car->transmission . '</p></div>';
                    echo '<div class="list-property"><span class="material-symbols-outlined list-property-icon">local_gas_station</span><p class="list-property-text">' . $car->fuel . '</p></div>';
                    echo '<div class="list-property"><span class="material-symbols-outlined list-property-icon">group</span><p class="list-property-text">' . $car->seats . '</p></div>';
                    echo '<div class="list-property"><span class="material-symbols-outlined list-property-icon">luggage</span><p class="list-property-text">' . $car->luggage . '</p></div>';
                    ?>
                </div>
            </div>
        </div>
        <div id="right-column">
            <div id="manage-booking" class="rounded-block">
                <h2>Manage your booking</h2>
                <?php
                if ($status == 'cancelled') {
                    echo '<button class="big-button" onclick="window.location.href=\'index.php\'">Start a new booking</button>';
                } elseif ($status == 'returned') {
                    echo '<button class="big-button" onclick="window.location.href=\'index.php\'">Start a new booking</button>';
                } elseif ($status == 'confirmed') {
                    echo '<button class="big-button active" onclick="window.location.href=\'status.php?id=' . $id . '&code=' . $code . '&newstatus=cancelled\'">Cancel booking</button>';
                } elseif ($status == 'unconfirmed') {
                    echo '<button class="big-button active" style="margin-bottom: 10px;" onclick="window.location.href=\'status.php?id=' . $id . '&code=' . $code . '&newstatus=confirmed\'">Confirm booking</button>';
                    echo '<button class="big-button red" onclick="window.location.href=\'status.php?id=' . $id . '&code=' . $code . '&newstatus=cancelled\'">Cancel booking</button>';
                }
                ?>
            </div>
            <div id="reservation-info" class="rounded-block">
                <h2>Booking information</h2>
                <p>You have booked a <strong><?php echo $car->make . ' ' . $car->model . ' (' . $car->year . ')'; ?></strong> from <strong><?php echo $start_date->format('D, d M Y') . '</strong> to <strong>' . $end_date->format('D, d M Y') . '</strong> (total rental time: ' . $number_days . ' days).'; ?></p>
                <table>
                    <tr>
                        <td>Price per vehicle and day</td>
                        <td id="price">$<?php echo number_format($booking['price_day'], 2); ?></td>
                    </tr>
                    <tr>
                        <td>Rental period</td>
                        <td id="days"><?php echo $number_days; ?> day(s)</td>
                    </tr>
                    <tr>
                        <td>Rental objects</td>
                        <td id="cars"><?php echo $booking['quantity']; ?> vehicle(s)</td>
                    </tr>
                    <tr>
                        <td>Total price</td>
                        <td id="total">$<?php echo number_format($car->price * $booking['quantity'] * $number_days, 2); ?></td>
                    </tr>
                </table>
            </div>
            <div id="pick-up" class="rounded-block">
                <h2>Pick-up details</h2>
                <p><strong>Location:</strong> WheelyFast Sydney</p>
                <p><strong>Address:</strong> 15 Broadway, Ultimo NSW 2007, Australia</p>
                <p><strong>Phone:</strong> 1234 567 890</p>
                <hr>
                <p><strong>What you need at pick-up:</strong>
                <ul>
                    <li>Booking number (yours is: <?php echo $id ?>)</li>
                    <li>Each driver's valid driver licence</li>
                    <li>For non-English licences: official translation or International Driving Permit</li>
                    <li>Each driver's ID card or passport</li>
                    <li>Credit or debit card in the main driver's name (Visa, Mastercard, or American Express)</li>
                </ul></p>
            </div>
        </div>
    </main>
</html>