<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Partners;
use App\Address;
use DB;
use Str;
class AddressController extends Controller
{
    public function index()
    {
        $address=Address::all();
        return $address;
    }
    public function create($id)
    {
        $partner=Partners::where('id',$id)->first();
        if($partner)
        {
            return view('address.create');
        }
        return redirect('/partners');
    }
    public function store(Request $request)
    {
        $data=array('address'=>$request->address,'state'=>$request->state,'city'=>$request->city,'pincode'=>$request->pincode,'country'=>$request->country);
        if(Address::create($data))
        {
            if($request->ajax())
            {
                return response()->json(['success'=>true,'message'=>'Partner successfully added']);
            }
            return response()->json(['success'=>false,'message'=>'Opps something went wrong']);
        }
        else
        {
            return response()->json(['success'=>false,'message'=>'Opps something went wrong']);
        }
    }
    public function show($id)
    {
        $partner=Partners::where('id',$id)->first();
        return view('partners.edit',compact('partner'));
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $data=array('name'=>$request->name,'terminate_url'=>$request->terminate_url,'complete_url'=>$request->complete_url,'quotafull_url'=>$request->quotafull_url,'completes'=>$request->complete,'address'=>$request->address,'gst_number'=>$request->gst_number);
        if(Partners::where('id',$id)->update($data))
        {
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
        //
    }
    public function partnerId()
    {
        do {
           $id = Str::random( 20 );
        } while ( DB::table( 'partners' )->where( 'id', $id )->exists() );
        return $id;
    }
}
