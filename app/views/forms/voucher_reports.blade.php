@extends('layouts.adminmaster') 
@section('content')

<div class="col-md-12 box">
    <div class="box-header">
        <div class="col-md-12 row header-grp">
            <h3 class="col-md-12 text-center">Vouchers Reports</h3>
            <!--<label for="bp_loc_country" class="col-md-4 control-label">Filter</label>-->
            <br />
            <div class="col-md-12">
                <!--<form class="form-horizontal" role="form" accept-charset="UTF-8">-->
                    <!--<fieldset>-->
                    <label class="col-md-12">Filter</label>
                            <div class="form-group row">
                                    <div class="col-md-4">
                                        <select class="form-control" name="report" id="report">
                                            <option value="0">Single Record</option>
                                            <option value="1">Voucher Headers</option>
                                            <option value="2">Detailed Vouchers</option>
                                        </select>
                                    </div>
                                    <div class="dyn_options" class="col-md-4">
                                        <div class="dyn_options_content col-md-4">
                                            <input class="form-control" placeholder="Voucher Number" type="text" name="voucher_number" id="voucher_number">
                                        </div><!--
-->                                        <div class="dyn_options_button col-md-4">
                                            <button type="button" id="queryReports" class="btn btn-primary btn-block queryReport">Load Report</button>
                                        </div>
                                    </div>
                            </div>
                    <!--</fieldset>-->
                <!--</form>-->
                <!--<a href="{{ route('createVoucher')}}" data-toggle="modal" data-target="#create_modal" class="btn btn-primary btn-lg pull-right navbar-btn"><span class="fa fa-plus-circle fa-md">  Add Record</span></a>-->
            </div>
        </div>
    </div>
    
</div>
<div id="report_area">
<!--        <table data-toggle="table" data-url="get_report" data-cache="false" data-height="299" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true">
            <thead>
                <tr>
                    <th data-field="name">Item ID</th>
                    <th data-field="age">Item Name</th>
                    </tr>
            </thead>
        </table>-->
        
    </div>
@section('modal_edit')
    <div class="modal fade" id="info_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
    </div>
@stop


