<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <!--<h4 class="modal-title" id="myModalLabel">Modify Voucher Details</h4>-->
      </div>
      <div class="modal-body">
          <div class="messages"> </div>
        <form class="form-horizontal" id="createform" role="form" method="POST" action="{{{ action('VoucherController@create') }}}" accept-charset="UTF-8">
                <fieldset>
                    <div id="voucher_info" class="form-group">
                        <div class="col-md-12">
                            
                            <div class="form-group row">
                                <label class="col-md-4 control-label" for="bp_street">Pay To</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="payee" id="payee">
                                       @foreach($partners as $partner)
                                            <option value="{{{$partner['bp_id']}}}">{{$partner['bp_name']}}</option>
                                       @endforeach
                                    </select>
                                    
                                </div>
                                
                               
                            </div>
                            <div class="form-group row">
                                <label for="bp_loc_building" class="col-md-4 control-label">Amount</label>
                                <div class="col-md-6 total_amount">
                                    <input class="form-control" placeholder="Total Amount" type="text" name="total_amount" id="total_amount" value="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="cheque" class="col-md-4 control-label">Cheque No</label>
                                <div class="col-md-6 check_number">
                                    <input class="form-control" placeholder="Cheque No" type="text" name="check_number" id="check_number" value="">
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                
                                <label for="bp_building" class="col-md-4 control-label">Bank</label>
                                <div class="col-md-6 bank">
                                    <input class="form-control" placeholder="Bank" type="text" name="bank" id="bank" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="form-group">
                        <span class="col-md-1 control-label"><label>Particulars</label></span>
                        <div id="items" class="col-md-12">
                            <div class="col-md-8 col-md-offset-2">
                                <input class="btn btn-primary btn-block" onclick="addRow(this.form);" 
                                type="button" value="Add Item Line" />
                            </div>
                            
                            @if ( Session::has('particulars'))
                                @foreach( Session::get('particulars') as $items)
                                    <div id="rowNum{{{ $items['line_number'] }}}">
                                        <div class="col-md-7 particulars">
                                            <span class="col-md-1 control-label">Description</span>
                                            <input type="text" class="form-control" id="particular[]" name="particular[]" placeholder="Item Description" value="{{{ $items['particular'] }}}">
                                        </div>
                                        <div class="col-md-3"><span class="col-md-1 control-label">Amount</span>
                                            <input type="text" class="form-control" id="amount[]" name="amount[]" placeholder="Amount" value="{{{ $items['amount'] }}}">
                                        </div>
                                        <div class="col-md-2"> <span class="col-md-1 control-label">Action</span><input class="btn btn-primary btn-block" type="button" value="-" onclick="removeRow('{{{ $items['line_number'] }}}');">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </fieldset>
<!--                <div class="form-actions modal-footer">
                        <button type="button" class="btn btn-default" id="dumer" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                </div>-->
            </form>
      </div>
      <div class="modal-footer">
          
            <div class="progress progress-striped f_bar">

                <div class="progress-bar bar f_bar" style="width: 0%;">
                     
                    <span id="prog_txt">Please Wait</span>

                </div>

            </div>

          <button type="button" class="btn btn-default" id="dumer" data-dismiss="modal">Close</button>
          <button type="button" id="submitBtn" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    
    <script>
        $( document ).ready(function() {
            $('.modal-header').append('<h4 class="modal-title" id="myModalLabel2">New Record</h4>')
        });
        
         $("#submitBtn").click(function(e){
        $(".f_bar").addClass( "active" )
        $(".bar").css("width", "0%");
       
        $("#createform :input").prop("readonly", true);
        $("#submitBtn").prop("disabled", true);
    console.log( $("#updateform").serialize() );
    var request = $.ajax({
      url: "add",
      type: "POST",
      data: $("#createform").serialize(),
      dataType: "json"
    });
    $(".bar").css("width", "50%");
    request.done(function( data ) {
      console.log("Complete");
      console.log(data.msg);
      if(changes_flag == 0) changes_flag = data.flag;
      console.log(changes_flag);
      console.log(data.error);
       $("#createform :input").prop("readonly", false);
        $("#submitBtn").prop("disabled", false);
         $(".bar").css("width", "100%");
         $(".f_bar").removeClass( "active" );
         $("#prog_txt").hide();
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
         else if(data.status == 'success'){
             $( ".message_content" ).remove();//remove first if exists
             $(".messages").append('<div class="message_content alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">\n\
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\n\
                <strong>Completed!</strong> '+ data.msg +'. </div>');
              $("#createform").trigger("reset");
         }
         else{
             //catch errors here....
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
    



