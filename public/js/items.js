    var rowNum = 0;
    var rowExist = false;
    function addRow(frm) {
    if(!rowExist){
        rowNum = $('.particulars').length;
        rowExist = true;
    }
    rowNum ++;
    console.log(rowNum);
    var row = '<div id="rowNum'+rowNum+'">\n\ \n\
        <div class="col-md-3"><span class="col-md-1 control-label">Ref</span>\n\
        <input type="text" class="form-control" id="ref_no[]" name="ref_no[]" placeholder="Ref"></div>\n\
        <div class="col-md-5 particulars"><span class="col-md-1 control-label">Description</span>\n\
        <input type="text" class="form-control" id="particular[]" name="particular[]" placeholder="Item Description"></div>\n\ ';
    
    var row1 = '<div class="col-md-3"><span class="col-md-1 control-label">Amount</span>\n\
                <input type="text" class="form-control" id="amount[]" name="amount[]" placeholder="Amount"></div>\n\ ';
    
    
   
    var r = row + row1 + '<div class="col-md-1"> <span class="col-md-1 control-label"><br /></span><input class="btn btn-primary btn-block" type="button" value="-" onclick="removeRow('+rowNum+');"></div></div>';
    
   jQuery('.items').append(r);
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
   
   function clearall(){
       this.rowNum = 0;
   }
   

