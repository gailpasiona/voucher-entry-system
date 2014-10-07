<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
        <div class="modal-body">
            
            @foreach($data as $info)
                <!--<p>{{$info['voucher_number']}}</p>-->
            
                @foreach($info['particulars'] as $i)
                <div class="well">
                    <div>
                        <p>Item Description: {{$i['item_desc']}}</p>
                        <p>Amount: {{$i['item_amount']}}</p>
                    </div>
                    @foreach($i['receipt'] as $receipt)
                    <div>
                        <p>Receipt Number: {{$receipt['receipt_no']}}</p>
                        <p>Gross Amount: {{$receipt['gross_amt']}}</p>
                        <p>Net VAT: {{$receipt['net_vat']}}</p>
                        <p>EWT: {{$receipt['ewt']}}</p>
                    </div>
                        
                    @endforeach
                </div>
                    
                @endforeach
            
                    
            @endforeach
        </div>
    </div>
</div>

<script>
    $( document ).ready(function() {
        //var doc = $('#voucher_number').val();
        $('.modal-header').append('<h4 class="modal-title" id="myModalLabel">Additional Info</h4>')
    });
</script>

