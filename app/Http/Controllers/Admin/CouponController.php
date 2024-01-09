<?php



namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;

use App\Models\Coupons;

use App\Models\Service;
use App\Models\Provider;
use App\Models\Handyman;
use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Response;

use Purifier;

use Helper;



class CouponController extends Controller

{

    public function index(Request $request)

    {

        if($request->ajax())

        {

            $output = '';

            $query1 = $request->get('query');

            if($query1 != '')

            {

                //$couponsdata = Coupons::join('services','coupons.service_id','services.id')
                $couponsdata = Coupons::select('coupons.*', 'users.name as photographer_name', 'services.name as service_name', 'users.image as photographer_image')
                ->leftJoin('users', 'users.id', 'coupons.photographer_id')
                ->leftJoin('services', 'services.id', 'coupons.service_id')
                ->where('coupons.is_deleted', 2);
            
                if (auth()->check() && auth()->user()->type == 2) {
                
                    $couponsdata->where('coupons.studio_id', auth()->user()->id);
                }

                    $couponsdata->where(function ($query) use($query1){

                        $query->where('coupons.code', 'like','%'.$query1.'%')

                            ->orWhere('coupons.discount', 'like','%'.$query1.'%')

                            ->orWhere('coupons.start_date', 'like','%'.$query1.'%')

                            ->orWhere('coupons.expire_date', 'like','%'.$query1.'%')

                            ->orWhere('coupons.description', 'like','%'.$query1.'%')

                            ->orWhere('services.name', 'like','%'.$query1.'%');

                        });
                    if (auth()->check() && auth()->user()->type == 2) {
                        //echo auth()->user()->id;
                        $couponsdata->where('coupons.studio_id', auth()->user()->id);
                    }    

                    $couponsdata = $couponsdata->orderByDesc('coupons.id')

                    ->paginate(10);

            }else{

                $couponsdata = Coupons::select('coupons.*','services.name as service_name', 'users.name')
                ->leftjoin('services','coupons.service_id','services.id')
                ->leftjoin('users','users.id','coupons.photographer_id');
                if (auth()->check() && auth()->user()->type == 2) {
                    //echo auth()->user()->id;
                    $couponsdata->where('coupons.studio_id', auth()->user()->id);
                }

                $couponsdata = $couponsdata->orderByDesc('coupons.id')
                ->paginate(10);

            }
            //dd($couponsdata->toArray());
            return view('service.coupon.coupon_table', compact('couponsdata'))->render();

        }else{
            //echo auth()->user()->type;
            $couponsdata = Coupons::select('coupons.*', 'users.name as photographer_name', 'users.image as photographer_image')
                ->leftJoin('users', 'users.id', 'coupons.photographer_id')
                ->where('is_deleted', 2);
            
            if (auth()->check() && auth()->user()->type == 2) {
            
                $couponsdata->where('coupons.studio_id', auth()->user()->id);
            }
            
            $couponsdata = $couponsdata->orderBy('id', 'DESC')
            //->get();
            ->paginate(10);
            //dd($couponsdata);
            return view('service.coupon.index', compact('couponsdata'));
    

        }

        

    }

    public function add()
    {
        $servicedata = Service::where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();
        return view('service.coupon.add',compact('servicedata'));
    }

    public function store(Request $request)

