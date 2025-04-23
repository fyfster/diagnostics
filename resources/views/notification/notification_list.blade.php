@include('common/header')
@include('common/sidebar')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        @include('common/menu_header')
        @include('common/message')

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Content Row -->
            <div class="row">

            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('notification.notification_history') }}</h6>
                    </div>
                    <div class="card-body">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="btn-group float-right mb-4">
                                <select class="custom-select" id="carId" aria-label="Select a car">
                                    <option value="0" selected>{{ __('notification.select_car') }}</option>
                                    @foreach($cars as $car)
                                        <option value="{{ $car->id }}">{{ $car->name }}</option>
                                    @endforeach
                                </select>
                                <div class="dropdown-menu" id="carId">
                                    @foreach($cars as $car)
                                        <a class="dropdown-item" data-value="{{ $car->id }}">{{ $car->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="notificationDataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('notification.title') }}</th>
                                            <th>{{ __('notification.date') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('common/footer')
<script>
    var URL = {
        notificationListDataTables: "{{ route('notification-list-dataTables', ['userId' => $userId]) }}"
    };
</script>
<script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/notification-history.js') }}"></script>