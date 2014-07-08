@extends('layouts.adminmaster')
 
{{-- content --}}
@section('content')
@if ( $errors->count() > 0 )
    <div class="alert alert-error alert-danger col-md-6 col-md-offset-3">
        <h4 class="text-center">The following errors have occurred:</h4>
        <ul>
            @foreach( $errors->all() as $message )
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ( Session::has('notice') )
    <div class="text-center alert alert-success col-md-6 col-md-offset-3">{{ Session::get('notice') }}</div>
@endif
<div class="col-md-10 col-md-offset-1">
    <!--<label for="name_div"> <h3><span class="label label-default">Add Entry </span></h3></label>-->
    <div class="col-md-12">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{{ action('VoucherController@save') }}}" accept-charset="UTF-8">
                <fieldset>

                    <div id="voucher_info" class="form-group">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-2 control-label" for="bp_street">Pay To</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="payee" id="payee" value="{{{ Input::old('payee') }}}">
<!--                                        <option value="">Select Entity</option>-->
                                        @foreach($partners as $partner)
                                            @if (Input::old('payee') == $partner['bp_id'])
                                                <option selected="selected" value="{{{$partner['bp_id']}}}">{{$partner['bp_name']}}</option>
                                            @else
                                                <option value="{{{$partner['bp_id']}}}">{{$partner['bp_name']}}</option>
                                            @endif   
                                        @endforeach
                                    </select>
                                </div>
                                <label for="bp_loc_building" class="col-md-2 control-label">Amount</label>
                                <div class="col-md-4">
                                    <input class="form-control" placeholder="Total Amount" type="text" name="total_amount" id="total_amount" value="{{{ Input::old('total_amount') }}}">
                                </div>
                               
                            </div>
                            
                            <div class="form-group row">
                                <label for="cheque" class="col-md-2 control-label">Cheque No</label>
                                <div class="col-md-4">
                                    <input class="form-control" placeholder="Cheque No" type="text" name="check_number" id="check_number" value="{{{ Input::old('check_number') }}}">
                                </div>
                                
                                <label for="bp_building" class="col-md-2 control-label">Bank</label>
                                <div class="col-md-4">
                                   <input class="form-control" placeholder="Bank" type="text" name="bank" id="bank" value="{{{ Input::old('bank') }}}">
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
                        
                        
                    <div class="form-actions form-group">
                        <button type="submit" class="btn btn-primary btn-block">Commit</button>
                    </div>
                     
                </fieldset>
            </form>
        </div>
    </div>
</div>

               
@stop


{{-- content --}}
@section('scripts')
    

    <!-- Page-Level Plugin Scripts - Dashboard -->
    <script src="{{ URL::asset('js/plugins/morris/raphael-2.1.0.min.js')}}"></script>
    <script src="{{ URL::asset('js/plugins/morris/morris.js')}}"></script>

   <!-- Page-Level Demo Scripts - Dashboard - Use for reference
    <script src="{{ URL::asset('js/demo/dashboard-demo.js')}}"></script>-->
@stop