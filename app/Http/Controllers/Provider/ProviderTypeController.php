<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\ProviderType;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class ProviderTypeController extends Controller
{
    function index(Request $request)
    {
        if($request->ajax())
        {
            $query = $request->get('query');
            if($query != ""){
                $providertypedata = ProviderType::where('name', 'like', '%'.$query.'%')->where('is_deleted',2)->orderByDesc('id')->paginate(10);
            }else{
                $providertypedata = ProviderType::where('is_deleted',2)->orderByDesc('id')->paginate(10);
            }
            return view('provider.provider_types.ptype_table', compact('providertypedata'))->render();
        }else{
            $providertypedata = ProviderType::where('is_deleted',2)->orderByDesc('id')->paginate(10);
            return view('provider.provider_types.index',compact('providertypedata'));
        }
    }
    function add()
    {
        return view('provider.provider_types.add');
    }
    function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'name' => 'required',
                'commission' => 'required|numeric'
            ],[
                "name.required"=>trans('messages.enter_provider_type'),
                "commission.required"=>trans('messages.enter_commission'),
                "commission.numeric"=>trans('messages.enter_numbers_only')
            ]);
        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput();

        }else{

            $ptype = new ProviderType();
            $ptype->name = $request->name;
            $ptype->commission = $request->commission;
            $ptype->is_available = 1;
            $ptype->is_deleted = 2;
            $ptype->save();

            return redirect(route('provider_types'))->with('success',trans('messages.provider_type_added'));
        }   
    }
    public function destroy(Request $request)
    {
        $ptype = ProviderType::where('id',$request->id)->update(['is_deleted'=>1]);

        User::where('provider_type',$request->id)->update(['is_available'=>2]);

        if($ptype) {
            return 1;
        } else {
            return 0;
        }                                        
    }
    public function status(Request $request)
    {
        $success = ProviderType::where('id',$request->id)->update(['is_available'=>$request->status]);

        User::where('provider_type',$request->id)->update(['is_available'=>$request->status]);

        if($success) {
            return 1;
        } else {
            return 0;
        }                                        
    }
    public function show($id)
    {
        $updateprovidertypedata = ProviderType::find($id);
        return view('provider.provider_types.show',compact('updateprovidertypedata'));
    }
    public function edit(Request $request,$id)
    {   
        $validator = Validator::make($request->all(),[
                'name' => 'require',
                'commission' => 'required|numeric'
            ],[
                "name.required"=>trans('messages.enter_provider_type'),
                "commission.required"=>trans('messages.enter_commission'),
                "commission.numeric"=>trans('messages.enter_numbers_only')
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{
            if($request->is_available){
                $available = 1;
            }else{
                $available = 2;
            }
            ProviderType::where('id', $id)
                        ->update([
                            'name' => $request->name,
                            'commission' => $request->commission,
                            'is_available' => $available
                        ]);
            return redirect()->route('provider_types')->with('success',trans('messages.provider_type_updated'));
        }
    }
}
