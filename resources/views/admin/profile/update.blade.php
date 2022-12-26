@extends('admin.layouts.master') @section('content')
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
  <!-- Main Content -->
  <div id="content"> @include('admin.layouts.topbar')
    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Page Heading -->
     
      <!-- Content Row -->
      <div class="row">
        <div class="col-md-8">
          <div class="card mb-4"> @if ($message = Session::get('username_success')) 
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>{{ $message }}</strong>
            </div> @endif <div class="card-header">{{ __('Reset Profile') }}</div>
            <div class="card-body">
              <form method="POST" action="{{ route('admin.update-profile')}}" enctype="multipart/form-data"> 
                @csrf 
                <div class="row mb-3">
                  <label for="image" class="col-md-4 col-form-label text-md-end"></label>
                  <div class="col-md-6">
                    <img class="img-profile rounded-circle" src="{{ (Auth::user()->profile_pic) ? Storage::url(Auth::user()->profile_pic) : URL::to('/public/admin-panel/img/undraw_profile.svg')}}" height="100px" width="100px">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Profile Picture') }}</label>
                  <div class="col-md-6">
                    <input id="profile_picture" type="file" class="form-control" name="profile_picture" accept="image/png, image/gif, image/jpeg"> 
                    @error('profile_picture') 
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span> 
                    @enderror
                  </div>
                </div>
                <div class="row mb-3">
                    <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>
                    <div class="col-md-6">
                      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" value="{{ $user->name }}"> 
                      @error('name') 
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> 
                      @enderror
                    </div>
                </div>
                <div class="row mb-3">
                  <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                  <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="email" value="{{ $user->email }}"> 
                    @error('email') 
                      <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> 
                    @enderror
                  </div>
              </div>
              <div class="row mb-3">
                <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>
                <div class="col-md-6">
                  <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" autocomplete="phone" value="{{ $user->phone }}"> 
                  @error('phone') 
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> 
                  @enderror
                </div>
              </div>
                <div class="row mb-0">
                  <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                      {{ __('Update Profile') }}
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      <div class="col-md-8">
        <div class="card"> @if ($message = Session::get('password_success')) 
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
          </div> @endif <div class="card-header">{{ __('Reset Password') }}</div>
          <div class="card-body">
            <form method="POST" action="{{ route('admin.password_reset')}}" class="reset_password"> @csrf <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>
                <div class="col-md-6">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"> @error('password') <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span> @enderror
                  <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                </div>
              </div>
              <div class="row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                <div class="col-md-6">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  <span toggle="#password-field" class="fa fa-fw fa-eye field_icon confirm-toggle-password"></span>
                </div>
              </div>
              <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Reset Password') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> 
@endsection
@push('js')
    <script>
      jQuery(document).ready(function(){
        jQuery("body").on('click', '.toggle-password', function() {
          jQuery(this).toggleClass("fa-eye fa-eye-slash");
            var input = jQuery("#password");
            if (input.attr("type") === "password") {
              input.attr("type", "text");
            } else {
              input.attr("type", "password");
            }
        });
        jQuery("body").on('click', '.confirm-toggle-password', function() {
          jQuery(this).toggleClass("fa-eye fa-eye-slash");
            var input = jQuery("#password-confirm");
            if (input.attr("type") === "password") {
              input.attr("type", "text");
            } else {
              input.attr("type", "password");
            }
        });
      });
    </script>
@endpush