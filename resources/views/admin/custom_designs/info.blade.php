@extends('admin.layouts.master')

@section('content')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
           @include('admin.layouts.topbar')
                <!-- Begin Page Content -->
                <div class="alert alert-success alert-block" style="display: none">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong></strong>
                </div>
                <div class="overlay" style="display: none">
                    <img src="{{URL::to('/images/loader.gif')}}" class="loader_image" height="100" width="100">
                </div>
                
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Design Info</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="{{ route('admin.custom_designs.index')}}" class="btn btn-primary" style="float: right;">Back</a>
                        </div>
                        <div class="card-body">
                                <div class="row goalWrap">
                                    <input type="hidden" name="design_id" value="{{ $design->id }}">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group" >
                                            
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group" >
                                            <label for="forSubject">Name</label>
                                            <input type="text" class="form-control" value="{{ $design->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group" >
                                            <label for="forSubject">Description</label>
                                            <textarea class="form-control" name="description" id="exampleDescription" rows="3">{{ $design->description}}</textarea>
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

   @push('js')
   <script>
    let download_plan = "{{route('admin.plans.download')}}";
    </script>
    <script src="{{URL::to('/admin-panel/js/all.js')}}"></script>
   @endpush