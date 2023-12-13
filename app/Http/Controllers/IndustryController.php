<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndustryController extends Controller
{
    public function index()
    {
        $industries = Industry::orderBy('name')->paginate(10);
        return view('industry.index', compact('industries'));
    }
    public function create()
    {
        return view('industry.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $industry = Industry::create(['name' => $request->name, 'status' => $request->status]);
        // return redirect('/industries');
        return response()->json(['success' => 'Industry created successfully.']);
    }
    public function edit($id)
    {
        $industry = Industry::where('id', $id)->orderBy('name')->first();
        return view('industry.edit', compact('industry'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
            // return redirect('industry/edit/' . $request->id)->with('error', [
            //     'errors' => $validator->errors()->all()
            // ]);
        }
        $response = Industry::where('id', $request->id)->update(['name' => $request->name, 'status' => $request->status]);
        if ($response) {
            return response()->json(['success' => 'Industry updated successfully.']);

            return redirect('/industries');
        } else {
            return response()->json(['error' => 'Something went wrong.']);

            // return redirect('/industries/edit/' . $request->id);
        }
    }
    public function delete($id)
    {
        $response = Industry::where('id', $id)->delete();
        if ($response) {
            return response()->json(['success' => true, 'message' => 'Industrie deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something wrong']);
    }
}
