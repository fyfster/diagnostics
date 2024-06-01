$(document).ready(function() {
    var refreshIntervalId;
    
    $('#userDataTable').DataTable({
        ajax: {
            url: URL.userListDataTables,
            type: 'POST',
            data: {
                "_token": TOKEN,
            }
        },
        columns: [
            { data: 'username'},
            { data: 'email'},
            { data: 'name'},
            { data: 'actions'}
        ],
        processing: true,
        serverSide: true
    });

    $(document).on('click', '.user-delete-btn', function() {
        $('.user-delete-yes').attr('href', $(this).data('href'));
    });
});