<html>
    <div id="hamburger-div">
        <span id="nav-hamburger" class="material-symbols-outlined">menu</span>
    </div>

    <form id="selector" action="carlist.php" method="get">
        <table>
            <tr>
                <td><span class="material-symbols-outlined nav-icon">search</span></td>
                <td><input type="input" id="search-bar" name="search" placeholder="Search for a car"></td>
            </tr>
            <tr>
                <td><span class="material-symbols-outlined nav-icon">line_start_diamond</span></td>
                <td class="selector-item">
                    <label for="start-date" class="smalltext">From:</label>
                    <input type="date" id="start-date" name="start-date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                </td>
            </tr>
            <tr>
                <td><span class="material-symbols-outlined nav-icon">line_end_diamond</span></td>
                <td class="selector-item">
                    <label for="end-date" class="smalltext">To:</label>
                    <input type="date" id="end-date" name="end-date" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                </td>
            </tr>
            <tr>
                <td><span class="material-symbols-outlined nav-icon">star</span></td>
                <td class="selector-item">
                    <label for="premium-filter" class="smalltext">Premium cars:</label>
                    <select id="premium-filter" name="premium-filter">
                        <option value="all">Show all</option>
                        <option value="only">Only</option>
                        <option value="exclude">Exclude</option>
                    </select>
                </td>
            </tr>
        </table>
        <input type="hidden" name="location_file" value="">
        <input type="hidden" name="nav-key" value="">
        <input type="hidden" name="nav-value" value="">
    </form>

    <ul>
        <li class="nav-link">
            <div class="main-item">
                <span class="material-symbols-outlined nav-icon">filter_none</span>
                <span class="nav-text" data-key="">Show all</span>
            </div>
        </li>
        <li class="parent-item">
            <div class="main-item">
                <span class="material-symbols-outlined nav-icon">straighten</span>
                <span class="nav-text">Class</span>
            </div>
            <ul><?php getNav("class") ?></ul>
        </li>
        <li class="parent-item">
            <div class="main-item">
                <span class="material-symbols-outlined nav-icon">directions_car</span>
                <span class="nav-text">Type</span>
            </div>
            <ul><?php getNav("type") ?></ul>
        </li>
        <li class="parent-item">
            <div class="main-item">
                <span class="material-symbols-outlined nav-icon">brand_awareness</span>
                <span class="nav-text">Make</span>
            </div>
            <ul><?php getNav("make") ?></ul>
        </li>
    </ul>
</html>