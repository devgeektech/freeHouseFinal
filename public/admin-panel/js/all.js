/**
 * Update Goal Image
 */
 jQuery(".plan_image_edit").on('click',function() {
    jQuery("#plan_id").val($(this).attr('data-id'));
    jQuery('#edit_plan_image').modal('show');
});


/**
 * Download Plan
 */
jQuery("#download_plan").on("click",function(){
    var plan_id = jQuery(this).data('id');
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $.ajax({
        url: download_plan,
        data:{ plan_id:plan_id},
        type: "POST",
        beforeSend: function(){
            jQuery(".overlay").show();
        },
        success: function (res) {
            setTimeout(() => {
                jQuery(".alert-success").show();
                jQuery(".overlay").hide();
                jQuery(".alert-success").find('strong').text(res.message);
            }, 2500);
          
        }
    });
});


/**
 * Update Plan Gallery Images
 */

jQuery('.plan_gallery_image_edit').on('click', function(){
    jQuery("#plan_info_id").val($(this).attr('data-id'));
    jQuery('#edit_plan_gallery_images').modal('show');
});


jQuery('.gallery_images').on('click', function() {
    jQuery('.imagepreview').attr('src', jQuery(this).find('img').attr('src'));
    jQuery('#imagemodal').modal('show');   
});		


function switchStyle() {
    if (document.getElementById('styleSwitch').checked) {
      document.getElementById('gallery').classList.add("custom");
      document.getElementById('exampleModal').classList.add("custom");
    } else {
      document.getElementById('gallery').classList.remove("custom");
      document.getElementById('exampleModal').classList.remove("custom");
    }
}

jQuery("#previewImg").hide();
function previewFile(input){
  jQuery('.drag_drop,.uplaod-img').hide();
  var file = jQuery("input[type=file]").get(0).files[0];
  if(file){
      var reader = new FileReader();
      reader.onload = function(){
        jQuery("#previewImg").show();
        jQuery("#previewImg").attr("src", reader.result);
      }
      reader.readAsDataURL(file);
  }
}

/**
 * Delete Gallery Images
 */
jQuery(".edit_success").hide();
jQuery(".plan_gallery_image_delete").on('click', function() {
    var id = jQuery(this).data('id');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
        url: delete_gallery_image,
        data:{ id:id},
        type: "POST",
        beforeSend: function(){
            jQuery(".overlay").show();
        },
        success: function (res) {
            setTimeout(() => {
                jQuery(".gallery_img_"+id).remove();
                jQuery(".edit_success").show();
                jQuery(".overlay").hide();
                jQuery(".edit_success").find('strong').text(res.message);
            }, 1000);
          
        }
    });
});

jQuery("#add_more_images").on('click', function() {
  jQuery("#add_plan_id").val(jQuery(this).data('plan-id'));
  jQuery("#add_plan_gallery_images").modal('show');
});
