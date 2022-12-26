@extends('admin.layouts.master')

@section('content')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

           @include('admin.layouts.topbar')
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                <div class="overlay" style="display: none">
                  <img src="{{URL::to('/public/images/loader.gif')}}" class="loader_image" height="100" width="100">
              </div>
                <div class="alert alert-success alert-block edit_success">
                  <button type="button" class="close" data-dismiss="alert">×</button>    
                  <strong></strong>
              </div>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Edit Plan</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="{{ route('admin.plans.index')}}"class="btn btn-primary" style="float: right;">Back</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.plans.update',$plan->id) }}" method="POST" enctype="multipart/form-data"> 
                                @csrf 
                                <div class="row goalWrap">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                      <strong>Name:</strong>
                                      <input type="text" name="name" value="{{ $plan->name ?? "" }}" class="form-control" placeholder="Name"> @error('name') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                </div>
                                <p class="mb-0"><strong>Plan Specifications</strong></p>
                                <div class="row">
                                  <div class="col-md-3">
                                      <div class="form-group">
                                        <strong>Bath:</strong>
                                        <input type="text" name="bath" value="{{ $plan->bath ?? "" }}" class="form-control" placeholder="Bath"> @error('bath') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <strong>Bedroom:</strong>
                                      <input type="text" name="bedroom" value="{{ $plan->bedroom ?? "" }}" class="form-control" placeholder="Bedroom"> @error('bedroom') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <strong>Kitchen:</strong>
                                      <input type="text" name="kitchen" value="{{ $plan->kitchen ?? "" }}" class="form-control" placeholder="Kitchen"> @error('kitchen') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                    <strong>Toilets:</strong>
                                    <input type="text" name="toilets" value="{{ $plan->toilets ?? "" }}" class="form-control" placeholder="Toilets"> @error('toilets') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                  </div>
                                </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <strong>Living Room:</strong>
                                      <input type="text" name="living_room" value="{{ $plan->living_room ?? "" }}" class="form-control" placeholder="Living Room"> @error('living_room') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <strong>Verandah:</strong>
                                      <input type="text" name="verandah" value="{{ $plan->verandah ?? "" }}" class="form-control" placeholder="Verandah"> @error('verandah') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <strong>Store:</strong>
                                      <input type="text" name="store" value="{{ $plan->store ?? "" }}" class="form-control" placeholder="Store"> @error('store') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <strong>Story:</strong>
                                      <input type="text" name="story" value="{{ $plan->story ?? "" }}" class="form-control" placeholder="Story"> @error('story') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <strong>Sq. m:</strong>
                                      <input type="text" name="sqm" value="{{ $plan->sqm ?? "" }}" class="form-control" placeholder="Sq. m"> @error('sqm') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                    </div>
                                  </div>
                                  
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                        <strong>Length:</strong>
                                        <input type="text" name="length" value="{{ $plan->length ?? "" }}" class="form-control" placeholder="Length"> @error('length') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                      </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                        <strong>Width:</strong>
                                        <input type="text" name="width" value="{{ $plan->width ?? "" }}" class="form-control" placeholder="Width"> @error('width') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                      </div>
                                    </div>
                                </div>
                                
                                <!-- drawing list code--> 
                                @php                          
                                    if(!empty($plan)){
                                    $data = explode(',',$plan->drawing_list);
                                    $i = 0;
                                    }   
                                @endphp  
                                @if(!empty($plan))
                                  <div class="forn-group">
                                    <div class="row">
                                      <div class="col-6"> <label for="planWidth" class="mt-4">Drawing List</label></div>
                                      <div class="col-6"><button type="button" name="add" id="add" class="btn btn-success float-right">Add More</button></div>
                                  </div>
                                  <!-- <button type="button" name="add" id="add" class="btn btn-success float-right m-3">Add More</button>  -->
                                    
                                     <table class="table table-bordered" id="dynamic_field">  
                                      @foreach($data as $value) 
                                         @php  
                                           $i++;
                                         @endphp 
                                         <tr id="row{{$i}}" class="dynamic-added">  
                                              <td><input type="text" name="drawing_list[]" placeholder="Add Drawing List" value="{{ $value ?? "" }}" class="form-control name_list" /></td>  
                                              <td><button type="button" name="remove" id="{{$i}}" class="btn btn-danger btn_remove">X</button></td>
                                        </tr>  
                                        
                                     @endforeach 
                                  </table>
                                    </div>
                                @endif
                               
                                

                                <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                      <strong>Description:</strong>
                                      <textarea class="form-control" name="description" id="exampleDescription" rows="3">{{ $plan->description}}</textarea> @error('price') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                      <strong>Driwing List:</strong>
                                       @if ($plan->drawing_list != "")
                                      @foreach(explode(',', $plan->drawing_list) as $info) 
                                        <option>{{$info}}</option>
                                      @endforeach
                                    @endif -->
                                      <!-- <input type="text" name="driwing_list" value="{{ $plan->drawing_list ?? "" }}" class="form-control"> @error('drawing_list') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                    </div>
                                </div> --> 

                                
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                      <label class="form-label d-flex align-center" for="planPDF">Plan PDF <small>(Choose new automatically remove previous)</small></label>
                                      @if($plan->pdf != "")
                                        <div class="form-group videoImgBlock featured_image" style="display:inline-flex;">
                                                <a href="/public{{Storage::url($plan->pdf)}} " download>Download PDF Now</a>    
                                        </div>
                                      @endif
                                      <div class="form-group videoImgBlock">
                                          <input type="file" class="" name="pdf" id="pdf" accept=".pdf">
                                          @error('pdf') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
                                      </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <label class="form-label d-flex" for="customFile">Featured Image</label>
                                      <div class="form-group videoImgBlock featured_image" style="display:inline-flex;">
                                        <p class="edit_featured_image">
                                        <i class="fas fa-edit plan_image_edit editImg" data-id="{{$plan->id}}" style="cursor:pointer"></i></p>
                                            @if($plan->ext == 'pdf' || $plan->ext == 'doc' || $plan->ext == 'docx' || $plan->ext == 'txt') 
                                                <img src="{{URL::to('/public/images/PDF_file_icon.svg.png')}}" height="100" width="100">
                                            @else
                                                <img src="@if($plan->image) /public{{Storage::url($plan->image)}} @else {{URL::to('/public/images/FreeHouseDesigD01aR01a.png')}}@endif" height="100" widht="100">
                                            @endif 
                                      </div>
                                </div>
                                @isset($gallery_images)
                                <label class="form-label d-flex" for="customFile">Gallery Images</label>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    
                                          @foreach ($gallery_images as $item)
                                          <div class="form-group videoImgBlock gallery_img_{{$item->id}}" style="display:inline-flex;">
                                            <p class="edit_g_image">
                                            <i class="fas fa-edit plan_gallery_image_edit editImg" data-id="{{$item->id}}" style="cursor:pointer" title="Edit"></i>
                                            </p>
                                              <img src="@if($item->gallery_images) /public{{Storage::url($item->gallery_images)}} @else {{URL::to('/public/images/FreeHouseDesigD01aR01a.png')}}@endif" height="120" widht="100">
                                              <p class="delete_g_image">
                                                <i class="fas fa-trash plan_gallery_image_delete" data-id="{{$item->id}}" style="cursor:pointer" title="Delete"></i>
                                              </p>
                                          </div>
                                          @endforeach
                                      </div>
                                   @endisset
                                <button type="submit" class="btn btn-primary ml-3">Update</button>
                                <a class="btn btn-primary ml-2" id="add_more_images" data-plan-id="{{$plan->id}}" >Add More</a>
                                </div>
                              </div>
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
    <div class="modal fade" id="edit_plan_image" tabindex="-1" role="dialog" aria-labelledby="uploadAssignmentsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="dropzone">
        <form class="dropzone needsclick" id="demo-upload" method="post" action="{{ route('admin.plans.update_image') }}" enctype="multipart/form-data">
         @csrf
          <div class="modal-content submit-paper plan-edit dz-message needsclick">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel" class="upload-assignmnt">Update Featured Image</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="plan_id" id="plan_id">
                <div class="zone">
                <div id="dropZ">
                    <img src="{{ URL::to('/public/images/cloud-arrow-up-solid.png') }}" height="50" width="80" class="uplaod-img mb-3"/>
                    <div class="drag_drop">Drag and drop your Image here</div>
                    <span class="drag_drop">OR</span>
                    <div>
                      <img id="previewImg" src="" alt="Placeholder" height="150" width="150" style="border-radius: 50%;">
                    </div>
                    <div class="selectFile">
                    <label for="file">Select file</label>
                    <input type="file" class="form-control"  name="edit_image" onchange="previewFile(this);" />
                    </div>
                </div>
               
                </div>
                </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary upload-btn">Update</button>
            </div>
          </div>
        </form>
        </div>
      </div>
