@extends('admin.layouts.master')

@section('content')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
           @include('admin.layouts.topbar')
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Customer Info</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="{{ route('admin.customers.index')}}"class="btn btn-primary" style="float: right;">Back</a>
                        </div>
                        <div class="card-body">
                            <div class="row goalWrap">
                                <input type="hidden" name="user_id" value="{{ $customer->id }}">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group" >
                                        <img class="customer_image" src="@if($customer->profile_pic)  /public/{{Storage::url($customer->profile_pic)}} @else {{URL::to('/public/images/user_icon.png')}}@endif" height="100" widht="100" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group" >
                                        <label for="forName">Name</label>
                                        <input type="text" class="form-control" value="{{ $customer->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group" >
                                        <label for="forEmail">Email</label>
                                        <input type="text" class="form-control" value="{{ $customer->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group" >
                                        <label for="forPhone">Phone</label>
                                        <input type="text" class="form-control" value="{{ $customer->phone }}" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group" >
                                        <label for="forDateOfBirth">Date Of Birth</label>
                                        <input type="text" class="form-control" value="{{ $customer->dob }}" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group" >
                                        <label for="forDownloadedPlans">Downloaded Plans</label>
                                        <input type="text" class="form-control" value="{{ $customer->plans->count() }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

           
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


   @endsection