@extends('layouts.adminmaster') 
{{-- main.prepend --}}
@section('main.prepend')
{{-- maybe, need dump form errors --}}
<div class="row">
@stop
 

{{-- content --}}
@section('content')

<div class="col-md-12">
    <a href="{{ route('createBP')}}" data-toggle="modal" data-target="#create_modal" class="btn btn-success btn-md pull-left navbar-btn"><span class="fa fa-file fa-md"></span> Add Business Partner</a>
    <!--/<a data-toggle="modal" class="btn btn-success btn-md pull-left" href="{{ route('createVoucher')}}" data-target="#create_modal"><span class="fa fa-file fa-md"></span>Click me !</a>-->
</div>
<div class="col-md-12"> 
    <table id="records" class="table table-striped" cellspacing="0" width="100%">
       
        <thead>
            <tr>
                <th>Business Partner</th>
                <th>Building</th>
                <th>City</th>
                <th></th>
                
            </tr>
        </thead>
        	<tbody>
                <tr>	
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
    </table>
</div>

               
@stop

@section('modal_edit')
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
    </div>

    <div class="modal fade" id="create_modal" tabindex="-2" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">

    </div>

@stop

@section('scripts')
    

    <!-- Page-Level Plugin Scripts - Dashboard -->
    <script src="{{ URL::asset('js/plugins/morris/raphael-2.1.0.min.js')}}"></script>
    <script src="{{ URL::asset('js/plugins/morris/morris.js')}}"></script>
    <!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript"></script>-->
   <!-- Page-Level Demo Scripts - Dashboard - Use for reference
    <script src="{{ URL::asset('js/demo/dashboard-demo.js')}}"></script>-->
   <script>
      var changes_flag = 0;
        $(document).ready(function() {
              $('#records').dataTable( {
                "oLanguage": {
                        "sSearch": "Filter  ",
                        "sLengthMenu": "Records _MENU_"
                },
                "oPaginationType": "bootstrap",
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "ajax",
                "aoColumns": [
                    null,
                    null,
                    null,
                    { "bSortable": false },
                    ],
                
                });
//                $('<button id="refresh" class="btn btn-success btn-sm pull-left"> Refresh </button>').appendTo('div.dataTables_filter');
//                $('<a href="#" class="btn btn-success btn-sm  navbar-btn"><i class="fa fa-file"></i> Add </a>').appendTo('div.dataTables_length');
                 
        });
        
//        $(document).ready(function() {
//
//  // Match to Bootstraps data-toggle for the modal
//  // and attach an onclick event handler
//  $('a[data-toggle="modal"]').on('click', function(e) {
//
//    // From the clicked element, get the data-target arrtibute
//    // which BS3 uses to determine the target modal
//    var target_modal = $(e.currentTarget).data('target');
//    // also get the remote content's URL
//    var remote_content = e.currentTarget.href;
//
//    // Find the target modal in the DOM
//    var modal = $(target_modal);
//    // Find the modal's <div class="modal-body"> so we can populate it
//    var modalBody = $(target_modal + ' .modal-body');
//
//    // Capture BS3's show.bs.modal which is fires
//    // immediately when, you guessed it, the show instance method
//    // for the modal is called
//    modal.on('show.bs.modal', function () {
//            // use your remote content URL to load the modal body
//            modalBody.load(remote_content);
//        }).modal();
//        // and show the modal
//
//    // Now return a false (negating the link action) to prevent Bootstrap's JS 3.1.1
//    // from throwing a 'preventDefault' error due to us overriding the anchor usage.
//    return false;
//  });
//});

$('#edit_modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
  if(changes_flag > 0){
       var $lmTable = $("#records").dataTable( { bRetrieve : true } );
       $lmTable.fnDraw();
       changes_flag = 0;
  }
  clearall();
});

$('#create_modal').on('hidden.bs.modal', function () {
   $(this).removeData(('bs.modal'));
   if(changes_flag > 0){
       var $lmTable = $("#records").dataTable( { bRetrieve : true } );
       $lmTable.fnDraw();
       changes_flag = 0;
  }
  clearall();
});


//var request;
//// bind to the submit event of our form
//$("#updateform").submit(function(event){
//    // abort any pending request
//    if (request) {
//        request.abort();
//    }
//    // setup some local variables
//    var $form = $(this);
//    // let's select and cache all the fields
//    var $inputs = $form.find("input, select, button, textarea");
//    // serialize the data in the form
//    var serializedData = $form.serialize();
//
//    // let's disable the inputs for the duration of the ajax request
//    // Note: we disable elements AFTER the form data has been serialized.
//    // Disabled form elements will not be serialized.
//    $inputs.prop("disabled", true);
//
//    // fire off the request to /form.php
//    request = $.ajax({
//        url: "updateVoucher",
//        type: "post",
//        data: serializedData
//    });
//
//    // callback handler that will be called on success
//    request.done(function (response, textStatus, jqXHR){
//        // log a message to the console
//        //console.log("Hooray, it worked!");
//        alert(response.message);
//    });
//
//    // callback handler that will be called on failure
//    request.fail(function (jqXHR, textStatus, errorThrown){
//        // log the error to the console
//        console.error(
//            "The following error occured: "+
//            textStatus, errorThrown
//        );
//    });
//
//    // callback handler that will be called regardless
//    // if the request failed or succeeded
//    request.always(function () {
//        // reenable the inputs
//        $inputs.prop("disabled", false);
//    });
//
//    // prevent default posting of form
//    event.preventDefault();
//});

//    $(document).ready(function() {
//        $('#updateform').submit(function() {
//            $.ajax({
//                type: 'post',
//                cache: false,
//                dataType: 'json',
//                data: $('#inputform').serialize(),
////                beforeSend: function() {
////                    $("#validation-errors").hide().empty();
////                },
//                success: function(data) {
//                    if(data.success == false)
//                    {
//                        var arr = data.errors;
//                        $.each(arr, function(index, value)
//                        {
//                            if (value.length != 0)
//                            {
//                                $("#validation-errors").append('<div class="alert alert-error"><strong>'+ value +'</strong><div>');
//                            }
//                        });
//                        $("#validation-errors").show();
//                    } else {
////                         location.reload();
//                            console.log(data.msg);
//                    }
//                },
//                error: function(xhr, textStatus, thrownError) {
//                    alert('Something went to wrong.Please Try again later...');
//                }
//            });
//            return false;
//    });
//}); 

//       $("#submitBtn").click(function(e){
//    console.log( $("#updateform").serialize() );
//    var request = $.ajax({
//      url: "updateVoucher",
//      type: "POST",
//      data: { test : "someuser" },
//      dataType: "json"
//    });
//
//    request.done(function( data ) {
//      console.log("Complete");
//      console.log(data.msg);
//    });
//
//    request.fail(function( jqXHR, textStatus ) {
//      console.log("Failed");
//      console.log(textStatus);
//    });
//});
   


    </script>
    
    
@stop

