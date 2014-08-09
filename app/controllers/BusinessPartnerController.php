<?php


class BusinessPartnerController extends BaseController {

    /**
     * Displays the form for account creation
     *
     */
    public function create()
    {
        return View::make('forms.bp_create_form');
    }
    
    public function save(){
        
        $filter = BusinessPartner::validate(Input::all());
       
        if($filter->passes()) {
            $bp = new BusinessPartner;
            $bp->bp_name = Input::get( 'bp_name' );
            $bp->bp_loc_building = Input::get( 'bp_loc_building' );
            $bp->bp_loc_street = Input::get( 'bp_loc_street' );
            $bp->bp_loc_city = Input::get( 'bp_loc_city' );
            $bp->bp_loc_country = Input::get( 'bp_loc_country' );
            $bp->bp_contact_fname = Input::get( 'bp_contact_fname' );
            $bp->bp_contact_lname = Input::get( 'bp_contact_lname');
            
            //todo validate if bp already exists on the database
                if($bp->save()){
                    return Redirect::action('BusinessPartnerController@create')
                                ->with( 'notice', Lang::get('strings.bp_created'));
                }
            
        }
        else {
            
            return Redirect::action('BusinessPartnerController@create')
                            ->withInput(Input::all())
                            ->with( 'errors', $filter->messages() );
        }
    }
    
    public function create2()
    {
        return View::make('forms.bp_create_ajax');
    }
    
    public function listrecords()
    {
        //$partner = BusinessPartner::select('bp_id','bp_name')->get();
       
        return View::make('forms.bp_list');//->with('partners',$partner);
        
    }
    
     public function popTable(){
    $vouchers = DB::table('business_partners')->select('business_partners.bp_name','business_partners.bp_loc_building','business_partners.bp_loc_city');
        //return Datatables::of($vouchers)->add_column('operations','<a href="{{ route("modifyVoucher", $voucher_number) }}"><i class="fa fa-pencil-square fa-lg"></i></a>')->make();
    
        return Datatables::of($vouchers)->add_column('operations','<a href="{{ route("modifyBP", $bp_name) }}" data-toggle="modal" data-target="#edit_modal"><i class="fa fa-pencil-square fa-lg"></i></a>')->make();
        //return Datatables::of($vouchers)->make();
    
     }
     
     public function modify($bp_name){
        $attributes = array('bp_name','bp_contact_fname','bp_contact_lname','bp_loc_building',
                                'bp_loc_street', 'bp_loc_city', 'bp_loc_country');
        $partner = BusinessPartner::where('bp_name', '=', $bp_name)->first()->toArray();
        //var_dump($partner);
        //$partner = BusinessPartner::find($bp_id)->toArray();
        return View::make('forms.bp_modify_ajax')->with('info', $partner);
        
    }
    
    public function update(){
        $response = array('status' => NULL, 'msg'=> NULL , 'error' => NULL , 'flag' => NULL);
        $monitor_flag = NULL;
        if (Request::ajax())
        {
           // $partner = BusinessPartner::select('bp_id','bp_name')->get();
            $filter = BusinessPartner::validate(Input::all(),1);
            //$record = $this->prepareRecord(Input::except('particular','amount'));
            //$particulars = $this->prepareKeysfromDB(Input::all());//only('particular', 'amount'));
            $v = BusinessPartner::where('bp_name', '=', Input::get('bp_name'))->first();//BusinessPartner::find(Input::get('bp_name'));
            //$v = BusinessPartner::find(Input::get('bp_name'));
            if($filter->passes()){
                //$particulars = $this->prepareKeysfromDB(Input::all());
                
                $v->bp_name = Input::get('bp_name');
                $v->bp_contact_fname = Input::get('bp_contact_fname');
                $v->bp_contact_lname = Input::get('bp_contact_lname');
                $v->bp_loc_building = Input::get('bp_loc_building');
                $v->bp_loc_street = Input::get('bp_loc_street');
                $v->bp_loc_city = Input::get('bp_loc_city');
                $v->bp_loc_country = Input::get('bp_loc_country');
                if(count($v->getDirty()) > 0) /* avoiding resubmission of same content */
                {
                    $v->save();
                    //echo 'Post is updated!';
                    //return Redirect::back()->with('success', 'Post is updated!');
                    $message = "Changes Committed, ";
                    $monitor_flag = 1;
                }
                else{
                    $message = "No Changes Made, ";
                    $monitor_flag = 0;
                }
                    //$message = "No Changes Made, ";
                
                
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
    }
    
    public function saves(){
        $response = array('status' => NULL, 'msg'=> NULL , 'error' => NULL , 'flag' => NULL);
        //$monitor_flag = NULL;
        if (Request::ajax())
        {
            $filter = BusinessPartner::validate(Input::all(),0);
            
            if($filter->passes()) {
            
                $partner = new BusinessPartner;

                $partner->bp_name = Input::get('bp_name');
                $partner->bp_contact_fname = Input::get('bp_contact_fname');
                $partner->bp_contact_lname = Input::get('bp_contact_lname');
                $partner->bp_loc_building = Input::get('bp_loc_building');
                $partner->bp_loc_street = Input::get('bp_loc_street');
                $partner->bp_loc_city = Input::get('bp_loc_city');
                $partner->bp_loc_country = Input::get('bp_loc_country');

                if($partner->save()){
                   $response['status'] = "success";
                   $response['msg'] = "Record Saved!";
                   $response['flag'] = 1;
                }
            }
            else{
                $response['status'] = "success1";
                $response['msg'] = "validation error";
                $response['flag'] = 0;
                $response['error'] = $filter->messages()->toJson();
            }
        }
        
        return Response::json( $response ); 
    }
}
