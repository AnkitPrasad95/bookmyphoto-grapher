
"use strict";
function getduration(x) {
   
	if(x.value == 'Fixed'){
		
		document.getElementById("duration").style.display = '';
	}
	else{
		document.getElementById("duration").style.display = 'none';
	}
}
$('#banner_type').change(function(){
   if($('#banner_type').val() == '1') {
      $('#category').show();$('#service').hide();
   }else if($('#banner_type').val() == '2') {
      $('#service').show();$('#category').hide();
   } else {
      $('#category').hide();$('#service').hide();
   } 
});

function deletebanner(id,title,yes,no,deleteurl,wrong,recordsafe) {
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
