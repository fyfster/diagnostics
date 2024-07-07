$(document).ready(function() {
    var refreshIntervalId;
    
    $('#carDataTable').DataTable({
        ajax: {
            url: URL.carListDataTables,
            type: 'POST',
            data: {
                "_token": TOKEN,
            }
        },
        columns: [
            { data: 'name'},
            { data: 'brand'},
            { data: 'model'},
            { data: 'vin'},
            { data: 'registration_number'},
            { data: 'production_year'},
            { data: 'actions', className: 'column-actions'}
        ],
        processing: true,
        serverSide: true
    });

    $(document).on('click', '.show-car-stats', function() {
        let carId = $(this).data('id');
        let url = $(this).data('href');

        // Function to send the AJAX request
        var refreshData = function() {
            $.ajax({
                url: url,
                data: {
                    "_token": TOKEN,
                    "carId": carId
                },
                type: 'POST',
                success: function(response) {
                    let carDiagnostics = response.carDiagnostics;
                    $('#carInfo').find('#last_stats_date').html(carDiagnostics.createdAt);
                    $('#carInfo').find('#speed_val').html(carDiagnostics.speed);
                    $('#carInfo').find('#fuel_val').html(carDiagnostics.fuelPercentage + "%");
                    $('#carInfo').find('#rpm_val').html(carDiagnostics.rpm);
                    $('#carInfo').find('#coolant_val').html(carDiagnostics.coolantTemperature + "C");

                    let carDiagnosticsMax = response.carDiagnosticsMax;
                    $('#carInfo').find('#max_rpm_val').html(carDiagnosticsMax ? carDiagnosticsMax.max_rpm : 0);
                    $('#carInfo').find('#max_speed_val').html(carDiagnosticsMax ? carDiagnosticsMax.max_speed : 0);
                    
                    $('#carInfo').modal('show');
                }
            });
        };

        // Send the AJAX request every 2 seconds
        refreshIntervalId = setInterval(refreshData, 2000);

        // Call the function once immediately
        refreshData();
    });

    $(document).on('click', '.car-delete-btn', function() {
        $('.car-delete-yes').attr('href', $(this).data('href'));
    });
    
    // Stop sending the AJAX request when the modal is closed
    $('#carInfo').on('hidden.bs.modal', function () {
        clearInterval(refreshIntervalId);
    });

});