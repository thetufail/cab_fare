$(document).ready(function (e) {

    $('#cab_type').on('change', function () {
        if ($('#cab_type').val() == "CedMicro") {
            $('#luggage').prop('disabled', true);
            $('#luggage').val(null);
        } else {
            $('#luggage').prop('disabled', false);
        }
    });

    $('#calculate_fare').on('click', function (e) {
        var pickup_location = $('#pickup_location option:selected').val();
        var drop_location = $('#drop_location option:selected').val();
        var luggage = parseInt($('#luggage').val());
        var cab_type = $('#cab_type').val();
        if (pickup_location == drop_location) {
            alert("Source and destination can't be same. Please choose another one.");
        } else if (pickup_location == 'Current location' || drop_location == 'Enter drop for ride estimate' || cab_type == 'Drop down to select CAB Type') {
            alert("Please enter valid values.");
        } else {
            $.ajax({
                method: "POST",
                url: "calculateFare.php",
                data: {
                    pickup_location: pickup_location,
                    drop_location: drop_location,
                    cab_type: cab_type,
                    luggage: luggage
                },
                dataType: "html",
                success: function (fare_is) {
                    $('#fare').html("<b>$ " + fare_is + ".00</b>");
                },
                error: function () {
                    alert("We're sorry for the inconvenience caused.");
                }
            });
            e.preventDefault();
        }
    });
});