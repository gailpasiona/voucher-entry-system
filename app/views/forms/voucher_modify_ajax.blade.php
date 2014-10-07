<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#details" role="tab" data-toggle="tab">Details</a></li>
            <li><a href="#attachments" role="tab" data-toggle="tab">Attachments</a></li>
            <li><a href="#receipts" role="tab" data-toggle="tab">Item Receipts</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="details">
                    <div class="messages"> </div>
                    <form class="form-horizontal" id="updateform" role="form" method="POST" action="{{{ action('VoucherController@updates') }}}" accept-charset="UTF-8">
                            <fieldset>
                                <div id="voucher_info" class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <!--<label class="col-md-4 control-label" for="bp_street">Document Number</label>-->
                                            <div class="col-md-6">
                                                <input class="form-control" type="hidden" name="voucher_number" id="voucher_number" value="{{{$info['voucher_number'] }}}" readonly="readonly">
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label for="voucher_date" class="col-md-4 control-label">Voucher Date</label>
                                            <div class="col-md-6 voucher_date">
                                                <input class="form-control datepicker" placeholder="MM/DD/YY" type="text" name="voucher_date" id="voucher_date" value="{{{$info['voucher_date'] }}}">
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
                                            <div class="col-md-6 total_amount">
                                                <input class="form-control" placeholder="Total Amount" type="text" name="total_amount" id="total_amount" value="{{{$info['total_amount'] }}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="cheque" class="col-md-4 control-label">Cheque No</label>
                                            <div class="col-md-6 check_number">
                                                <input class="form-control" placeholder="Cheque No" type="text" name="check_number" id="check_number" value="{{{$info['check_number'] }}}">
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label for="cheque" class="col-md-4 control-label">Date of Cheque</label>
                                            <div class="col-md-6 check_date">
                                                <input class="form-control datepicker" placeholder="MM/DD/YYYY" type="text" name="check_date" id="check_date" value="{{{$info['check_date'] }}}">
                                            </div>

                                        </div>
                                        <div class="form-group row">

                                            <label for="bp_building" class="col-md-4 control-label">Bank</label>
                                            <div class="col-md-6 bank">
                                               <input class="form-control" placeholder="Bank" type="text" name="bank" id="bank" value="{{{$info['bank'] }}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <span class="col-md-1 control-label"><label>Particulars</label></span>
                                    <div id="items" class="col-md-12 items">
                                        <div class="col-md-8 col-md-offset-2">
                                            <input class="btn btn-primary btn-block" onclick="addRow(this.form);" 
                                            type="button" value="Add Item Line" />
                                        </div>

                                        @if ( !empty($particulars))
                                            @foreach( $particulars as $items)
                                                <div id="rowNum{{{ $items['line_number'] }}}">
