<?php
include 'functions.php';

if(isset($_GET['id'])) { $_SESSION['id'] = $_GET['id']; }
if(isset($_GET['start_date'])) { $_SESSION['start_date'] = $_GET['start_date']; }
if(isset($_GET['end_date'])) { $_SESSION['end_date'] = $_GET['end_date']; }
if(isset($_GET['number'])) { $_SESSION['number'] = $_GET['number']; }

if (empty($_SESSION)) {
    header("Location: index.php");
    exit();
} else {
    $car = getCarDetails($_SESSION['id'], $_SESSION['start_date'], $_SESSION['end_date']);
    $available = checkCarAvailability($_SESSION['id'], $_SESSION['start_date'], $_SESSION['end_date'], 'lowest');
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
        <div id="logo-div">
            <span id="top-bar-logo" class="material-symbols-outlined">speed</span>
            <span id="top-bar-logo-text">WheelyFast</span>
            <span id="top-bar-location">Sydney</span>
        </div>
        <div id="reservation-div">
            <?php
            if (!empty($_SESSION)) {
                echo '<form style="height: 100%;" action="reset.php" method="psot"><button id="reset-button" class="big-button">Cancel reservation</button></form>';
            }
            ?>
        </div>
    </header>
    <main>
        <div id="reservation-overview">
            <h1>Reservation overview</h1>
            <div id="reservation-details">
                <div id="car-details">
                    <h2><?php echo $car->make . ' ' . $car->model . ' (' . $car->year . ')'; ?></h2>
                    <form>
                        <input type="hidden" name="id" value="<?php echo $car->id; ?>">
                        <label for="start_date">Start date</label>
                        <input type="date" id="start-date" name="start_date" value="<?php echo $_SESSION['start_date']; ?>" min="<?php echo date('Y-m-d'); ?>" required>
                        <label for="end_date">End date</label>
                        <input type="date" id="end-date" name="end_date" value="<?php echo $_SESSION['end_date']; ?>" min="<?php echo date('Y-m-d'); ?>" required>
                        <label for="number">Number of cars</label>
                        <input type="number" id="number" name="number" value="1" min="1" max="<?php echo $available; ?>" required>
                    </form>
                </div>
            </div>
    </main>
</body>
</html>