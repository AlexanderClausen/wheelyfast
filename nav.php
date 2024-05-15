<html>
    <span id="nav-hamburger" class="material-symbols-outlined">menu</span>
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