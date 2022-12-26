@extends('admin.layouts.master')
@section('content')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

           @include('admin.layouts.topbar')
           <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
           </div>
           @if ($message = Session::get('success'))
           <div class="alert alert-success alert-block">
               <button type="button" class="close" data-dismiss="alert">×</button>    
               <strong>{{ $message }}</strong>
           </div>
           @endif
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Plans</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="{{ route('admin.plans.index')}}"class="btn btn-primary" style="float: right;">Back</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.plans.store') }}" method="post" enctype="multipart/form-data"> 
                                @csrf
                                <div class="form-group">
                                  <label for="planName">Name</label>
                                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{old('name')}}">
                                  @error('name') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                </div>
                                <strong>Plan Specifications</strong>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="planBath">Bath</label>
                                            <input type="number" class="form-control" name="bath" id="bath" placeholder="Bath" value="{{old('bath')}}">
                                            @error('bath') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="planBedroom">Bedroom</label>
                                            <input type="number" class="form-control" name="bedroom" id="bedroom" placeholder="Bedroom" value="{{old('bedroom')}}">
                                            @error('bedroom') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="planKitchen">Kitchen</label>
                                            <input type="number" class="form-control" name="kitchen" id="kitchen" placeholder="Kitchen" value="{{old('kitchen')}}">
                                            @error('kitchen') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="planToilets">Toilets</label>
                                            <input type="number" class="form-control" name="toilets" id="toilets" placeholder="Toilets" value="{{old('toilets')}}">
                                            @error('toilets') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="planLiving_room">Living Room</label>
                                            <input type="number" class="form-control" name="living_room" id="living_room" placeholder="Living Room" value="{{old('living_room')}}">
                                            @error('living_room') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="planStory">Verandah</label>
                                            <input type="number" class="form-control" name="verandah" id="verandah" placeholder="Verandah" value="{{old('verandah')}}">
                                            @error('verandah') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="planStore">Store</label>
                                            <input type="number" class="form-control" name="store" id="store" placeholder="Store" value="{{old('store')}}">
                                            @error('store') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="planStory">Story</label>
                                            <input type="number" class="form-control" name="story" id="story" placeholder="Story" value="{{old('story')}}">
                                            @error('story') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="planSqm">Sq. m</label>
                                            <input type="number" class="form-control" name="sqm" id="sqm" placeholder="Sq. m" value="{{old('sqm')}}">
                                            @error('sqm') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="planLength">Length</label>
                                            <input type="number" class="form-control" name="length" id="length" placeholder="Length" value="{{old('length')}}">
                                            @error('length') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="planWidth">Width</label>
                                            <input type="number" class="form-control" name="width" id="width" placeholder="Width" value="{{old('width')}}">
                                            @error('width') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                               <div class="forn-group">
                                    <label for="planWidth">Drawing List</label>
                                    <table class="table table-bordered" id="dynamic_field">  
                                        <tr>  
                                            <td><input type="text" name="drawing_list[]" placeholder="Add Drawing List" class="form-control name_list"/></td>  
                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
                                        </tr>  
                                    </table> 
                                </div>


                                <div class="form-group">
                                    <label for="planDescription">Short Description</label>
                                    <textarea class="form-control" name="description" id="exampleDescription" rows="3">{{{ old('description') }}}</textarea>
                                    @error('description') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-group">
                                    <label for="planPDF">Plan PDF</label>
                                    <input type="file" class="form-control" name="pdf" id="pdf" accept=".pdf">
                                    @error('pdf') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="planImage">Featured Image</label>
                                    <input type="file" class="form-control" name="featured_image" id="featured_image" accept="image/png, image/jpg,image/jpeg,.doc, .docx,.txt,.pdf">
                                    @error('featured_image') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                </div>
                                    </div>
                                    <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="planGalleryImage">Gallery Images</label>
                                    <input type="file" class="form-control" name="gallery_images[]" id="gallery_images" multiple accept="image/png, image/jpg, image/jpeg">
                                    @error('gallery_images') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
                              </form>
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>
    $(document).ready(function(){ 
           
        var i=1;  

      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="text" name="drawing_list[]" placeholder="Add Drawing List" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  

      $(document).on('click', '.btn_remove', function(){  

           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
    });
      </script>
   @endsection