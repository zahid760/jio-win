<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\AccountDetail;
use Auth;

class SettingController extends Controller
{
    public function account_detail()
    {
        $data = AccountDetail::where('created_by', Auth::user()->id)->get()->first();
        return view('admin.setting.account_detail', compact('data'));
    }

    public function account_detail_store(Request $request){
        try{
            $request->validate([
                'account_number' => ['nullable', 'string'],
                'account_holder' => ['nullable', 'string'],
                'bank_name' => ['nullable', 'string'],
                'ifsc' => ['nullable', 'string'],
                'upi' => ['nullable', 'string'],
                'upi_account_holder' => ['nullable', 'string'],
                'upi_bank_name' => ['nullable', 'string'],
                'qr_upi' => ['nullable', 'string'],
                'qr_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp'],
            ]);

            $id = $request->account_id;
            if($request->hasFile('qr_photo')) {
                $directory = 'assets/qrimages'; // Define the folder inside 'public'
                
                if (!File::exists(public_path($directory))) {
                    File::makeDirectory(public_path($directory), 0777, true, true);
                }
                $type = $request->file('qr_photo')->getClientOriginalExtension();
                $imageName = 'qr_'.time().'.'.$type;
                $request->file('qr_photo')->move(public_path($directory), $imageName);
                $request->merge(['qr_image' => $directory . '/' . $imageName]);
            }
            
            if(empty($id)){
                $request->merge(['created_by' => Auth::id()]);
                $data = $request->all();                
                $account_detail = AccountDetail::create($data);

                if($account_detail){
                    return response()->json(['status'=>'success',  'message' => 'Account saved successfully.'], 200);
                }
            }
            else{
                $request->merge(['updated_by' => Auth::id()]);
                $data = $request->all();
                $account_detail = AccountDetail::find($id);
                $account_detail->update($data);

                if($account_detail){
                    return response()->json(['status'=>'success',  'message' => 'Account saved successfully.'], 200);
                }
            }
        }catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json(['message'=>$failures]);
        }
    }
}
