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
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('user.list') }}</h6>
                        <button class="btn btn-sm btn-primary" style="float: right; margin-top: -25px;" onclick="window.location.href='{{ route('user-form') }}'">{{ __('user.add_user') }}</button>
                    </div>
                    <div class="card-body">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="userDataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('user.username') }}</th>
                                            <th>{{ __('user.email') }}</th>
                                            <th>{{ __('user.name') }}</th>
                                            <th>{{ __('user.actions') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="userDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('user.delete_user') }}</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">{{ __('user.delete_confirm') }}</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('common.no') }}</button>
                        <a class="btn btn-primary user-delete-yes">{{ __('common.yes') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('common/footer')
<script>
    var TOKEN = "{{ csrf_token() }}";
    var URL = {
        userListDataTables: "{{ route('user-list-dataTables') }}"
    };
</script>
<script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/user/user.js') }}"></script>