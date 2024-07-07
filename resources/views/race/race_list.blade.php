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
                        <h6 class="m-0 font-weight-bold text-primary">Ultimele {{ $race_nr }} curse</h6>
                    </div>
                </div>
            </div>
            @foreach($races as $race)
            <div class="col-lg-6 mb-5">
                <div class="card shadow">
                    <!-- Card Header - Accordion -->
                    <a href="#collapseCard{{$race->race_number}}" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCard{{$race->race_number}}">
                        <h6 class="m-0 font-weight-bold text-primary">Cursa pentru {{ $race->min_created_at }} - {{ $race->max_created_at }}
                            <button data-href="{{ route('race-rename', ['raceNr' => $race->race_number]) }}" class="btn btn-danger race-rename-btn btn-sm btn-circle float-right">
                                <i class="fas fa-pencil-alt" data-toggle="modal" data-target="#raceRename"></i>
                            </button>
                        </h6>
                        
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="collapseCard{{$race->race_number}}">
                        <div class="chart-area">
                            {!! $charts[$race->race_number]->render() !!}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

@include('common/footer')
<script>
    var TOKEN = "{{ csrf_token() }}";
    var carId = "{{ $carId }}";
    var URL = {
        rpmChart: "{{ route('car-rpm-chart') }}"
    };
</script>
<script src="{{ asset('js/chart/Chart.js') }}"></script>