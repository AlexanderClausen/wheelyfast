<?php
include 'functions.php';

if (isset($_POST['id'], $_POST['start_date'], $_POST['end_date'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['price'], $_POST['number'])) {
    if (checkCarAvailability($_POST['id'], $_POST['start_date'], $_POST['end_date'], 'lowest') < $_POST['number']) {
        header('Location: reservation.php?error=notavailable');
        exit;
    } else {
        ['code' => $code, 'order_id' => $order_id] = saveBooking($_POST['id'], $_POST['start_date'], $_POST['end_date'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['price'], $_POST['number']);
        clearSession();
        header('Location: booking.php?id=' . $order_id . '&code=' . $code);
    }
} else {
    header('Location: index.php');
    exit;
}