<!--Gallery Images Edit POPUP-->
      <div class="modal fade" id="edit_plan_gallery_images" tabindex="-1" role="dialog" aria-labelledby="uploadAssignmentsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="dropzone">
        <form class="dropzone needsclick" id="demo-upload" method="post" action="{{ route('admin.plans.update_gallery_image') }}" enctype="multipart/form-data">
         @csrf
          <div class="modal-content submit-paper plan-edit dz-message needsclick">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel" class="upload-assignmnt">Update Gallery Image</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="plan_info_id" id="plan_info_id">
                <div class="zone">
                <div id="dropZ">
                <img src="{{ URL::to('/public/images/cloud-arrow-up-solid.png') }}" height="50" width="80" class="uplaod-img mb-3"/>
                    <div class="drag_drop">Drag and drop your Image here</div>
                    <span  class="drag_drop">OR</span>
                    <img id="blah"  width="100px" height="100px" style="display: none;border-radius:50%"/>
                    <div class="selectFile"> 
                    <label for="file">Select file</label>
                    <input type="file" class="form-control"  name="edit_gallery_image" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0]);jQuery('#blah').show();jQuery('.drag_drop,.uplaod-img').hide();"/>
                    </div>
                    </div>
                </div>
                </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary upload-btn">Update</button>
            </div>
          </div>
        </form>
        </div>
      </div>


      <!--Add More Gallery Images POPUP-->
      <div class="modal fade" id="add_plan_gallery_images" tabindex="-1" role="dialog" aria-labelledby="uploadAssignmentsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="dropzone">
        <form class="dropzone needsclick" id="demo-upload" method="post" action="{{ route('admin.plans.add_gallery_images') }}" enctype="multipart/form-data">
         @csrf
          <div class="modal-content submit-paper plan-edit dz-message needsclick">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel" class="upload-assignmnt">Add Gallery Images</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="add_plan_id" id="add_plan_id">
                <div class="zone">
                <div id="dropZ">
                <img src="{{ URL::to('/public/images/cloud-arrow-up-solid.png') }}" height="50" width="80" class="uplaod-img mb-3"/>
                    <div>Drag and drop your Image here</div>
                    <span>OR</span>
                    <div class="selectFile">
                    <label for="file">Select file</label>
                    <input type="file" class="form-control"  name="add_gallery_image[]" multiple accept="image/png, image/jpg, image/jpeg" />
                    </div>
                    </div>
                </div>
                </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary upload-btn">Add</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


   @endsection
   @push('js')
   <script>
    let delete_gallery_image = "{{route('admin.plans.delete_gallery_image')}}";
    </script>
    <script src="{{URL::to('/public/admin-panel/js/all.js')}}"></script>
   @endpush
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