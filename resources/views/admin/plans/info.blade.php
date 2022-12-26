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
                    <img src="{{URL::to('/public/images/loader.gif')}}" class="loader_image" height="100" width="100">
                </div>
                
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Plan Info</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="{{ route('admin.plans.index')}}"class="btn btn-primary" style="float: right;">Back</a>
                        </div>
                        <div class="card-body">
                                <div class="row goalWrap">
                                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                    <div class="col-xs-12 col-sm-12 col-md-1">
                                        <div class="form-group">
                                            @if($plan->ext == 'pdf' || $plan->ext == 'doc' || $plan->ext == 'docx' || $plan->ext == 'txt') 
                                                <img src="{{URL::to('/public/images/PDF_file_icon.svg.png')}}" height="100" width="100">
                                            @else
                                                <img src="@if($plan->image)/public{{Storage::url($plan->image)}} @else {{URL::to('/public/images/PDF_file_icon.svg.png')}}@endif" height="150" width="150">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group" >
                                            <label for="forSubject">Name</label>
                                            <input type="text" class="form-control" value="{{ $plan->name }}" readonly>
                                        </div>
                                    </div>
                                   
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group" >
                                            <label for="forSubject">Download Count</label>
                                            <input type="text" class="form-control" value="{{ $download_count }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                    <p class="mb-0"> 
                                        <strong>Plan Specifications</strong>
                                    </p>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <div class="form-group" >
                                                <label for="forBath">Bath</label>
                                                <input type="text" class="form-control" value="{{ $plan->bath }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group" >
                                                <label for="forBedroom">Bedroom</label>
                                                <input type="text" class="form-control" value="{{ $plan->bedroom }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group" >
                                                <label for="forKitchen">Kitchen</label>
                                                <input type="text" class="form-control" value="{{ $plan->kitchen }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group" >
                                                <label for="forToilets">Toilets</label>
                                                <input type="text" class="form-control" value="{{ $plan->toilets }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group" >
                                                <label for="forLivingRoom">Living Room</label>
                                                <input type="text" class="form-control" value="{{ $plan->living_room }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group" >
                                                <label for="forVerandah">Verandah</label>
                                                <input type="text" class="form-control" value="{{ $plan->verandah }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group" >
                                                <label for="forStore">Store</label>
                                                <input type="text" class="form-control" value="{{ $plan->store }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group" >
                                                <label for="forStory">Story</label>
                                                <input type="text" class="form-control" value="{{ $plan->story }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-4">
                                            <div class="form-group" >
                                                <label for="forSqm">Sq. m</label>
                                                <input type="text" class="form-control" value="{{ $plan->sqm }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4">
                                            <div class="form-group" >
                                                <label for="forLength">Length</label>
                                                <input type="text" class="form-control" value="{{ $plan->length }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4">
                                            <div class="form-group" >
                                                <label for="forWidth">Width</label>
                                                <input type="text" class="form-control" value="{{ $plan->width }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group" >
                                                <label for="forDescription">Description</label>
                                                <textarea class="form-control" name="description" id="exampleDescription" rows="3">{{ $plan->description}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <label for="forGalleryImages">Gallery Images</label>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                                    
                                                        @foreach ($gallery_images as $item)
                                                        <div class="form-group videoImgBlock gallery_images" style="display:inline-flex;">
                                                            <img src="@if($item->gallery_images)/public{{Storage::url($item->gallery_images)}}@else{{URL::to('/public/images/PDF_file_icon.svg.png')}}@endif" height="100" width="100">
                                                        </div>
                                                        @endforeach
                                            </div>
                                        </div>
                                    @if ($plan_count < 3)
                                        <a download="{{$plan->name}}" href="/public{{ Storage::url($plan->image) }}" class="btn btn-primary" id="download_plan" data-id="{{$plan->id}}">Download</a>
                                    @endif
                                    
                             
                      
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
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">              
            <div class="modal-body">
                <div id="carouselExample" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($gallery_images as $key => $item)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <img src="@if($item->gallery_images) /public{{Storage::url($item->gallery_images)}} @else {{URL::to('/public/images/PDF_file_icon.svg.png')}}@endif" height="100" width="100">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                    </a>
                </div>
                </div>

            </div>
          </div>
        </div>
      </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

 
   @endsection

   @push('js')
   <script>
    let download_plan = "{{route('admin.plans.download')}}";
    </script>
    <script src="{{URL::to('/public/admin-panel/js/all.js')}}"></script>
   @endpush