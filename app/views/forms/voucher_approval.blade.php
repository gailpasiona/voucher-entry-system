<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <!--<h4 class="modal-title" id="myModalLabel">Modify Voucher Details</h4>-->
      </div>
      <div class="modal-body">
          <div class="messages"> </div>
        <form class="form-horizontal" id="createform" role="form" method="POST" accept-charset="UTF-8">
                <fieldset>
                    <div id="voucher_info" class="form-group">
                        <div class="col-md-12">
                            
                            <div class="form-group row">
                                <!--<label for="voucher_number" class="col-md-4 control-label">Voucher Number </label>-->
                                <div class="col-md-6 voucher_number">
                                    <input class="form-control" placeholder="voucher_number" type="hidden" name="voucher_number" id="voucher_number" value="{{{$info["voucher_number"]}}}">
                                </div>
                                
                            </div>
                            <div class="msg">
                                
                            </div>
                            
<!--                            <div class="form-group row">
                                <label for="voucher_date" class="col-md-4 control-label">Voucher Date</label>
                                <div class="col-md-6 voucher_date">
                                    <input class="form-control" placeholder="MM/DD/YY" type="readonly" name="voucher_date" id="voucher_date" value="{{{$info["voucher_date"]}}}">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="bp_loc_building" class="col-md-4 control-label">Amount</label>
                                <div class="col-md-6 total_amount">
                                    <input class="form-control" placeholder="Total Amount" type="readonly" name="total_amount" id="total_amount" value="{{{$status["approval"]}}}">
                                </div>
                            </div>-->
                            
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
                     
                    <span class="prog_txt">Please Wait</span>

                </div>

            </div>
          <div class="controlbtn">
              @if ($status["approval"] > 0)
                    <button type="button" id="reopenBtn" class="btn btn-success processBtn" onclick="process(this);">Re-activate</button>
              @else
                    <button type="button" id="approveBtn" class="btn btn-primary processBtn" onclick="process(this);">Approve</button>
              @endif
          
          
          <button type="button" class="btn btn-default" id="dumer" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
</div>
    <script>
        $( document ).ready(function() {
                var doc = $('#voucher_number').val();
                $('.modal-header').append('<h4 class="modal-title" id="myModalLabel3">Voucher Approval</h4>');
                $('.msg').append('<h2 class="text-center">Processing Voucher No. '+ $('#voucher_number').val() +'</h2>')
        });
        
        function swElem(elem){
            
            if($(elem).attr('id') == 'approveBtn')
                $('.controlbtn').append('<button type="button" id="reopenBtn" class="btn btn-success processBtn" onclick="process(this);">Re-activate</button>');
            
            else
                $('.controlbtn').append('<button type="button" id="approveBtn" class="btn btn-primary processBtn" onclick="process(this);">Approve</button>');
            
            $(elem).remove();
        }
        
        function process(elem){
            //$("#approveBtn").prop('disabled', true);
            $(".f_bar").addClass( "active" );
            console.log($(elem).attr('id'));
            $(elem).prop("disabled", true);
            var request = null;
            var url = null;
            if($(elem).attr('id') == 'approveBtn')
                url = "approve";
            
            else
                url = "reactivate";
            
            
            
            request = $.ajax({
                  url: url,
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
                  
                     $(".bar").css("width", "100%");
                     $(".f_bar").removeClass( "active" );
                     $(".prog_txt").hide();
                     $("div").removeClass("has-error");
                     if(data.status == 'success1'){
                         $( ".message_content" ).remove();//remove first if exists
//                         var prompt = "<br />";
//                         $.each($.parseJSON(data.error), function(key,value) {
//                                prompt += value + "<br />";
//                                $('.' + key).addClass("has-error");
//                         });
                         $(".messages").append('<div class="message_content alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">\n\
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\n\
                            <strong>Ooops!</strong> '+data.msg+' </div>');



                     }
                     else if(data.status == 'success'){
                         $( ".message_content" ).remove();//remove first if exists
                         $(".messages").append('<div class="message_content alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">\n\
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\n\
                            <strong>Completed!</strong> '+ data.msg +'. </div>');
                          $("#createform").trigger("reset");
                          swElem(elem);
                     }
                     else{
                         //catch errors here....
                     }

                     
                });
                
                request.fail(function( jqXHR, textStatus ) {
                  $(".bar").css("width", "50%");
                  console.log("Failed");
                  console.log(textStatus);
                });
        }

    </script>
    



