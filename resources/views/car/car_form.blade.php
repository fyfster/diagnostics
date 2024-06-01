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
                        @isset($carId)
                            <h6 class="m-0 font-weight-bold text-primary">Modifica <label class="m-0 font-weight-bold text-primary">{{ $car->name }}</label></h6> 
                        @else
                            <h6 class="m-0 font-weight-bold text-primary">Adauga o noua masina</h6>
                        @endisset
                    </div>
                    <div class="card-body">
                        <form action="{{ route($routeUrl) }}" method="POST">
                            {{ csrf_field() }}
                            @isset($carId)
                                <input name="car_id" type="hidden" class="form-control" value="{{ $carId }}">
                            @endisset
                            <div class="form-group">
                                <label for="exampleInputBrand">Marca</label>
                                <input name="brand" class="form-control" id="exampleInputBrand" value="{{ $car->brand ?? session('brand') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputModel">Model</label>
                                <input name="model" class="form-control" id="exampleInputModel" value="{{ $car->model ?? session('model') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputVIN">VIN</label>
                                <input name="vin" class="form-control" id="exampleInputVIN" value="{{ $car->vin ?? session('vin') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleRegistrationNumber">Nr. Inmatriculare</label>
                                <input name="registration_number" class="form-control" id="exampleRegistrationNumber" value="{{ $car->registration_number ?? session('registration_number') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputNickName">Porecla masina</label>
                                <input name="name" class="form-control" id="exampleInputNickName" value="{{ $car->name ?? session('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputProductionYear">An productie</label>
                                <input type="number" name="production_year" class="form-control" id="exampleInputProductionYear" value="{{ $car->production_year ?? session('production_year') }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                            @isset($carId)
                            <a href="{{ route('car-list') }}" class="btn btn-secondary">Lista</a>
                            @endisset
                        </form>
                    </div>
                </div>
            </div>

        </div>

@include('common/footer')