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
                        @isset($userId)
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('user.change') }} <label class="m-0 font-weight-bold text-primary">{{ $user->username }}</label></h6>
                        @else
                            <h6 class="m-0 font-weight-bold text-primary">{{ __('user.add_new_user') }}</h6>
                        @endisset
                    </div>
                    <div class="card-body">
                        <form action="{{ route($routeUrl) }}" method="POST">
                            {{ csrf_field() }}
                            @isset($userId)
                                <input name="user_id" type="hidden" class="form-control" value="{{ $userId }}">
                            @endisset
                            <div class="form-group">
                                <label for="inputUsername">{{ __('user.username') }}</label>
                                <input name="username" class="form-control" id="inputUsername" value="{{ $user->username ?? session('username') }}" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="inputFirstName">{{ __('user.first_name') }}</label>
                                <input name="first_name" class="form-control" id="inputFirstName" value="{{ $user->first_name ?? session('first_name') }}">
                            </div>
                            <div class="form-group">
                                <label for="inputLastName">{{ __('user.name') }}</label>
                                <input name="name" class="form-control" id="inputLastName" value="{{ $user->name ?? session('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">{{ __('user.email') }}</label>
                                <input name="email" class="form-control" id="inputEmail" value="{{ $user->email ?? session('email') }}">
                            </div>
                            @isset($userId)
                            @else
                                <div class="form-group">
                                    <label for="inputPassword">{{ __('user.password') }}</label>
                                    <input name="password" type="password" class="form-control" id="inputPassword" value="" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="inputConfirmPassword">{{ __('user.confirm_password') }}</label>
                                    <input name="confirm_password" type="password" class="form-control" id="inputConfirmPassword" value="" autocomplete="off">
                                </div>
                            @endisset

                            <button type="submit" class="btn btn-primary">{{ __('common.submit') }}</button>
                            @isset($userId)
                                <a href="{{ route('user-list') }}" class="btn btn-secondary">{{ __('user.list') }}</a>
                            @endisset
                        </form>
                    </div>
                </div>
            </div>

        </div>

@include('common/footer')