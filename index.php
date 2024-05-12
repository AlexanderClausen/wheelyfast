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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js" integrity="sha256-sw0iNNXmOJbQhYFuC9OF2kOlD5KQKe1y5lfBn4C9Sjg=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
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
        </form>
    </header>
    <main>
        <section>
            <div id="car-list">

            </div>
        </section>
    </main>
    <script>
        $(document).ready(function() {
            // Function to load car list
            function loadCarList() {
                var formData = $('#selector').serialize();
                $.ajax({
                    type: 'GET',
                    url: 'carlist.php',
                    data: formData,
                    success: function(data) {
                        $('#car-list').html(data);
                    }
                });
            }

            // Initial car list load
            loadCarList();

            // Reload car list when user clicks out of a form field
            $('#selector').find('input').on('blur', function() {
                if (this.value != this.defaultValue) {
                    loadCarList();
                }
            });

            $('#exclude-unavailable').on('change', function() {
                loadCarList();
            });

            // Enforce end date is later than start date
            $('#start-date').on('change', function() {
                $('#end-date').attr('min', this.value);
                if ($('#end-date').val() < this.value) {
                    $('#end-date').val(this.value).effect("pulsate", { times: 2 }, 500);
                }
            });

            // Prevent manual date input
            $('#selector').find('input[type="date"]').on('keydown', function(e) {
                e.preventDefault();
            });

            // Prevent enter key search bar
            $('#search-bar').on('keydown', function(e) {
                if (e.key == 'Enter') {
                    e.preventDefault();
                    loadCarList();
                }
            });

            // Autocomplete search bar
            $(function() {
                $.ajax({
                    url: 'autocomplete.php',
                    type: 'get',
                    success: function(data) {
                        var autocompleteData = Object.values(JSON.parse(data))
                        $("#search-bar").autocomplete({
                            source: autocompleteData
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('AJAX error:', textStatus, errorThrown);
                    }
                });
            });
        });
    </script>
</body>