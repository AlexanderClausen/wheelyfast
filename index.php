<?php
// Inspiration: https://dribbble.com/shots/22268137-Car-Rental-Website
include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>WheelyFast</title>
    
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js" integrity="sha256-sw0iNNXmOJbQhYFuC9OF2kOlD5KQKe1y5lfBn4C9Sjg=" crossorigin="anonymous"></script>
</head>
<body>
    <header id="header">
        <div id="logo-div">
            <!-- <a id="top-bar-logo" class="logo" href="./">WheelyFast</a> -->
            <span id="top-bar-logo" class="material-symbols-outlined">speed</span>
            <span id="top-bar-logo-text">WheelyFast</span>
            <span id="top-bar-location">Sydney</span>
        </div>
    </header>
    <nav id="sidenav" class="sidenav">
        <?php include 'nav.php'; ?>
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