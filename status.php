<?php
include 'functions.php';

if (isset($_GET['id'], $_GET['code'], $_GET['newstatus'])) {
    changeBookingStatus($_GET['id'], $_GET['code'], $_GET['newstatus']);
    header('Location: booking.php?id=' . $_GET['id'] . '&code=' . $_GET['code']);
} else {
    header('Location: index.php');
    exit;
}