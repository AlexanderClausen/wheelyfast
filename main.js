$(document).ready(function() {
    // Navigation menu
    $('.nav-link').on('click', function() {
        $('#selector').find('input[name="nav-key"]').val($(this).data('key'));
        $('#selector').find('input[name="nav-value"]').val($(this).text());

        loadCarList();
    });

    // Functions to open and close side navigation
    function openNav() {
        document.getElementById("sidenav").style.width = "250px";
        document.getElementById("sidenav").classList.add("open")
        document.getElementById("main").style.marginLeft = "250px";
        document.getElementById("header").style.marginLeft = "250px";
    }
    
    function closeNav() {
        document.getElementById("sidenav").style.width = "60px";
        document.getElementById("sidenav").classList.remove("open")
        document.getElementById("main").style.marginLeft= "60px";
        document.getElementById("header").style.marginLeft = "60px";
        $('.parent-item').removeClass('open');
    }

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

    // Function to load car details
    function loadCarDetails(carId, startDate, endDate) {
        $.ajax({
            type: 'GET',
            url: 'cardetails.php',
            data: { id: carId, start_date: startDate, end_date: endDate},
            success: function(data) {
                $('#car-details').html(data);
            } 
        });
        console.log('Selected car with id ' + carId + ' (' + startDate + ' to ' + endDate + ')');
    }

    // Initial loads
    loadCarList();
    loadCarDetails('');
    closeNav();

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

    // Car details
    $('#car-list').on('click', '.detail-link', function() {
        var carId = $(this).data('id');
        var startDate = $('#start-date').val();
        var endDate = $('#end-date').val();
        loadCarDetails(carId, startDate, endDate);
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

    // Side navigation
    $('#nav-hamburger').on('click', function() {
        if ($('#sidenav').hasClass('open')) {
            closeNav();
        } else {
            openNav();
        }
    });

    $('.parent-item').on('click', function() {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
        } else {
            $(this).addClass('open');
        }
    });

    $('.nav-icon').on('click', function() {
        if (!$('#sidenav').hasClass('open')) {
            openNav();
        }
    });
});