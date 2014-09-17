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
                select('vouchers.voucher_number','vouchers.voucher_date','vouchers.total_amount','vouchers.check_number',
                        'business_partners.bp_name');
    
        //return Datatables::of($vouchers)->add_column('operations','<a href="{{ route("modifyVoucher", $voucher_number) }}"><i class="fa fa-pencil-square fa-lg"></i></a>')->make();
        // 
        if(Confide::user()->can('approve_vouchers')){
            return Datatables::of($vouchers)->add_column('operations','<a href="{{ route("modifyVoucher", $voucher_number) }}" data-toggle="modal" data-target="#edit_modal" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square fa-lg"></i></a> &nbsp; '
                    . '<a href="{{ route("approveVoucher", $voucher_number) }}" data-toggle="modal" data-target="#approve_modal" data-tooltip="tooltip" data-placement="top" title="Process"><i class="fa fa-thumbs-o-up fa-lg"></i></a>')->make();
        }
        else{
            return Datatables::of($vouchers)->add_column('operations','<a href="{{ route("modifyVoucher", $voucher_number) }}" data-toggle="modal" data-target="#edit_modal" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square fa-lg"></i></a>')->make();
        }
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
         
        $record = Voucher::find($voucher_no);
        
        $status = Approval::where('voucher_number','=',$voucher_no)->where('approved','=',1)->count();
        
        $particulars = Voucher::find($voucher_no)->particulars->toArray();
        
        $attachments = Voucher::find($voucher_no)->attachments->toArray();
        
        return View::make('forms.voucher_modify_ajax')->with('info', $record)
                ->with('status', $status)
            ->with('partners', $partner)
                ->with('particulars',$particulars)->with('attachments',$attachments);
        
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
    
    public function attach(){
        $file_max = ini_get('upload_max_filesize');
        $file_max_str_leng = strlen($file_max);
        $file_max_meassure_unit = substr($file_max,$file_max_str_leng - 1,1);
        $file_max_meassure_unit = $file_max_meassure_unit == 'K' ? 'kb' : ($file_max_meassure_unit == 'M' ? 'mb' : ($file_max_meassure_unit == 'G' ? 'gb' : 'unidades'));
        $file_max = substr($file_max,0,$file_max_str_leng - 1);
        $file_max = intval($file_max);

        //handle second case
        if((empty($_FILES) && empty($_POST) && isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post'))
        { //catch file overload error...
             //grab the size limits...
            return json_encode(array('success'=>false, 'message'=>sprintf('The file size should be lower than %s%s.',$file_max,$file_max_meassure_unit)));
        }

        try{

            if (!Input::hasFile('file'))
                return;

            $utils = App::make('utils');
            $file = Input::file('file');

            $name = Input::get('name');
            $size = $file->getSize();

            if ($size > $file_max)
                return json_encode(array('success'=>false, 'message'=>sprintf('El tamaño del archivo debe ser menor que %smb.',$file_max)));

            $original_file_name = $file->getClientOriginalName();

            $destination_directory = "";

            $final_file_name = $utils->copy_file_to_location($file);       

            return json_encode(array('success'=>true, 'file'=>$original_file_name));
        }
        catch (Exception $e)
        {
            //handle first case
            return json_encode(array('success'=>false, 'message'=>sprintf('The file size should be lower than %s%s.',$file_max,$file_max_meassure_unit)));
        }
    }
    
    public function attachment($voucher_number){
        // Form Validation
	$valid_exts = array('jpeg', 'jpg', 'png', 'pdf'); // valid extensions
        $max_size = 50000 * 1024; // max file size (5000kb)
        //$path = public_path() . '/img/'; // upload directory
        //$fileName = NULL;
        $response = array();
        if((empty($_FILES) && empty($_POST) && isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post'))
        { //catch file overload error...
             //grab the size limits...
            //return json_encode(array('success'=>false, 'msg'=>'Upload failed! File too big, size must be lower than 5MB.'));
            $data = array('status' => NULL, 'msg'=> NULL, 'exit'=> NULL);
            $data['status'] = FALSE;
            $data['msg'] = 'Upload failed! Total upload size too big, size must be lower than 5MB.';
            $data['exit'] = TRUE;
            return Response::json($data);
            
        }
        else{
            
            // looking for format and size validity
            //$name = $file->getClientOriginalName();
            
            $files = Input::file('files');
            // We will store our uploads in public/uploads/basic
            $assetPath = '/attachments' . '/' . $voucher_number;
            $uploadPath = public_path($assetPath);
            if(!File::exists($uploadPath)) {
                // path does not exist
                File::makeDirectory($uploadPath, $mode = 0777, true, true);
            }
            //$path = public_path().'/images/article/imagegallery/' . $galleryId;
            
            // We need an empty arry for us to put the files back into
            $results = array();
            foreach ($files as $file) {
                $data = array('status' => NULL, 'msg'=> NULL , 'file' => NULL, 'name' => NULL);
                $ext = $file->guessClientExtension();
                // get size
                $size = $file->getClientSize();
                if (in_array($ext, $valid_exts) AND $size < $max_size){
                    $name = $assetPath . '/' . $file->getClientOriginalName();
                    $data['file'] = URL::to($name);
                    $data['name'] = $file->getClientOriginalName();
                    //$filename = compact('name');
                    if($file->move($uploadPath, $file->getClientOriginalName())){
                        $file_attach = new Attachment;
                        $file_attach->voucher_number = $voucher_number;
                        $file_attach->description = $file->getClientOriginalName();
                        $file_attach->url = $name;
                        $file_attach->save();
                        
                        $data['status'] = TRUE;
                        $data['msg'] = 'Upload successful';
                    }
                    else {
                        $data['status'] = FALSE;
                        //$data['name'] = 'Upload Fail: Unknown error occurred!';
                        $data['msg'] = 'Upload Fail: Unknown error occurred!';
                    }
                }
                else{
                    $data['status'] = FALSE;
                    //$data['name'] = 'Upload Fail: Unsupported file format or It is too large to upload!';
                    $data['msg'] = 'Upload Fail: Unsupported file format or It is too large to upload!';
                }
                array_push($response, $data);  
            }
        }
        // echo out json encoded status
//        return header('Content-type: application/json') . json_encode(array('status' => $status,
//        'fileName' => $fileName));
        return Response::json($response);
    }
        
        
    
    public function saves(){
        //$bpid = Input::get( 'bp' );
        $response = array('status' => NULL, 'msg'=> NULL , 'error' => NULL , 'flag' => NULL);
         $monitor_flag = NULL;
        if (Request::ajax())
        {
            $filter = Voucher::validate(Input::all());
        
            $items = $this->prepareKeysfromInput(Input::only('ref_no', 'particular', 'amount'));
            
            if($filter->passes()) {
            
                $voucher = new Voucher;

                $control_no = date('Y') . '-' . (DB::table('vouchers')->count() + 1);

                $voucher->voucher_number = $control_no;
                $voucher->total_amount = Input::get('total_amount');
                $voucher->check_number = Input::get('check_number');
                $voucher->check_date = Input::get('check_date');
                $voucher->voucher_date = Input::get('voucher_date');
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
            //$partner = BusinessPartner::select('bp_id','bp_name')->get();
            $filter = Voucher::validate(Input::all());
            //$record = $this->prepareRecord(Input::except('particular','amount'));
            //$particulars = $this->prepareKeysfromDB(Input::all());//only('particular', 'amount'));
            $v = Voucher::find(Input::get('voucher_number'));
            $status = Approval::where('voucher_number','=',$v->voucher_number)->where('approved','=',1)->count();
            if($status < 1){
                if($filter->passes()){
                    $particulars = $this->prepareKeysfromDB(Input::all());

                    $v->total_amount = Input::get('total_amount');
                    $v->check_number = Input::get('check_number');
                    $v->check_date = Input::get('check_date');
                    $v->voucher_date = Input::get('voucher_date');
                    $v->bank = Input::get('bank');
                    $v->payto()->associate(BusinessPartner::find(Input::get('payee')));
                   // dd($v->getDirty());
                    if(count($v->getDirty()) > 0) /* avoiding resubmission of same content */
                    {
                        $v->push();

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
            }
            else{
                $response['status'] = "success2";
                $response['msg'] = "Unable to commit changes. Voucher is already approved";
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
            $item->ref_no = $lines['ref_no'];
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
                 $item->ref_no = $line['ref_no'];
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
                 $new_item->ref_no = $line['ref_no'];
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
    
    public function signatory(){
        //var_dump(Confide::user()->id);
//        $user = Confide::user();
//        if(Confide::user()->can('complete_vouchers')) echo 'yes he can!';
//        else echo 'no he cannot!';
//        $users = Role::where('name','=','Superuser')->first()->users()->get();
//        foreach($users as $user){
//          echo $user->id . "\n";   
//        }
       // $e = $users->toArray();
        //$voucher = Voucher::find($voucher_number);
        $response = array('status' => NULL, 'msg'=> NULL, 'flag' => NULL);
        $flag = NULL;
        $message = NULL;
        $status = NULL;
        $voucher_number = Input::get('voucher_number');
        if(Confide::user()->can('approve_vouchers')){
//            $approvals = Approval::where('voucher_number','=',$voucher_number)
//                    ->where('voucher_approver','=',Confide::user()->id)
//                    ->where('approved','=',1)->count();
            $approvals = Approval::where('voucher_number','=',$voucher_number)
                    ->where('voucher_approver','=',Confide::user()->id)->count();
                    //->where('approved','=',1)->count();
           
            if($approvals == 0){
                $approver = new Approval;
        
                $approver->voucher_approver = Confide::user()->id;
                
                $approver->approved = 1;
        
                $voucher = Voucher::find($voucher_number);
                
                //$voucher->status = $voucher->status + 1;
                
                $voucher->signatories()->save($approver);
                
               // $voucher->save();
                
                $status = "success";
                $message  = "Voucher Approved Successfully";
                $flag = 1;
                
            }
            else if($approvals > 0 ){
                $approvals2 = Approval::where('voucher_number','=',$voucher_number)
                    ->where('voucher_approver','=',Confide::user()->id)
                        ->where('approved','=',0)->first();
                $approvals2->approved = 1;
                $approvals2->save();
                
                $status = "success";
                $message  = "Voucher Approved Successfully";
                $flag = 1;
            }
            else{
               // echo $approvals;
                
                $status = "success1";
                $message  = "Unable to proceed.You might have already approved this voucher";
                $flag = 0;
            }
        }
        else{
            $status = "success1";
            $message  = "Unable to proceed.Insufficient privileges";
            $flag = 0;
        }
        
        $response['status'] = $status;
        $response['msg']  = $message;
        $response['flag'] = $flag;
        
        return Response::json( $response );
    }
    
    public function approve($voucher_number){
        $status = array("approval" => NULL);//, "reopen" => NULL);
        
        $record = Voucher::find($voucher_number);//->get(array('voucher_number'));
        
        //$stats = Approval::where('voucher_number','=',$voucher_no)->where('approved','=',1)->count();
        
        $isApprovedby = Approval::where('voucher_number','=',$voucher_number)
                ->where('voucher_approver','=',Confide::user()->id);
                   // ->where('voucher_approver','=',Confide::user()->id)->count(); 
         //echo($isApprovedby->count());
        if($isApprovedby->count() > 0){
            
            $status["approval"] =  $isApprovedby->first()->approved;
           
        }
        
        else{
            $status["approval"] = 0;
        }
        
       
        return View::make('forms.voucher_approval')->with('info', $record)
                ->with('status', $status);
    }
    
    public function reactivate(){
        $response = array('status' => NULL, 'msg'=> NULL, 'flag' => NULL);
        $flag = NULL;
        $message = NULL;
        $status = NULL;
        $voucher_number = Input::get('voucher_number');
        if(Confide::user()->can('approve_vouchers')){
            $approvals = Approval::where('voucher_number','=',$voucher_number)
                    ->where('voucher_approver','=',Confide::user()->id)
                    ->where('approved','=',1)->first();
            
            if($approvals->count() == 0){
//                $approver = $approvals->first();
//        
//                $approver->approved = 1;
//        
//                $voucher = Voucher::find($voucher_number);
//                
//                $voucher->status = $voucher->status + 1;
//                
//                $voucher->signatories()->save($approver);
//                
//                $voucher->save();
//                
                $status = "success1";
                $message  = "Voucher is still active";
                $flag = 0;
                
            }
            else{
               // echo $approvals;
                
                $approvals->approved = 0;
                $approvals->save();
                $status = "success";
                $message  = "Voucher successfully re-activated";
                $flag = 1;
            }
        }
        else{
            $status = "success1";
            $message  = "Unable to proceed.Insufficient privileges";
            $flag = 0;
        }
        
        $response['status'] = $status;
        $response['msg']  = $message;
        $response['flag'] = $flag;
        
        return Response::json( $response );
    }
    
    private function prepareKeysfromInput($param) {
        $item_lines = array();
        for($line = 0; $line < count($param['particular']); $line++){
           $item = array('line_number' => NULL,'ref_no' => NULL, 'particular' => NULL, 'amount' => NULL);
           $item['line_number'] = $line;
           $item['ref_no'] = $param['ref_no'][$line];
           $item['particular'] = $param['particular'][$line]; 
           $item['amount'] = $param['amount'][$line];
           array_push($item_lines,$item);
        }
        return $item_lines;
    }
    
   private function prepareKeysfromDB($param){
       $item_lines = array();
        for($line = 0; $line < count($param['particular']); $line++){
           $item = array('line_number' => NULL, 'ref_no' => NULL, 'item_desc' => NULL, 'item_amount' => NULL);
           $item['line_number'] = $line;
           $item['ref_no'] = $param['ref_no'][$line];
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
   
   public function reporting(){
       return View::make('forms.voucher_reports');
   }
    
}