<!--                                                    <div class="col-md-3 ref_no">
                                                        <span class="col-md-1 control-label">Ref</span>
                                                        <input type="text" class="form-control" id="ref_no[]" name="ref_no[]" placeholder="Ref" value="{{{ $items['ref_no'] }}}">
                                                    </div>-->
                                                    <div class="col-md-7 particulars">
                                                        <span class="col-md-1 control-label">Description</span>
                                                        <input type="text" class="form-control" id="particular[]" name="particular[]" placeholder="Item Description" value="{{{ $items['item_desc'] }}}">
                                                    </div>
                                                    <div class="col-md-4 amounts"><span class="col-md-1 control-label">Amount</span>
                                                        <input type="text" class="form-control" id="amount[]" name="amount[]" placeholder="Amount" value="{{{ $items['item_amount'] }}}">
                                                    </div>
                                                    <!---->                                        <div class="col-md-1"> <span class="col-md-1 control-label"><br /></span><input class="btn btn-primary btn-block" type="button" value="x" onclick="removeRow('{{{ $items['line_number'] }}}');">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </fieldset>
                    </form>
                    <div class="button_div">
                        <div class="pull-right">
                            <button type="button" class="btn btn-default" id="dumer" data-dismiss="modal">Close</button>
                            @if ($status < 1)
                                <button type="button" id="submitBtn" class="btn btn-primary submitBtn">Save Changes</button>
                            @endif
                        </div>
                    </div>
                    
            </div>
            <div class="tab-pane" id="attachments">
                <div class="file_messages"> </div>
                <form class="form-horizontal" id="attachform" role="form" method="POST" action="{{{ action('VoucherController@updates') }}}" accept-charset="UTF-8" enctype="multipart/form-data">
                            <fieldset>
                                <div class="col-md-12">
                                    <div>
                                                <span class="btn btn-block btn-primary btn-file">
                                                    Add Attachment(s)&hellip; <input id="fileupload" type="file" name="files[]" multiple>
                                                </span>
                                    </div>
                                </div>
                                
                            </fieldset>
                </form>
                <div class="row">
                    <p></p>
                    <!--<p>Attachments: </p>-->
                    <ul id="files">
                        @if ( !empty($attachments))
                                @foreach( $attachments as $file)
                                <!--<li>{{link_to_asset($file['url'], 'Attachment', $attributes = array('target' => '_new'), $secure = null)}}</li>-->
                                <li><a href="{{{URL::to($file['url'])}}}" target="_new">{{{$file['description']}}}</a></li>
                                @endforeach
                            @endif
                    </ul>
                </div>
            </div>
            <div class="tab-pane" id="receipts">
                <div class="payinfo_messages"> </div>
                @if (empty($receipts))
                    <div>
                        <button type="button" id="genReceipt" class="btn btn-block btn-primary">Generate Receipt(s)</button>
                    </div>
                    <br />
                    <div>
                        <form class="form-horizontal" id="receiptform" role="form" method="POST" accept-charset="UTF-8">
                            <fieldset>
                                <div id="receipt_details">
                                </div>
                            </fieldset>
                        </form>
                        <div class="button_div">
                            <button type="button" class="btn btn-block btn-primary submitRct" disabled="true">Post Receipt(s)</button>
                        </div>
                    </div>
                @else
                 <form class="form-horizontal" id="receiptform" role="form" method="POST" accept-charset="UTF-8">
                            <fieldset>
                                <div id="receipt_details">
                    @foreach($receipts as $receipt)
                    
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">{{{$receipt['item_desc'] }}}</div>
                                                <div class="panel-body">
                                                    <input class="form-control" type="hidden" name="item_id[]" id="item_id[]" value="{{{$receipt['particular_id'] }}}" readonly="readonly">
                                                    <input class="form-control" placeholder="Receipt No" name="receipt_number[]" id="receipt_number[]" value="{{{$receipt['receipt_no']}}}">
                                                    <br />
                                                    <input class="form-control" placeholder="Gross Amount" type="text" name="gross_amount[]" id="gross_amount[]" value="{{{$receipt['gross_amt']}}}">
                                                    <br />
                                                    <input class="form-control" placeholder="Net of VAT" type="text" name="vat_amount[]" id="vat_amount[]" value="{{{$receipt['net_vat']}}}">
                                                    <br />
                                                    <input class="form-control" placeholder="EWT" type="text" name="ewt_amount[]" id="ewt_amount[]" value="{{{$receipt['ewt']}}}">
                                                </div>
                                        </div>
                                    </div>
                    @endforeach
                                </div>
                            </fieldset>
                     </form>
                        <div class="button_div">
                            <button type="button" id="submitRct" class="btn btn-block btn-primary submitRct">Post Payment Info</button>
                    </div>            
                @endif
                
            </div>
        </div>
        
      </div>
      <div class="modal-footer">
          <div class="progress_div">
                        <div class="progress progress-striped f_bar">

                            <div class="progress-bar bar f_bar" style="width: 0%;">
                     
                                <span class="prog_txt"></span>

                            </div>

                        </div>
          </div>
            
      </div>
    </div>
</div>
    

