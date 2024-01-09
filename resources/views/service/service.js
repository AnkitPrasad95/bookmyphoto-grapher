
"use strict";
function getduration(x) {
	if(x.value == 'Fixed'){      
      document.getElementById("duration").classList.remove("dn");
      document.getElementById("duration_type").classList.remove("dn");

		document.getElementById("duration").style.display = '';
      document.getElementById("duration_type").style.display = '';
	}
	else{
		document.getElementById("duration").style.display = 'none';
      document.getElementById("duration_type").style.display = 'none';
	}
}
$('#service_price').keyup(function(){
   var val = $(this).val();
   if(isNaN(val)){
      val = val.replace(/[^0-9\.]/g,'');
      if(val.split('.').length>2) 
         val =val.replace(/\.+$/,"");
      }
   $(this).val(val); 
});
$('#service_discount').keyup(function(){
   var val = $(this).val();
   if(isNaN(val)){
      val = val.replace(/[^0-9\.]/g,'');
      if(val.split('.').length>2) 
         val =val.replace(/\.+$/,"");
      }
   $(this).val(val); 
});
$('#service_duration').keyup(function(){
   var val = $(this).val();
   if(isNaN(val)){
      val = val.replace(/[^0-9\.]/g,'');
      if(val.split('.').length>2) 
         val =val.replace(/\.+$/,"");
      }
   $(this).val(val); 
});

$(document).ready(function() {
   
   $('#edit_gallery_form').on('submit', function(event){
      event.preventDefault();
      var form_data = new FormData(this);
      var edit_url = $("#gallery_edit_url").attr('url');
      $.ajax({
         url:edit_url,
         method:'POST',
         data:form_data,
         cache: false,
         contentType: false,
         processData: false,
         dataType: "json",
         success:function(data){
            window.location.reload();
         },
         error:function (response) {
            $('#gallery_error').text(response.responseJSON.errors.gimage_id);
            $('#gallery_image_error').text(response.responseJSON.errors.image);
         }
      });
   });
   
});

// Update Service is_featured
function updateserviceisfeatured(id,is_featured,title,yes,no,featuredurl,wrong,recordsafe) {
   swal({
      title: title,
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: yes,
      cancelButtonText: no,
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true,
   },
   function(isConfirm) {
      if (isConfirm) {
         $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:featuredurl,
            data: {id: id,is_featured: is_featured},
            method: 'POST',
            success: function(response) {
               if (response == 1) {
                  swal.close();
                  window.location.reload();
               } else {
                  swal("Cancelled", wrong, "error");
               }
            },
            error: function(e) {
               swal("Cancelled", wrong, "error");
            }
         });
      } else {
         swal("Cancelled", recordsafe, "error");
      }
   });
}
// Update Service Status
function updateservicestatus(id,status,title,yes,no,statusurl,wrong,recordsafe) {
   swal({
      title: title,
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: yes,
      cancelButtonText: no,
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true,
   },
   function(isConfirm) {
      if (isConfirm) {
         $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:statusurl,
            data: {id: id,status: status},
            method: 'POST',
            success: function(response) {
               if (response == 1) {
                  swal.close();
                  window.location.reload();
               } else {
                  swal("Cancelled", wrong, "error");
               }
            },
            error: function(e) {
               swal("Cancelled", wrong, "error");
            }
         });
      } else {
         swal("Cancelled", recordsafe, "error");
      }
   });
}
// Delete Service
function deleteservice(id,title,yes,no,deleteurl,wrong,recordsafe) {
   swal({
      title: title,
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: yes,
      cancelButtonText: no,
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true,
   },
   function(isConfirm) {
      if (isConfirm) {
         $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:deleteurl,
            data: {id: id},
            method: 'POST',
            success: function(response) {
               if (response == 1) {
                  swal.close();
                  window.location.reload();
               } else {
                  swal("Cancelled", wrong, "error");
               }
            },
            error: function(e) {
               swal("Cancelled", wrong, "error");
            }
         });
      } else {
         swal("Cancelled", recordsafe, "error");
      }
   });
}
// delete gallery image
function deletegallery(id,title,yes,no,deletegalleryurl,wrong,recordsafe) {
   swal({
      title: title,
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: yes,
      cancelButtonText: no,
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true,
   },
   function(isConfirm) {
      if (isConfirm) {
         $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:deletegalleryurl,
            data: {id: id},
            method: 'POST',
            success: function(response) {
               if (response == 1) {
                  swal.close();
                  window.location.reload();
               } else {
                  swal("Cancelled", wrong, "error");
               }
            },
            error: function(e) {
               swal("Cancelled", wrong, "error");
            }
         });
      } else {
         swal("Cancelled", recordsafe, "error");
      }
   });
}
///// Add gallery Image
$(document).on('click','.add_gallery_image',function(){
   var service_id = $(this).attr('data-id');
   $('#gallery_service_id').val(service_id); 
});
$('#add_gallery').on('submit', function(event){
   event.preventDefault();
   var add_gallery_url = $("#add_gallery_url").attr('url');
   var form_data = new FormData(this);
   $.ajax({
      url:add_gallery_url,
      method:'POST',
      data:form_data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      beforeSend: function () {
    	$('.page-loading').show();
      },
      success:function(data){
         $('.page-loading').hide();
         window.location.reload();
      },
      error:function (response) {
         $('#other_error').text(response.responseJSON.errors.service_id);
         $('#add_gallery_image_error').text(response.responseJSON.errors.image);
      }
   });
});