@stop
@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-table.css')}}" />
@stop
@section('scripts')
    <script src="{{ URL::asset('js/bootstrap-table.js')}}"></script>
    <script>
        
        $("#report").change(function(){
               var type = $('#report').val();
              
               switch(type){
                    case '0':
                       $(".dyn_options_content").remove();
//                       $(".dyn_options").append('<div class="dyn_options_content col-md-4">\n\
//                                        <input class="form-control" placeholder="Voucher Number" type="text" class="voucher_number"></div>');
                                        //<div class="dyn_options_content col-md-4"><button type="button" class="btn btn-primary btn-block queryReport">Load Report</button</div>');
                        $('<div class="dyn_options_content col-md-4">\n\
                                        <input class="form-control" placeholder="Voucher Number" type="text" class="voucher_number"></div>').insertBefore(".dyn_options_button");
                        console.log("appended");
                       break;
                   case '1':
                       $(".dyn_options_content").remove();
                        console.log("removed");
                       break;
                   case '2':
                       $(".dyn_options_content").remove();
                        console.log("removed");
                       break;
               }
                       
        });
        
        $('.queryReport').click(function(){
            var address = null;
//             $.ajax({
//                    url: "get_report",
//                    dataType: "json"
//             }).success(function(data){
//                    $('#report_area').append(JSON.stringify(data));
//        });
            console.log("click");
            $('#report_table').remove();
            $('#report_area').append('<div id="report_table"><table id="table-vouchers"></table></div>');
            var type = $('#report').val();
            switch(type){
                case '0':
                    address = null;
                    break;
                case '1':
                    address = 'get_report';
                    $('#table-vouchers').bootstrapTable({
                        url: address,
                        showRefresh: true,
                        showColumns: true,
                        search: true,
                       //    showToggle: true,
                        pagination: true,
                        columns: [{
                            field: 'voucher_number',
                            title: 'Voucher Number',
                            //align: 'right',
                            sortable: true,
                            width: 200/2
                        }, {
                            field: 'voucher_date',
                            title: 'Voucher Date',
                            //align: 'right',
                            //valign: 'bottom',
                            width: 200/4,
                            sortable: true
                        }, {
                            field: 'total_amount',
                            title: 'Amount',
                            //align: 'right',
                            //valign: 'bottom',
                            width: 200/3,
                            sortable: false
                        }, {
                            field: 'check_number',
                            title: 'Cheque No',
                            //align: 'right',
                            //valign: 'bottom',
                            width: 200/3,
                            sortable: false
                        }, {
                            field: 'bp_name',
                            title: 'Pay To',
                            //align: 'right',
                            //valign: 'bottom',
                            width: 200/3,
                            sortable: false
                        }, {
                            field: 'username',
                            title: 'Created By',
                            //align: 'right',
                            //valign: 'bottom',
                            width: 200/3,
                            sortable: false
                        },{
                            field: 'status',
                            title: 'Status',
                            formatter: statusFormatter,
                            //align: 'right',
                            //valign: 'bottom',
                            width: 200/3,
                            sortable: false
                        },{
                            field: 'voucher_number',
                            title: 'Info',
                            formatter: urlFormatter,
                            align: 'center',
                            valign: 'center',
                            width: 200/4,
                            sortable: false
                        }]
                    });
                    break;
                case '2':
                    address = 'detailed_report';
                    $('#table-vouchers').bootstrapTable({
                        url: address,
                        showRefresh: true,
                        showColumns: true,
                        search: true,
                       //    showToggle: true,
                        pagination: true,
                        columns: [{
                            field: 'voucher_number',
                            title: 'Voucher Number',
                            //align: 'right',
                            sortable: true,
                            width: 200/2
                        }, {
                            field: 'voucher_date',
                            title: 'Voucher Date',
                            //align: 'right',
                            //valign: 'bottom',
                            width: 200/4,
                            sortable: true
                        }, {
                            field: 'total_amount',
                            title: 'Amount',
                            //align: 'right',
                            //valign: 'bottom',
                            width: 200/3,
                            sortable: false
                        }, {
                            field: 'check_number',
                            title: 'Cheque No',
                            //align: 'right',
                            //valign: 'bottom',
                            width: 200/3,
                            sortable: false
                        }, {
                            field: 'bp_name',
                            title: 'Pay To',
                            //align: 'right',
                            //valign: 'bottom',
                            width: 200/3,
                            sortable: false
                        },{
                            field: 'item_desc',
                            title: 'Description',
                            //formatter: urlFormatter,
                            align: 'center',
                            valign: 'center',
                            width: 200/4,
                            sortable: false
                        },{
                            field: 'item_amount',
                            title: 'Item Amount',
                            align: 'center',
                            valign: 'center',
                            width: 200/4,
                            sortable: false
                        },{
                            field: 'net_vat',
                            title: 'VAT',
                            align: 'center',
                            valign: 'center',
                            width: 200/4,
                            sortable: false
                        },{
                            field: 'ewt',
                            title: 'EWT',
                            align: 'center',
                            valign: 'center',
                            width: 200/4,
                            sortable: false
                        }]
                    });
                    break;                    
            }
                
            

    return false;
        });
        
        function statusFormatter(value) {
        // 16777215 == ffffff in decimal
        var status_name = null;
            switch(value){
                case '1':
                    status_name = 'Pending';
                    break;
                case '2':
                    status_name = 'Closed';
                    break;
                default:
                    status_name = 'Open';
                    break;
            }
            return status_name;
        }
        
        function urlFormatter(value){
            return '<a href="more_info/'+ value +'" data-toggle="modal" data-target="#info_modal" data-tooltip="tooltip" data-placement="top" title="Payment Info"><i class="fa fa-info-circle fa-lg"></i></a>';
        }
         
         $('body').tooltip({
                    selector: "[data-tooltip=tooltip]",
                    container: "body"
                });
        $('#info_modal').on('hidden.bs.modal', function () {
            $(this).removeData(('bs.modal'));
        });
    </script>
@stop