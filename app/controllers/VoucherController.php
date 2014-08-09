<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class VoucherController extends BaseController{
    
    public function create()
    {
        $partner = BusinessPartner::select('bp_id','bp_name')->get();
       
        return View::make('forms.voucher_create')->with('partners',$partner);
    }
    
    public function create2()
    {
        $partner = BusinessPartner::select('bp_id','bp_name')->get();
       
        return View::make('forms.voucher_create_ajax')->with('partners',$partner);
    }
    
    public function edit()
    {
        $partner = BusinessPartner::select('bp_id','bp_name')->get();
       
        return View::make('forms.voucher_edit');//->with('partners',$partner);
        
    }
    
    public function popTable(){
    $vouchers = DB::table('business_partners')->join('vouchers','business_partners.bp_id','=','vouchers.payto_id')->
                select('vouchers.voucher_number','vouchers.total_amount','vouchers.check_number',
                        'vouchers.bank','business_partners.bp_name');
        //return Datatables::of($vouchers)->add_column('operations','<a href="{{ route("modifyVoucher", $voucher_number) }}"><i class="fa fa-pencil-square fa-lg"></i></a>')->make();
    
        return Datatables::of($vouchers)->add_column('operations','<a href="{{ route("modifyVoucher", $voucher_number) }}" data-toggle="modal" data-target="#edit_modal"><i class="fa fa-pencil-square fa-lg"></i></a>')->make();
    }
    
//normal loading
//    public function modify($voucher_no){
//        $partner = BusinessPartner::select('bp_id','bp_name')->get();
//         
//        $record = Voucher::find($voucher_no)->toArray();
//        
//        $particulars = Voucher::find($voucher_no)->particulars->toArray();
//        
//        
//        return View::make('forms.voucher_modify')->with('info', $record)
//            ->with('partners', $partner)
//                ->with('particulars',$particulars);
//        
//    }
    //modal form
    public function modify($voucher_no){
        $partner = BusinessPartner::select('bp_id','bp_name')->get();
         
        $record = Voucher::find($voucher_no)->toArray();
        
        $particulars = Voucher::find($voucher_no)->particulars->toArray();
        
        
        return View::make('forms.voucher_modify_ajax')->with('info', $record)
            ->with('partners', $partner)
                ->with('particulars',$particulars);
        
    }


    public function save(){
        //$bpid = Input::get( 'bp' );
        $filter = Voucher::validate(Input::all());
        
        $items = $this->prepareKeysfromInput(Input::only('particular', 'amount'));
        
        if($filter->passes()) {
            
            $voucher = new Voucher;
            
            $control_no = date('Y') . '-' . (DB::table('vouchers')->count() + 1);
            
            $voucher->voucher_number = $control_no;
            $voucher->total_amount = Input::get('total_amount');
            $voucher->check_number = Input::get('check_number');
            $voucher->bank = Input::get('bank');
            
            $voucher->payto()->associate(BusinessPartner::find(Input::get('payee')));
            
            $voucher->user()->associate(Confide::user());
          
            if($voucher->save()){
                //if(isset(Input::get('particular', 'amount')))
               $this->insertItems($items,$control_no); 
            }
            return Redirect::action('VoucherController@create')
                            ->with('notice', 'Voucher Successfuly recorded!');
        }
        else{
            return Redirect::action('VoucherController@create')
                            ->withInput(Input::except('particular','amount'))
                            ->with('errors', $filter->messages())
                            ->with('particulars', $items);
        }
    }
    
    public function update(){
        $partner = BusinessPartner::select('bp_id','bp_name')->get();
        $filter = Voucher::validate(Input::all());
        $record = $this->prepareRecord(Input::except('particular','amount'));
        $particulars = $this->prepareKeysfromDB(Input::only('particular', 'amount'));
        $v = Voucher::find(Input::get('voucher_number'));
        $message = "";
        if($filter->passes()){
           //dd(Input::all());
                $v->total_amount = Input::get('total_amount');
                $v->check_number = Input::get('check_number');
                $v->bank = Input::get('bank');
                $v->payto()->associate(BusinessPartner::find(Input::get('payee')));
               // dd($v->getDirty());
                if(count($v->getDirty()) > 0) /* avoiding resubmission of same content */
                {
                    $v->push();
                    //echo 'Post is updated!';
                    //return Redirect::back()->with('success', 'Post is updated!');
                    $message = "Info Changes Committed, ";
                }
                else
                    //return Redirect::back()->with('success','Nothing to update!');
                   // echo 'Nothing to update!';
                    $message = "No Info Changes, ";
                
                if($this->updateItems($particulars, Input::get('voucher_number')) > 0)
                        $message = $message . "Particulars also updated!";
                else $message = $message . "No changes in particulars";
                
               
                Redirect::back()->with('success', $message);
            
        }
       // else var_dump($filter->messages());
        
        else{
//            return View::make('forms.voucher_modify')->with('info', $record)
//            ->with('partners', $partner)
//                    ->with('errors', $filter->messages())
//                ->with('particulars',$particulars);
            
            return Redirect::back()->with('info', $record)
            ->with('partners', $partner)
                    ->with('errors', $filter->messages())
                ->with('particulars',$particulars);
        }
        
    }
    
    public function saves(){
        //$bpid = Input::get( 'bp' );
        $response = array('status' => NULL, 'msg'=> NULL , 'error' => NULL , 'flag' => NULL);
         $monitor_flag = NULL;
        if (Request::ajax())
        {
            $filter = Voucher::validate(Input::all());
        
            $items = $this->prepareKeysfromInput(Input::only('particular', 'amount'));
            
            if($filter->passes()) {
            
                $voucher = new Voucher;

                $control_no = date('Y') . '-' . (DB::table('vouchers')->count() + 1);

                $voucher->voucher_number = $control_no;
                $voucher->total_amount = Input::get('total_amount');
                $voucher->check_number = Input::get('check_number');
                $voucher->bank = Input::get('bank');

                $voucher->payto()->associate(BusinessPartner::find(Input::get('payee')));

                $voucher->user()->associate(Confide::user());

                if($voucher->save()){
                    //if(isset(Input::get('particular', 'amount')))
                   $this->insertItems($items,$control_no); 
                }
                $response['status'] = "success";
                $response['msg'] = "Record Saved!";
                $response['flag'] = 1;
            }
            else{
                $response['status'] = "success1";
                $response['msg'] = "validation error";
                $response['flag'] = 0;
                $response['error'] = $filter->messages()->toJson();
//            return Redirect::action('VoucherController@create')
//                            ->withInput(Input::except('particular','amount'))
//                            ->with('errors', $filter->messages())
//                            ->with('particulars', $items);
            }
        }
        
        return Response::json( $response );  
        
    }
    
    public function updates(){
        $response = array('status' => NULL, 'msg'=> NULL , 'error' => NULL , 'flag' => NULL);
        $monitor_flag = NULL;
        if (Request::ajax())
        {
            $partner = BusinessPartner::select('bp_id','bp_name')->get();
            $filter = Voucher::validate(Input::all());
            //$record = $this->prepareRecord(Input::except('particular','amount'));
            //$particulars = $this->prepareKeysfromDB(Input::all());//only('particular', 'amount'));
            $v = Voucher::find(Input::get('voucher_number'));
            
            if($filter->passes()){
                $particulars = $this->prepareKeysfromDB(Input::all());
                
                $v->total_amount = Input::get('total_amount');
                $v->check_number = Input::get('check_number');
                $v->bank = Input::get('bank');
                $v->payto()->associate(BusinessPartner::find(Input::get('payee')));
               // dd($v->getDirty());
                if(count($v->getDirty()) > 0) /* avoiding resubmission of same content */
                {
                    $v->push();
                    //echo 'Post is updated!';
                    //return Redirect::back()->with('success', 'Post is updated!');
                    $message = "Info Changes Committed, ";
                    $monitor_flag = 1;
                }
                else
                    $message = "No Info Changes, ";
                
                if($this->updateItems($particulars, Input::get('voucher_number')) > 0){
                    $message = $message . "Particulars updated!";
                    if(is_null($monitor_flag)) 
                        $monitor_flag = 1;
                    else{
                        if($monitor_flag == 0) $response['flag'] = 1; 
                    }
                }
                       
                else{
                     $message = $message . "No changes in particulars";
                     if(is_null($monitor_flag)) 
                         $monitor_flag = 0;
                } 
                   
                
                $response['status'] = "success";
                $response['msg'] = $message;
                $response['flag'] = $monitor_flag;
            }
            
            else{
                $response['status'] = "success1";
                $response['msg'] = "validation error";
                $response['error'] = $filter->messages()->toJson();
                $response['flag'] = 0;
            }
        
         return Response::json( $response );
        }
        //dd(Input::all());
    }
    
    private function insertItems($line_items,$v_no){
        $record = Voucher::find($v_no);
        foreach($line_items as $lines){
            $item = new Particular;
            
            $item->line_number = $lines['line_number']; 
            $item->item_desc = $lines['particular']; 
            $item->item_amount = $lines['amount'];
            
           // $item->voucher()->associate(Voucher::find($v_no));
            $item->voucher()->associate($record);
            
            $item->save(); 
            
           
        }
    }

    private function updateItems($line_items,$v_no){
        $key_id = null;
        foreach($line_items as $line){
             $item = Particular::where('voucher_number','=',$v_no)->where('line_number', '=', $line['line_number'])->first();
             $key_id = $line['line_number'];
             $returninfo = 0;
             if($item){
                 
                 $item->line_number = $line['line_number']; 
                 $item->item_desc = $line['item_desc']; 
                 $item->item_amount = $line['item_amount'];
                 
                 if(count($item->getDirty()) > 0){
                     $item->save();
                     $returninfo = 1;
                 }
                 
             }
             
             else{
                 
                 $new_item = new Particular;
                 $new_item->line_number = $line['line_number']; 
                 $new_item->item_desc = $line['item_desc']; 
                 $new_item->item_amount = $line['item_amount'];
                 
                 $new_item->voucher()->associate(Voucher::find($v_no));
                 
                 $new_item->save();
                 
                 $returninfo = 1;
             }
             
        }
        //delete all remaining particulars
        $items_for_delete = Particular::where('voucher_number','=',$v_no)->where('line_number', '>', $key_id)->delete(); 
        
        
        return $returninfo;
    }
    
    private function prepareKeysfromInput($param) {
        $item_lines = array();
        for($line = 0; $line < count($param['particular']); $line++){
           $item = array('line_number' => NULL, 'particular' => NULL, 'amount' => NULL);
           $item['line_number'] = $line;
           $item['particular'] = $param['particular'][$line]; 
           $item['amount'] = $param['amount'][$line];
           array_push($item_lines,$item);
        }
        return $item_lines;
    }
    
   private function prepareKeysfromDB($param){
       $item_lines = array();
        for($line = 0; $line < count($param['particular']); $line++){
           $item = array('line_number' => NULL, 'item_desc' => NULL, 'item_amount' => NULL);
           $item['line_number'] = $line;
           $item['item_desc'] = $param['particular'][$line]; 
           $item['item_amount'] = $param['amount'][$line];
           array_push($item_lines,$item);
        }
       return $item_lines;
   }
   
   private function prepareRecord($param){
       $item_lines = array();
       
       $item_lines['voucher_number'] = $param['voucher_number'];
       $item_lines['created_at'] = $param['created_at'];
       $item_lines['payto_id'] = $param['payee'];
       $item_lines['total_amount'] = $param['total_amount'];
       $item_lines['check_number'] = $param['check_number'];
       $item_lines['bank'] = $param['bank'];
       
       return $item_lines;
   }
    
}