    {
        //dd($request->input());

        $validator = Validator::make($request->all(),[

                'code' => 'required',
                'coupon_type' => 'required',
                

                //'service_id' => 'required',

                'discount' => 'required|numeric',

                'discount_type' => 'required',

                'start_date' => 'required|date',

                'expire_date' => 'required|date|after:start_date',

                'description' => 'required'

            ],[ 

                'code.required' => trans('messages.enter_coupon'),
                
                'coupon_type.required' => trans('messages.select_coupon_type'),

                //'service_id.required' => trans('messages.select_service'),

                'discount.required' => trans('messages.enter_discount'),

                'discount.numeric' => trans('messages.enter_discount_numbers'),

                'discount_type.required' => trans('messages.select_discount_type'),

                'start_date.required' => trans('messages.start_date'),

                'start_date.date' => trans('messages.valid_date'),

                'expire_date.required' => trans('messages.expire_date'),

                'expire_date.date' => trans('messages.valid_date'),

                'expire_date.after' => trans('messages.after_start_date'),

                'description.required' => trans('messages.enter_description')

            ]);

        if ($validator->fails()) {



            return redirect()->back()->withErrors($validator)->withInput();



        }else{

            $description = strip_tags(Purifier::clean($request->description));

            $Coupon = new Coupons();

            $Coupon->code = $request->code;
            $Coupon->type = $request->coupon_type;
             
            if($request->coupon_type == 'service') {
                $Coupon->service_id = $request->service_id;
                //$Coupon->photographer_id = NULL;
            } elseif($request->coupon_type == 'photographer') {
               $Coupon->photographer_id = $request->service_id;
               //$Coupon->service_id = '';
            } elseif($request->coupon_type == 'all') {
                $Coupon->photographer_id = 'all';
                $Coupon->service_id = 'all';
            }
            
           
            $Coupon->studio_id = !empty($userId = auth()->id()) ? $userId = auth()->id() : NULL;
            
            $Coupon->discount = $request->discount;

            $Coupon->discount_type = $request->discount_type;

            $Coupon->start_date = $request->start_date;

            $Coupon->expire_date = $request->expire_date;

            $Coupon->description = $description;

            $Coupon->is_available = 1;

            $Coupon->is_deleted = 2;

            $Coupon->save();



            return redirect(route('coupons'))->with('success',trans('messages.coupon_added'));

        }

    }

    public function status(Request $request)

    {

        $success = Coupons::where('id',$request->id)->update(['is_available'=>$request->status]);

        if($success) {

            return 1;

        } else {

            return 0;

        }                                 

    }

    public function destroy(Request $request)

    {

        $rec = Coupons::where('id',$request->id)->update(['is_deleted'=>1]);

        if($rec) {

            return 1;

        } else {

            return 0;

        }                                        

    }

    public function show($id)

    {

        $coupondata = Coupons::find($id);
        //dd($coupondata);
        // echo "<pre>";
        // print_r($coupondata->toArray());
        // echo "</pre>";
        if(Auth::user()->type == 1){


            // if($coupondata->type == 'service') {
            //     $servicedata = Service::where('provider_id', $coupondata->photographer_id)->where('id','!=',$coupondata['servicename']->id)->where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();
            // } else if($coupondata->type == 'photographer') {
            //     $servicedata = User::where('id', $coupondata->photographer_id)->where('is_available',1)->orderBy('id','DESC')->get();
            // } else{
            //     $servicedata = [];
            // }
            
            if($coupondata->type == 'service' && $coupondata->service_id > 0) {
                $servicedata = Service::where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();
            } else if($coupondata->type == 'photographer' && $coupondata->photographer_id > 0) {
                $servicedata = User::where('provider_id', Auth::user()->id)->where('is_available',1)->orderBy('id','DESC')->get();
            } else if($coupondata->type == 'service' && $coupondata->service_id == 0){
                $servicedata = Service::where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();
            } else if($coupondata->type == 'photographer' && $coupondata->photographer_id == 0) {
                $servicedata = User::where('provider_id', Auth::user()->id)->where('is_available',1)->orderBy('id','DESC')->get();
            } else {
                $servicedata = [];
            }
            
            //dd($servicedata);

            //$servicedata = Service::where('id','!=',$coupondata['servicename']->id)->where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();



        }elseif(Auth::user()->type == 2){

            if($coupondata->type == 'service' && $coupondata->service_id > 0) {
                $servicedata = Service::where('provider_id',Auth::user()->id)->where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();
            } else if($coupondata->type == 'photographer' && $coupondata->photographer_id > 0) {
                $servicedata = User::where('provider_id', Auth::user()->id)->where('is_available',1)->orderBy('id','DESC')->get();
            } else if($coupondata->type == 'service' && $coupondata->service_id == 0){
                $servicedata = Service::where('provider_id',Auth::user()->id)->where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();
            } else if($coupondata->type == 'photographer' && $coupondata->photographer_id == 0) {
                $servicedata = User::where('provider_id', Auth::user()->id)->where('is_available',1)->orderBy('id','DESC')->get();
            } else {
                $servicedata = [];
            }
            
            
            

        }
        //dd($servicedata);


        return view('service.coupon.show',compact('coupondata','servicedata'));

    }

