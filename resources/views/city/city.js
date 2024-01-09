
"use strict";
   
$(document).on('keyup', '#search_city_name', function(){
   var query = $(this).val();
   var page = $('#hidden_page').val();
   fetch_cities(page,query);
});
$(document).on('click', '.pagination a', function(event){
   event.preventDefault();
   var page = $(this).attr('href').split('page=')[1];
   $('#hidden_page').val(page);
   var query = $('#search_city_name').val();
   $('li').removeClass('active');
   $(this).parent().addClass('active');
   fetch_cities(page, query);
});
function fetch_cities(page,query)
{
   var myurl = $("#city_url").attr('url');
   $.ajax({
      url:myurl,
      method:'GET',
      data:{page:page,query:query},
      success:function(citydata)
      {
         $('.city_table').html(citydata);
      }
   })
}

function updatecitystatus(id,status,title,yes,no,statusurl,wrong,recordsafe) {
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

function deletecity(id,title,yes,no,deleteurl,wrong,recordsafe) {
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
                  swal("Cancelled", wrong , "error");
               }
            },
            error: function(e) {
               swal("Cancelled", wrong , "error");
            }
         });
      } else {
         swal("Cancelled", recordsafe , "error");
      }
   });
   
}