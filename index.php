<?php
// Inspiration: https://dribbble.com/shots/22268137-Car-Rental-Website
include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Wheely Fast</title>
    
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js" integrity="sha256-sw0iNNXmOJbQhYFuC9OF2kOlD5KQKe1y5lfBn4C9Sjg=" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <a id="top-bar-logo" class="logo" href="./">Wheely Fast</a>

        <!-- Start and end date selector and search bar-->
        <form id="selector" action="carlist.php" method="get">
            <input type="text" id="search-bar" name="search" placeholder="Search for a car">
            <label for="start-date">Start Date</label>
            <input type="date" id="start-date" name="start-date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
            <label for="end-date">End Date</label>
            <input type="date" id="end-date" name="end-date" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" min="<?php echo date('Y-m-d'); ?>" required>
            <label for="exclude-unavailable">Exclude unavailable cars</label>
            <input type="checkbox" id="exclude-unavailable" name="exclude-unavailable">
            <input type="hidden" name="nav-key" value="">
            <input type="hidden" name="nav-value" value="">
        </form>
    </header>
    <nav id="sidenav" class="sidenav">
    <span id="nav-hamburger" class="material-symbols-outlined">menu</span>
        <ul>
            <li>
                <span class="material-symbols-outlined nav-icon">view_list</span>
                <span class="nav-text nav-link" data-key="">Show all</span>
            </li>
            <li>
                <span class="material-symbols-outlined nav-icon">straighten</span>
                <span class="nav-text">Class</span>
                <ul><?php getNav("class") ?></ul>
            </li>
            <li>
                <span class="material-symbols-outlined nav-icon">directions_car</span>
                <span class="nav-text">Type</span>
                <ul><?php getNav("type") ?></ul>
            </li>
            <li>
                <span class="material-symbols-outlined nav-icon">brand_awareness</span>
                <span class="nav-text">Make</span>
                <ul><?php getNav("make") ?></ul>
            </li>
        </ul>
    </nav>
    <main id="main">
        <section class="container">
            <div id="car-list">
            </div>
            <div id="car-details">
            </div>
        </section>
    </main>
    <script src="main.js"></script>
</body>