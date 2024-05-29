<?php
include 'functions.php';

if(isset($_GET['id'])) { $_SESSION['id'] = $_GET['id']; }
if(isset($_GET['start_date'])) { $_SESSION['start_date'] = $_GET['start_date']; }
if(isset($_GET['end_date'])) { $_SESSION['end_date'] = $_GET['end_date']; }

$car = getCarDetails($_SESSION['id'], $_SESSION['start_date'], $_SESSION['end_date']);

?>

<!DOCTYPE html>
<html lang="en">
    <?php if (!empty($_SESSION)) { ?>
        <p>Booking car <?php echo $car->name; ?> from <?php echo $_SESSION['start_date']; ?> to <?php echo $_SESSION['end_date']; ?></p>
    <?php } else { ?>
        <p>No car selected</p>
    <?php } ?>
</html>