    public function edit(Request $request,$id)

    {

        $validator = Validator::make($request->all(),[

                    // 'code' => 'required',

                    // 'service_id' => 'required',

                    // 'discount' => 'required|numeric',

                    // 'discount_type' => 'required',

                    'start_date' => 'required|date',

                    'expire_date' => 'required|date|after:start_date',

                    'description' => 'required'

                ],[ 

                    // 'code.required' => trans('messages.enter_coupon'),

                    // 'service_id.required' => trans('messages.select_service'),

                    // 'discount.required' => trans('messages.enter_discount'),

                    // 'discount.numeric' => trans('messages.enter_discount_numbers'),

                    // 'discount_type.required' => trans('messages.select_discount_type'),

                    'start_date.required' => trans('messages.start_date'),

                    'start_date.date' => trans('messages.valid_date'),

                    'expire_date.required' => trans('messages.expire_date'),

                    'expire_date.date' => trans('messages.valid_date'),

                    'expire_date.after' => trans('messages.after_start_date'),

                    'description.required' => trans('messages.enter_description')

                ]);

        if ($validator->fails()) {



            return redirect()->back()->withErrors($validator)->withInput();

            

        }else{

            if($request->is_available) { $available=1; }else { $available=2; }

            $description = strip_tags(Purifier::clean($request->description));
            
             
             
            //if($request->coupon_type == 'service') {
                //$Coupon->service_id = $request->service_id;
                 Coupons::where('id',$id)

                    ->update([

                        // "code" => $request->code,

                        // "service_id" => $request->service_id,

                        // "discount" => $request->discount,

                        // "discount_type" => $request->discount_type,

                        "start_date" => $request->start_date,

                        "expire_date" => $request->expire_date,

                        "description" => $description,

                        "is_available" => $available

                    ]);
                //$Coupon->photographer_id = NULL;
            //} elseif($request->coupon_type == 'photographer') {
               
               //$Coupon->service_id = '';
            //     Coupons::where('id',$id)

            //         ->update([

            //             // "code" => $request->code,

            //             // "photographer_id" => $request->service_id,

            //             // "discount" => $request->discount,

            //             // "discount_type" => $request->discount_type,

            //             "start_date" => $request->start_date,

            //             "expire_date" => $request->expire_date,

            //             "description" => $description,

            //             "is_available" => $available

            //         ]);
            // }

           



            return redirect(route('coupons'))->with('success',trans('messages.coupon_updated'));

        }

    }
    
    public function getServicePhotographer(Request $request){
        //return $request->input();
        if(!empty($request->input('selectVal'))) {
            if($request->input('selectVal') == 'service') {
                 $data = Service::select('id', 'name')->where('provider_id', auth()->user()->id)->where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();
            } 
            
         if($request->input('selectVal') == 'photographer') {
             $data = User::select('id', 'name')->where('provider_id', auth()->user()->id)->where('is_available',1)->where('type',3)->orderBy('id','ASC')->get();
            } 
         return response()->json(['data' => $data, "message" => "Data found"]);    
        } else {
         return response()->json(['data' => [], "message" => "Data not found"]); 
        }
       
        
       
        
        
    }

}

