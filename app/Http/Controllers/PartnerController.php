<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Partners;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Support\Str;
class PartnerController extends Controller
{

    public $data;
    public function __construct()
    {
        $this->data['countries'] = Country::orderBy('name','asc')->get();
    }
    public function index()
    {
        $partners=Partners::paginate(10);
        return view('partners.index',compact('partners'));
    }
    public function create()
    {
        return view('partners.create' , $this->data);
    }
    public function store(Request $request)
    {
        $data=array('name'=>$request->name,'terminate_url'=>$request->terminate_url,'complete_url'=>$request->complete_url,'quotafull_url'=>$request->quotafull_url,'latter'=>$request->latter,'gst_number'=>$request->gst_number,'address'=>$request->address,'gst_number'=>$request->gst_number);
        if($partner=Partners::create($data))
        {
            Address::create(['partner_id'=>$partner->id,'address'=>$request->address,'city'=>$request->city,'state'=>$request->state,'country_id'=>$request->country,'pincode'=>$request->pincode]);
            if($request->ajax())
            {
                return response()->json(['success'=>true,'message'=>'Partner successfully added']);
            }
            return redirect('partners')->with(['message'=>'Partner successfully added.','class'=>'success']);
        }
        else
        {
            if($request->ajax())
            {
                return response()->json(['success'=>false,'message'=>'Opps something went wrong']);
            }
            return redirect('partners')->with(['message'=>'Opps something went wrong.','class'=>'danger']);
        }
    }
    public function show($id)
    {
        $partner=Partners::where('id',$id)->first();
        $address=Address::where('partner_id',$id)->first();
        return view('partners.edit',compact('partner','address'),  $this->data);
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $data=array('name'=>$request->name,'terminate_url'=>$request->terminate_url,'complete_url'=>$request->complete_url,'quotafull_url'=>$request->quotafull_url,'latter'=>$request->latter,'gst_number'=>$request->gst_number);
        if(Partners::where('id',$id)->update($data))
        {
            Address::updateOrCreate(['partner_id'=>$id],['address'=>$request->address,'city'=>$request->city,'state'=>$request->state,'country_id'=>$request->country,'pincode'=>$request->pincode]);
            return redirect('partners');
        }
        else
        {

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Partners::where('id',$id)->delete())
        {
            return response()->json(['success'=>true,'message'=>'Partner successfully deleted.']);
        }
    }
    public function partnerId()
    {
        do {
           $id = Str::random( 20 );
        } while ( Partners::where( 'id', $id )->exists() );
        return $id;
    }
}
