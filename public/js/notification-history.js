$(document).ready(function () {

    var notificationDataTable = $('#notificationDataTable').DataTable({
        ajax: {
            url: URL.notificationListDataTables,
            type: 'GET',
            data: function (d) {
                // Get the selected value from the dropdown and pass it as a parameter
                d.car_id = $('#carId').val();
                d._token = TOKEN;
            }
        },
        order: [
            [1, 'desc']
        ],
        columns: [
            { data: 'title'},
            { data: 'created_at'},
        ],
        columnDefs: [
            { orderable: false, targets: 0 }
        ],
        processing: true,
        serverSide: true
    });

    $(document).on('change', '#carId', function() {
        notificationDataTable.ajax.reload()
    });
    
});