    var rowNum = 0;
    var rowExist = false;
    function addRow(frm) {
    if(!rowExist){
        rowNum = $('.particulars').length;
        rowExist = true;
    }
    rowNum ++;
    //alert(rowNum);
    var row = '<div id="rowNum'+rowNum+'">\n\
        <div class="col-md-7 particulars"><span class="col-md-1 control-label">Description</span>\n\
        <input type="text" class="form-control" id="particular[]" name="particular[]" placeholder="Item Description"></div>';
    
    var row1 = '<div class="col-md-3"><span class="col-md-1 control-label">Amount</span>\n\
                <input type="text" class="form-control" id="amount[]" name="amount[]" placeholder="Amount"></div>';
   
    var r = row + row1 + '<div class="col-md-2"> <span class="col-md-1 control-label">Action</span><input class="btn btn-primary btn-block" type="button" value="-" onclick="removeRow('+rowNum+');"></div></div>';
    
   jQuery('#items').append(r);
      //frm.add_qty.value = '';
//    frm.add_name.value = '';
    }  
    
   function removeRow(rnum) {
        jQuery('#rowNum'+rnum).remove();
   }
   
   function init_rownum(val) {
       rowNum = val;
       alert(rowNum);
   }
   

