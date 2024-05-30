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

    $('#end-date').on('change', function() {
        updatePriceTable();
    });

    $('#reservation-overview input').on('change', function() {
        $('#changewarning').removeAttr('style');
    });
});