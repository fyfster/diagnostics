@include('common/header')
@include('common/sidebar')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">
        @include('common/menu_header')

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Content Row -->
            <div class="row">

                <!-- Last Race -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('dashboard.last_race') }}</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">

                            <!-- Card Content - Collapse -->
                            <div class="chart-area">
                                {!! $lastRaceChart->render() !!}
                            </div>
                            <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.view_all_races') }}: &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('dashboard.notifications') }}</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="myPieChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-danger"></i> {{ __('dashboard.speed') }}
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-warning"></i> {{ __('dashboard.rotation') }}
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-primary"></i> {{ __('dashboard.information') }}
                                </span>
                            </div>
                            <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                        </div>
                    </div>
                </div>

                @if (auth()->user()->hasPermission('car-read'))
                <div class="col-lg-6 mb-4">
                    <div class="card shadow mb-4">
                        <a href="#collapseCardDaily" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardDaily">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">{{ __('dashboard.daily_stats') }}</h6>
                            </div>
                        </a>

                        <div class="collapse show" id="collapseCardDaily">
                            <div class="card-body">
                                <div class="col-xl-12 col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h6 font-weight-bold text-primary text-uppercase mb-1">
                                                    {{ __('dashboard.km_done') }}</div>
                                                    <div class="h2 mb-0 font-weight-bold text-gray-800">155</div>
                                                    <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-car-side fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="col-xl-12 col-md-6 mb-4">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h6 font-weight-bold text-success text-uppercase mb-1">
                                                    {{ __('dashboard.nr_of_races') }}</div>
                                                    <div class="h2 mb-0 font-weight-bold text-gray-800">2</div>
                                                    <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="col-xl-12 col-md-6 mb-4">
                                    <div class="card border-left-info shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h6 font-weight-bold text-info text-uppercase mb-1">
                                                    {{ __('dashboard.avg_speed') }}</div>
                                                    <div class="h2 mb-0 font-weight-bold text-gray-800">33</div>
                                                    <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow mb-4">
                        <a href="#collapseCardWeekly" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardWeekly">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">{{ __('dashboard.weekly_stats') }}</h6>
                            </div>
                        </a>

                        <div class="collapse show" id="collapseCardWeekly">
                            <div class="card-body">
                                <div class="col-xl-12 col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h6 font-weight-bold text-primary text-uppercase mb-1">
                                                    {{ __('dashboard.km_done') }}</div>
                                                    <div class="h2 mb-0 font-weight-bold text-gray-800">3,763</div>
                                                    <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-car-side fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="col-xl-12 col-md-6 mb-4">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h6 font-weight-bold text-success text-uppercase mb-1">
                                                    {{ __('dashboard.nr_of_races') }}</div>
                                                    <div class="h2 mb-0 font-weight-bold text-gray-800">43</div>
                                                    <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="col-xl-12 col-md-6 mb-4">
                                    <div class="card border-left-info shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h6 font-weight-bold text-info text-uppercase mb-1">
                                                    {{ __('dashboard.avg_speed') }}</div>
                                                    <div class="h2 mb-0 font-weight-bold text-gray-800">64</div>
                                                    <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow mb-4">
                        <a href="#collapseCardMonthly" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardMonthly">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">{{ __('dashboard.monthly_stats') }}</h6>
                            </div>
                        </a>

                        <div class="collapse show" id="collapseCardMonthly">
                            <div class="card-body">
                                <div class="col-xl-12 col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h6 font-weight-bold text-primary text-uppercase mb-1">
                                                    {{ __('dashboard.km_done') }}</div>
                                                    <div class="h2 mb-0 font-weight-bold text-gray-800">12,321</div>
                                                    <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-car-side fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="col-xl-12 col-md-6 mb-4">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h6 font-weight-bold text-success text-uppercase mb-1">
                                                    {{ __('dashboard.nr_of_races') }}</div>
                                                    <div class="h2 mb-0 font-weight-bold text-gray-800">213</div>
                                                    <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="col-xl-12 col-md-6 mb-4">
                                    <div class="card border-left-info shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h6 font-weight-bold text-info text-uppercase mb-1">
                                                    {{ __('dashboard.avg_speed') }}</div>
                                                    <div class="h2 mb-0 font-weight-bold text-gray-800">54</div>
                                                    <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow mb-4">
                        <a href="#collapseCardYearly" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardYearly">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">{{ __('dashboard.yearly_stats') }}</h6>
                            </div>
                        </a>

                        <div class="collapse show" id="collapseCardYearly">
                            <div class="card-body">
                                <div class="col-xl-12 col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h6 font-weight-bold text-primary text-uppercase mb-1">
                                                    {{ __('dashboard.km_done') }}</div>
                                                    <div class="h2 mb-0 font-weight-bold text-gray-800">22,444</div>
                                                    <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-car-side fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="col-xl-12 col-md-6 mb-4">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h6 font-weight-bold text-success text-uppercase mb-1">
                                                    {{ __('dashboard.nr_of_races') }}</div>
                                                    <div class="h2 mb-0 font-weight-bold text-gray-800">1,032</div>
                                                    <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="col-xl-12 col-md-6 mb-4">
                                    <div class="card border-left-info shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h6 font-weight-bold text-info text-uppercase mb-1">
                                                    {{ __('dashboard.avg_speed') }}</div>
                                                    <div class="h2 mb-0 font-weight-bold text-gray-800">60</div>
                                                    <a class="h6 text-xs" target="_blank" rel="nofollow" href="">{{ __('dashboard.for_all_cars') }}: &rarr;</a>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

@include('common/footer')
<!-- Page level custom scripts -->
<script src="{{ asset('js/chart/Chart.min.js') }}"></script>
<script src="{{ asset('js/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/chart-pie-demo.js') }}"></script>