<script>
    $( document ).ready(function() {
        var doc = $('#voucher_number').val();
        $('.modal-header').append('<h4 class="modal-title" id="myModalLabel">Modify Voucher { Document No. '+ doc +' }</h4>')
    });
    
    $(function() {
            $( '.datepicker' ).datepicker();
    });
    
    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });
    
    $(document).ready( function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
           // alert(numFiles);
           // alert(label);//
           if(numFiles == 1){
               $('#files_label').val(label);
           }
           else $('#files_label').val(numFiles + " Files Selected");
        });
    });
    
     $(function () {
        'use strict';
        
        // Define the url to send the image data to
        var url = 'attachment/' + $("#voucher_number").val();
        
        // Call the fileupload widget and set some parameters
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                // Add each uploaded file name to the #files list
                //console.log(data.result.msg);
                if(!data.result.exit){
                    $.each(data.result, function (index, file) {
                    if(file.status){
                        $('#files').append('<li><a href="'+ file.file +'" target="_new">'+ file.name +'</a></li>')
                    }
                    else{
                        //$('#files').append('<li> '+ file.msg +' </li>')
                        $( ".file_message_content" ).remove();
                        $(".file_messages").append('<div class="file_message_content alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">\n\
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\n\
                            <strong>Ooops!</strong> '+file.msg+' </div>');
                               
                    }
                    
                    console.log(file.msg);
                    });
                }
                else{
                    $( ".file_message_content" ).remove();
                        $(".file_messages").append('<div class="file_message_content alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">\n\
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\n\
                            <strong>Ooops!</strong> '+ data.result.msg +' </div>');
                }
            },
            progressall: function (e, data) {
                // Update the progress bar while files are being uploaded
                var progress = parseInt(data.loaded / data.total * 100, 10);
                var percent = progress + '%';
                $('.bar').css('width',percent);
                console.log(progress);
            }
        });
    });
    
    $(".submitBtn").click(function(e){
        $(".f_bar").addClass( "active" );
        $(".bar").css("width", "0%");
       
        $("#updateform :input").prop("readonly", true);
        $("#submitBtn").prop("disabled", true);
    //console.log( $("#updateform").serialize() );
    var request = $.ajax({
      url: "updates",
      type: "POST",
      data: $("#updateform").serialize(),
      dataType: "json"
    });
    //$(".bar").css("width", "50%");
    
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
         else if(data.status == 'success2'){
                $( ".message_content" ).remove();
                $(".messages").append('<div class="message_content alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">\n\
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\n\
                    <strong>Ooops!</strong> '+data.msg+' </div>');
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
    $('#genReceipt').click(function(e){
        console.log('hahaha');
        var record = {voucher: $('#voucher_number').val()};
        var request = $.ajax({
            url: "receipts",
            type: "POST",
            data: record,
            dataType: "json"
        });
        
        request.done(function( data ) {
           //alert(data[0].voucher_number);
           $('#receipt_details').empty();
           if(data.status > 0){
           
           }
           else{
               $.each(data.data[0].particulars, function (index, data) {
//               
                    $('#receipt_details').append('<div class="col-md-6"><div class="panel panel-default"><div class="panel-heading">'+data.item_desc+'</div>\n\
                                                 <div class="panel-body"><input class="form-control" placeholder="Receipt No" name="receipt_number[]" id="receipt_number[]" value="">\n\
                                                      <br /><input class="form-control" placeholder="Gross Amount" type="text" name="gross_amount[]" id="gross_amount[]" value="'+data.item_amount+'">\n\
                                                      <br /><input class="form-control" placeholder="Net of VAT" type="text" name="vat_amount[]" id="vat_amount[]" value="">\n\
                                                      <br /><input class="form-control" placeholder="EWT" type="text" name="ewt_amount[]" id="ewt_amount[]" value="">\n\
                                                      <input class="form-control" type="hidden" name="item_id[]" id="item_id[]" value="'+data.id+'" readonly="readonly">\n\
                                                 </div></div></div>');
                });
                
//                $('#receipt_details').append('<div class="button_div"><button type="button" class="btn btn-block btn-primary submitRct">Post Receipt(s)</button></div>');
           }
           $(".submitRct").prop("disabled", false);
        });
        
        request.fail(function( jqXHR, textStatus ) {
        
        });
        $("#genReceipt").remove();
    });
    
    $('.submitRct').click(function(e){
        //console.log('hahahar');
        $(".f_bar").addClass( "active" );
        $(".bar").css("width", "0%");
       
        $("#receiptform :input").prop("readonly", true);
        $("#submitRct").prop("disabled", true);
        var request = $.ajax({
            url: "receipts/post",
            type: "POST",
            data: $("#receiptform").serialize(),
            dataType: "json"
        });
        
        request.done(function( data ) {
            $("#receiptform :input").prop("readonly", false);
            $("#submitRct").prop("disabled", false);
            $(".bar").css("width", "100%");
            $(".f_bar").removeClass( "active" );
            $(".prog_txt").hide();
            
            $( ".payinfo_message_content" ).remove();
            
            $(".payinfo_messages").append('<div class="payinfo_message_content alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">\n\
                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\n\
                     <strong></strong> '+data.msg+' </div>');
        });
        
        request.fail(function( jqXHR, textStatus ) {
        
        });
    });
    
</script>

