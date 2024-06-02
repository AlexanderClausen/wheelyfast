<?php
include 'functions.php';

if(isset($_GET['id'])) { $_SESSION['id'] = $_GET['id']; }
if(isset($_GET['start_date'])) { $_SESSION['start_date'] = $_GET['start_date']; }
if(isset($_GET['end_date'])) { $_SESSION['end_date'] = $_GET['end_date']; }
if(isset($_GET['number'])) { $_SESSION['number'] = $_GET['number']; } else { $_SESSION['number'] = 1; }
if(isset($_GET['error'])) { $error = $_GET['error']; } else { $error = ''; }

if (empty($_SESSION) || !isset($_SESSION['id']) || !isset($_SESSION['start_date']) || !isset($_SESSION['end_date'])) {
    header("Location: index.php");
    exit();
} else {
    $car = getCarDetails($_SESSION['id'], $_SESSION['start_date'], $_SESSION['end_date']);
    $available = checkCarAvailability($_SESSION['id'], $_SESSION['start_date'], $_SESSION['end_date'], 'lowest');
    $number_days = date_diff(date_create($_SESSION['start_date']), date_create($_SESSION['end_date']))->days + 1;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Reservation | WheelyFast</title>
    
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
                echo '<form style="height: 100%;" action="reset.php" method="post"><button id="reset-button" class="big-button">Cancel reservation</button></form>';
            }
            ?>
        </div>
    </header>
    <main>
        <div id="left-column">
        <?php if ($error === 'notavailable') { echo '<div id="notavailable" class="warning">The car is not available on your selected dates. Please check the dates and available quantity and try again.</div>'; } ?>
            <div id="reservation-input" class="rounded-block">
                <h2><?php echo $car->make . ' ' . $car->model . ' (' . $car->year . ')'; ?></h2>
                <img id="car-img" src="./images/<?php echo $car->image; ?>" alt="<?php echo $car->make . ' ' . $car->model; ?>">
                <form action="reservation.php" method="get">
                    <input type="hidden" name="id" value="<?php echo $car->id; ?>">

                    <p <?php if($available !== 0) { echo 'style="display: none;"'; } ?>>Sorry, there are no cars available on these dates. Please choose different dates or select a different vehicle.</p>

                    <div>
                        <label for="start_date">Start date</label>
                        <input type="date" id="start-date" name="start_date" value="<?php echo $_SESSION['start_date']; ?>" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div>
                        <label for="end_date">End date</label>
                        <input type="date" id="end-date" name="end_date" value="<?php echo $_SESSION['end_date']; ?>" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div <?php if($available === 0) { echo 'style="display: none;"'; } ?>>
                        <label for="number">Number of cars (available: <?php echo $available ?>)</label>
                        <input type="number" id="number" name="number" value="<?php echo ($available === 0) ? '0' : '1'; ?>" min="<?php echo ($available === 0) ? '0' : '1'; ?>" max="<?php echo $available; ?>" required>
                    </div>
                    <button id="update-button" type="submit" class="big-button" <?php if($available === 0) { echo 'style="display: none;"'; } ?>><?php echo ($available === 0) ? 'Check availability' : 'Update'; ?></button>
                </form>
            </div>
        </div>

        <div id="right-column">
            <div id="reservation-bookinginfo" class="rounded-block" <?php if($available === 0) { echo 'style="display: none;"'; } ?>>
                <h2>Booking information</h2>
                <div>
                    <p>You are booking a <strong><?php echo $car->make . ' ' . $car->model . ' (' . $car->year . ')'; ?></strong> from <?php echo $_SESSION['start_date'] . ' to ' . $_SESSION['end_date'] . ' (' . $number_days . ' days).'; ?></p>
                </div>
                <div id="changewarning" class="warning" style="display: none;">
                    <span>Click the <strong>Update</strong> button to check availability and show updated information.</span>
                </div>
                <table>
                    <tr>
                        <td>Price per vehicle and day</td>
                        <td id="price">$<?php echo number_format($car->price, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Rental period</td>
                        <td id="days"><?php echo $number_days; ?> day(s)</td>
                    </tr>
                    <tr>
                        <td>Rental objects</td>
                        <td id="cars"><?php echo $_SESSION['number']; ?> vehicle(s)</td>
                    </tr>
                    <tr>
                        <td>Total price</td>
                        <td id="total">$<?php echo number_format($car->price * $_SESSION['number'] * $number_days, 2); ?></td>
                    </tr>
                </table>
            </div>
            <div id="customer-details" class="rounded-block">
                <form id="reservation-form" action="submit.php" method="post">
                    <h2>Customer details</h2>
                    <p>Please fill in your details below. The red asterisk indicates a required field.</p>
                    <div>
                        <label class="required" for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div>
                        <label class="required" for="phone">Phone number</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div>
                        <label class="required" for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div id="licence-check">
                        <input type="checkbox" id="licence" name="licence" required>
                        <label class="required" for="licence">I confirm that I hold a valid driver licence.</label>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $car->id; ?>">
                    <input type="hidden" name="start_date" value="<?php echo $_SESSION['start_date']; ?>">
                    <input type="hidden" name="end_date" value="<?php echo $_SESSION['end_date']; ?>">
                    <input type="hidden" name="number" value="<?php echo $_SESSION['number']; ?>">
                    <input type="hidden" name="price" value="<?php echo $car->price; ?>">
                    <button type="submit" id="reserve-button" class="big-button active">Reserve</button>
                </form>
            </div>
    </main>
    <script src="reservation.js"></script>
</body>
</html>