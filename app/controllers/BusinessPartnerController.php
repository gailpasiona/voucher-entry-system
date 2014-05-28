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
}
