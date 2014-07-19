<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Modify Voucher Details</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="updateform" role="form" method="POST" action="{{{ action('VoucherController@updates') }}}" accept-charset="UTF-8">
                <fieldset>
                    <div id="voucher_info" class="form-group">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-4 control-label" for="bp_street">Document Number</label>
                                <div class="col-md-6">
                                    <input class="form-control" placeholder="Total Amount" type="text" name="voucher_number" id="voucher_number" value="{{{$info['voucher_number'] }}}" readonly="readonly">
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 control-label" for="bp_street">Pay To</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="payee" id="payee">
                                        <!--<option value="">Select payee</option>-->
                                         @foreach($partners as $partner)
                                            @if ($info['payto_id'] == $partner['bp_id'])
                                                <option selected="selected" value="{{{$partner['bp_id']}}}">{{$partner['bp_name']}}</option>
                                            @else
                                                <option value="{{{$partner['bp_id']}}}">{{$partner['bp_name']}}</option>
                                            @endif   
                                        @endforeach
                                    </select>
                                    
                                </div>
                                
                               
                            </div>
                            <div class="form-group row">
                                <label for="bp_loc_building" class="col-md-4 control-label">Amount</label>
                                <div class="col-md-6">
                                    <input class="form-control" placeholder="Total Amount" type="text" name="total_amount" id="total_amount" value="{{{$info['total_amount'] }}}">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="cheque" class="col-md-4 control-label">Cheque No</label>
                                <div class="col-md-6">
                                    <input class="form-control" placeholder="Cheque No" type="text" name="check_number" id="check_number" value="{{{$info['check_number'] }}}">
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                
                                <label for="bp_building" class="col-md-4 control-label">Bank</label>
                                <div class="col-md-6">
                                   <input class="form-control" placeholder="Bank" type="text" name="bank" id="bank" value="{{{$info['bank'] }}}">
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
                            
                            @if ( !empty($particulars))
                                @foreach( $particulars as $items)
                                    <div id="rowNum{{{ $items['line_number'] }}}">
                                        <div class="col-md-7 particulars">
                                            <span class="col-md-1 control-label">Description</span>
                                            <input type="text" class="form-control" id="particular[]" name="particular[]" placeholder="Item Description" value="{{{ $items['item_desc'] }}}">
                                        </div>
                                        <div class="col-md-3"><span class="col-md-1 control-label">Amount</span>
                                            <input type="text" class="form-control" id="amount[]" name="amount[]" placeholder="Amount" value="{{{ $items['item_amount'] }}}">
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
    
    $("#submitBtn").click(function(e){
        $(".f_bar").addClass( "active" )
        $(".bar").css("width", "0%");
        $("#updateform :input").prop("readonly", true);
        $("#submitBtn").prop("disabled", true);
    console.log( $("#updateform").serialize() );
    var request = $.ajax({
      url: "updates",
      type: "POST",
      data: $("#updateform").serialize(),
      dataType: "json"
    });
    $(".bar").css("width", "50%");
    request.done(function( data ) {
      console.log("Complete");
      console.log(data.msg);
      changes_flag = data.flag;
      console.log(changes_flag);
      console.log(data.error);
       $("#updateform :input").prop("readonly", false);
        $("#submitBtn").prop("disabled", false);
         $(".bar").css("width", "100%");
         $(".f_bar").removeClass( "active" );
         $("#prog_txt").hide();
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

