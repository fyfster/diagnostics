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
                        <h6 class="m-0 font-weight-bold text-primary">Lista masini</h6>
                        <button class="btn btn-sm btn-primary" style="float: right; margin-top: -25px;" onclick="window.location.href='{{ route('car-form') }}'">Adauga masina</button>
                    </div>
                    <div class="card-body">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="carDataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nume</th>
                                            <th>Marca</th>
                                            <th>Model</th>
                                            <th>VIN</th>
                                            <th>Nr. Inmatriculare</th>
                                            <th>An productie</th>
                                            <th>Actiuni</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="carDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Car delete?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Esti sigur ca doresti sa stergi masina din lista.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                        <a class="btn btn-primary car-delete-yes" >Yes</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="carInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Statistici masina</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-12 mb-4 border-left-primary">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase ml-2 mt-2 mb-2">Data statistici: </div><b style="margin-top: -30px" class="float-right" id="last_stats_date">{{date('Y-m-d H:i:s')}}</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-12 mb-4 border-left-danger">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Valori maxime in timpul ultimei rulari</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rotatii - <span id="max_rpm_val">-</span></div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Viteza - <span id="max_speed_val">-</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card mb-4 py-3 border-left-secondary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Viteza</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="speed_val">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="card mb-4 py-3 border-left-secondary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Nivel compustibil</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="fuel_val">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="card mb-4 py-3 border-left-secondary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Rotatii</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="rpm_val">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="card mb-4 py-3 border-left-secondary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Temperatura racitor</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="coolant_val">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@include('common/footer')
<script>
    var TOKEN = "{{ csrf_token() }}";
    var userId = "{{ $userId }}";
    var URL = {
        carListDataTables: "{{ route('car-list-dataTables', ['userId' => $userId]) }}"
    };
</script>
<script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/car/car.js') }}"></script>