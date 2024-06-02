$(document).ready(function() {
    // Enforce that end date is later than start date
    $('#start-date').on('change', function() {
        $('#end-date').attr('min', this.value);
        if ($('#end-date').val() < this.value) {
            $('#end-date').val(this.value).effect("pulsate", { times: 2 }, 500);
        }
    });

    // Prevent manual date input
    $('#reservation-overview').find('input[type="date"]').on('keydown', function(e) {
        e.preventDefault();
    });

    // Advise user to update after changes
    $('#reservation-overview input').on('change', function() {
        $('#changewarning').removeAttr('style');
        $('#update-button').addClass('active')
    });

    // Form validation
    var phoneInput = document.getElementById('phone');
    var emailInput = document.getElementById('email');

    var phonePattern = /^[0-9]{10}$/;
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    document.getElementById('phone').addEventListener('input', validatePhone);
    document.getElementById('email').addEventListener('input', validateEmail);

    function validatePhone() {
        if (!phonePattern.test(this.value)) {
            this.setCustomValidity('Please enter a valid phone number.');
        } else {
            this.setCustomValidity('');
        }
    }

    function validateEmail() {
        if (!emailPattern.test(this.value)) {
            this.setCustomValidity('Please enter a valid email address.');
        } else {
            this.setCustomValidity('');
        }
    }
});