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
    
    public function save(){
        //$bpid = Input::get( 'bp' );
        $filter = Voucher::validate(Input::all());
        
        $items = $this->prepareKeys(Input::only('particular', 'amount'));
        
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
    
    private function insertItems($line_items,$v_no){
        
        foreach($line_items as $lines){
            $item = new Particular;
            
            $item->line_number = $lines['line_number']; 
            $item->item_desc = $lines['particular']; 
            $item->item_amount = $lines['amount'];
            
            $item->voucher()->associate(Voucher::find($v_no));
            
            $item->save(); 
            
           
        }
    }
    
    private function prepareKeys($param) {
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
}