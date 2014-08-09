<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
          <div class="messages"> </div>
        <form class="form-horizontal" id="updateform" role="form" method="POST" action="{{{ action('BusinessPartnerController@update') }}}" accept-charset="UTF-8">
                <fieldset>
                    <div id="voucher_info" class="form-group">
                       <div class="form-group row">
                            <!--<label for="bp_name" class="col-md-4 control-label">Business Name</label>-->
                            <div class="col-md-6 total_amount">
                                <input class="form-control" type="hidden" placeholder="Business Name" type="text" name="bp_name" id="bp_name" value="{{{$info['bp_name'] }}}">
                            </div>
                        </div>
                        
                        <div class="form-group row col-md-12">
                            <span class="col-md-6 col-md-offset-4"><label>Contact Person</label></span>
                        </div>
                        <div class="form-group row">
                            <label for="bp_contact_fname" class="col-md-4 control-label">First Name</label>
                            <div class="col-md-6 total_amount">
                                <input class="form-control" placeholder="First Name" type="text" name="bp_contact_fname" id="bp_contact_fname" value="{{{$info['bp_contact_fname'] }}}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="bp_contact_fname" class="col-md-4 control-label">Last Name</label>
                            <div class="col-md-6 total_amount">
                                <input class="form-control" placeholder="Last Name" type="text" name="bp_contact_lname" id="bp_contact_lname" value="{{{$info['bp_contact_lname'] }}}">
                            </div>
                        </div>
                        
                        <div class="form-group row col-md-12">
                            <span class="col-md-6 col-md-offset-4"><label>Business Address</label></span>
                        </div>
                        <div class="form-group row">
                            <label for="bp_loc_building" class="col-md-4 control-label">Building</label>
                            <div class="col-md-6 total_amount">
                                <input class="form-control" placeholder="Building" type="text" name="bp_loc_building" id="bp_loc_building" value="{{{$info['bp_loc_building'] }}}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="bp_loc_street" class="col-md-4 control-label">Street</label>
                            <div class="col-md-6 total_amount">
                                <input class="form-control" placeholder="Street" type="text" name="bp_loc_street" id="bp_loc_street" value="{{{$info['bp_loc_street'] }}}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="bp_loc_city" class="col-md-4 control-label">City</label>
                            <div class="col-md-6 total_amount">
                                <input class="form-control" placeholder="City" type="text" name="bp_loc_city" id="bp_loc_city" value="{{{$info['bp_loc_city'] }}}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="bp_loc_country" class="col-md-4 control-label">Country</label>
                            <div class="col-md-6 total_amount">
                                <input class="form-control" placeholder="Country" type="text" name="bp_loc_country" id="bp_loc_country" value="{{{$info['bp_loc_country'] }}}">
                            </div>
                        </div>
                        
                    </div>

                </fieldset>
                </fieldset>
            </form>
      </div>
      <div class="modal-footer">
          
            <div class="progress progress-striped f_bar">

                <div class="progress-bar bar f_bar" style="width: 0%;">
                     
                    <span class="prog_txt">Please Wait</span>

                </div>

            </div>

          <button type="button" class="btn btn-default" id="dumer" data-dismiss="modal">Close</button>
          <button type="button" id="submitBtn" class="btn btn-primary submitBtn">Save changes</button>
      </div>
    </div>
    

<script>
    $( document ).ready(function() {
        var doc = $('#bp_name').val();
        $('.modal-header').append('<h4 class="modal-title" id="myModalLabel">Modify Partner Info - '+ doc +'</h4>')
    });
    $(".submitBtn").click(function(e){
        $(".f_bar").addClass( "active" )
        $(".bar").css("width", "0%");
       
        $("#updateform :input").prop("readonly", true);
        $("#submitBtn").prop("disabled", true);
    console.log( $("#updateform").serialize() );
    var request = $.ajax({
      url: "update",
      type: "POST",
      data: $("#updateform").serialize(),
      dataType: "json"
    });
    $(".bar").css("width", "50%");
    request.done(function( data ) {
      console.log("Complete");
      console.log(data.msg);
      if(changes_flag == 0) changes_flag = data.flag;
      console.log(changes_flag);
      console.log(data.error);
       $("#updateform :input").prop("readonly", false);
        $("#submitBtn").prop("disabled", false);
         $(".bar").css("width", "100%");
         $(".f_bar").removeClass( "active" );
         $(".prog_txt").hide();
         $("div").removeClass("has-error");
         if(data.status == 'success1'){
             $( ".message_content" ).remove();//remove first if exists
             var prompt = "<br />";
             $.each($.parseJSON(data.error), function(key,value) {
                    prompt += value + "<br />";
                    $('.' + key).addClass("has-error");
             });
             $(".messages").append('<div class="message_content alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">\n\
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\n\
                <strong>Errors Occured!</strong> '+prompt+' </div>');
            
             
           
         }
         else{
             $( ".message_content" ).remove();//remove first if exists
             $(".messages").append('<div class="message_content alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">\n\
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\n\
                <strong>Completed!</strong> '+ data.msg +'. </div>');
         }
        
         //$(".bar").css("width", "0%");
         //$(".f_bar").hide();
      // $('#progress').modal('hide');
    });
    

    request.fail(function( jqXHR, textStatus ) {
      $(".bar").css("width", "50%");
      console.log("Failed");
      console.log(textStatus);
    });
    
    
});

</script>

