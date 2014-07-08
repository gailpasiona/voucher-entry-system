@extends('layouts.adminmaster') 
{{-- main.prepend --}}
@section('main.prepend')
{{-- maybe, need dump form errors --}}
<div class="row">
@stop
 

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
    <div class="alert">{{ Session::get('notice') }}</div>
@endif

<div class="col-md-12">
    <table id="records" class="table table-striped" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Voucher No.</th>
                <th>Total Amount</th>
                <th>Cheque No.</th>
                <th>Bank</th>
                <th>Pay To</th>
                <th>Action</th>
                
            </tr>
        </thead>
        	<tbody>
                <tr>	
                    <td></td>
                    <td></td>
                    <td></td>	
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
    </table>
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
        $(document).ready(function() {
              $('#records').dataTable( {
                "oLanguage": {
                        "sSearch": "Filter  ",
                        "sLengthMenu": "Records _MENU_"
                },
                "oPaginationType": "bootstrap",
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "ajax"
               });
        });
    </script>
@stop

