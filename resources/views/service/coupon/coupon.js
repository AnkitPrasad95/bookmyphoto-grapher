
"use strict";
$('#coupon_discount').keyup(function(){
   var val = $(this).val();
   if(isNaN(val)){
      val = val.replace(/[^0-9\.]/g,'');
      if(val.split('.').length>2) 
         val =val.replace(/\.+$/,"");
   }
   $(this).val(val); 
});

$(document).on('keyup', '#search_coupon', function(){
   var query = $(this).val();
   var page = $('#hidden_page').val();
   fetch_coupon(page,query);
});
$(document).on('click', '.pagination a', function(event){
   event.preventDefault();
   var page = $(this).attr('href').split('page=')[1];
   $('#hidden_page').val(page);
   var query = $('#search_coupon').val();
   $('li').removeClass('active');
   $(this).parent().addClass('active');
   fetch_coupon(page, query);
});
function fetch_coupon(page,query)
{
   var myurl = $("#coupon_url").attr('url');
   $.ajax({
      url:myurl,
      method:'GET',
      data:{page:page,query:query},
      success:function(couponsdata)
      {
         $('.coupon_table').html(couponsdata);
      }
   })
}

function updatecouponstatus(id,status,title,yes,no,statusurl,wrong,recordsafe) {
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
            data: {
               id: id,
               status: status
            },
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

function deletecoupon(id,title,yes,no,deleteurl,wrong,recordsafe) {
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