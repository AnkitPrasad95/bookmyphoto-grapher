<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\admin;
use App\Models\Category;
use App\Models\City;
use App\Models\Coupons;
use App\Models\User;
use App\Models\Banner;
use App\Models\Slider;
use App\Models\Subscribe;
use App\Models\ProviderType;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Booking;
use App\Models\GalleryImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use File;


class AdminController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function home(Request $request)
    {
        $total_categories = Category::where('is_deleted',2)->count();
        $total_providers = User::where('type',2)->count();
        $total_ptypes = ProviderType::where('is_deleted',2)->count();
        $total_coupons = Coupons::where('is_deleted',2)->count();
        $total_services = Service::where('is_deleted',2)->count();
        $total_handymans = User::where('type',3)->count();
        $total_cities = City::where('is_deleted',2)->count();
        $total_bookings = Booking::where('status',3)->count();
        $today_bookings = Booking::where('status',3)->where('created_at', '>=', date('Y-m-d 00:00:00'))->count();
        $total_revenue11 = Booking::select(DB::raw('SUM(total_amt) as total_amt'))->where('status',3)->get();
        $total_revenue=$total_revenue11[0]->total_amt;
        $today_revenue1 = Booking::select(DB::raw('SUM(total_amt) as total_amt'))->where('status',3)->where('created_at', '>=', date('Y-m-d 00:00:00'))->get();
        if(!empty($today_revenue1) && $today_revenue1[0]->total_amt !=''){
            $today_revenue=$today_revenue1[0]->total_amt;
        }else{
            $today_revenue=0;
        }
                
        if(Auth::user()->type == 2){
            $total_services = Service::where('provider_id',Auth::user()->id)->where('is_deleted',2)->count();
            $total_handymans = User::where('provider_id',Auth::user()->id)->where('type',3)->count();
            $total_bookings = Booking::where('provider_id',Auth::user()->id)->where('status',3)->count();
            $today_bookings = Booking::where('provider_id',Auth::user()->id)->where('status',3)->where('created_at', '>=', date('Y-m-d 00:00:00'))->count();
            $total_revenue1 = Booking::select(DB::raw('SUM(total_amt) as total_amt'))->where('provider_id',Auth::user()->id)->where('status',3)->get();
            $total_revenue=$total_revenue1[0]->total_amt;
            $today_revenue1 = Booking::select(DB::raw('SUM(total_amt) as total_amt'))->where('provider_id',Auth::user()->id)->where('status',3)->where('created_at', '>=', date('Y-m-d 00:00:00'))->get();
            if($today_revenue1 !=''){
                 $today_revenue=$today_revenue1[0]->total_amt;
            }else{
                $today_revenue=0;
            }
        }

        // Charts......

            //----------- USERS_CHART_START ----------
            $user_years = User::select(DB::raw("YEAR(created_at) as years"))->where('type','!=',1)->orderByDesc('created_at')->groupBy(DB::raw("YEAR(created_at)"))->get();
            $months = User::select(DB::raw("MONTHNAME(created_at) as month_name"),DB::raw("YEAR(created_at) as years"))
                            ->groupBy(DB::raw("YEAR(created_at)"),DB::raw("MONTHNAME(created_at)"))
                            ->orderBy('created_at');
            if($request->has('year') && $request->year != ""){
                $months = $months->where(DB::raw("YEAR(created_at)"),'=',$request->year);
            }else{
                $months = $months->where(DB::raw("YEAR(created_at)"),'=',date('Y'));
            }
            $months = $months->get();
            foreach ($months as $mname) {
                if($request->has('year') && $request->year != ""){
                    $year = $request->year;
                }else{
                    $year = date('Y');
                }
                $providers = User::select(DB::raw("MONTHNAME(created_at) as month_name"),
                                    DB::raw('(case when COUNT(id) is null then 0 else COUNT(id) end) as total_rest'))
                            ->groupBy(DB::raw("YEAR(created_at)"),DB::raw("MONTHNAME(created_at)"))
                            ->where('type','=',2)
                            ->where('is_available',1)
                            ->where(DB::raw("MONTHNAME(created_at)"),'=',$mname->month_name)
                            ->where(DB::raw("YEAR(created_at)"),'=',$year)
                            ->orderBy('created_at')
                            ->get();
                if(count($providers)>0){
                    $provider_cnt[] = $providers[0]->total_rest;
                }else{
                    $provider_cnt[] = 0;
                }
                $handymans = User::select(DB::raw("MONTHNAME(created_at) as month_name"),
                                    DB::raw('(case when COUNT(id) is null then 0 else COUNT(id) end) as total_driver'))
                            ->groupBy(DB::raw("YEAR(created_at)"),DB::raw("MONTHNAME(created_at)"))
                            ->where('type','=',3)
                            ->where(DB::raw("MONTHNAME(created_at)"),'=',$mname->month_name)
                            ->where(DB::raw("YEAR(created_at)"),'=',$year)
                            ->where('is_available',1)
                            ->orderBy('created_at')
                            ->get();
                if(count($handymans)>0){
                    $handyman_cnt[] = $handymans[0]->total_driver;
                }else{
                    $handyman_cnt[] = 0;
                }
                $user = User::select(DB::raw("MONTHNAME(created_at) as month_name"),
                                    DB::raw('(case when COUNT(id) is null then 0 else COUNT(id) end) as total_users'))
                            ->groupBy(DB::raw("YEAR(created_at)"),DB::raw("MONTHNAME(created_at)"))
                            ->where('type','=',4)
                            ->where('is_available',1)
                            ->where(DB::raw("MONTHNAME(created_at)"),'=',$mname->month_name)
                            ->where(DB::raw("YEAR(created_at)"),'=',$year)
                            ->orderBy('created_at')
                            ->get();
                if(count($user)>0){
                    $users_cnt[] = $user[0]->total_users;
                }else{
                    $users_cnt[] = 0;
                }
            }

            $chart_users[] = ['Month','Providers','Handymans','Customers'];
            $i = 0;
            foreach ($months as $key => $value) {
                $chart_users[++$key] = [$value->month_name, @$provider_cnt[$i] ,@$handyman_cnt[$i] ,@$users_cnt[$i] ];
                $i+=1;
            }
            //----------- USERS_CHART_END ----------


            $providers = User::select('id','name')->where('type',2)->where('is_available',1)->orderByDesc('id')->get();
            if(Auth::user()->type == 2){
                $provider_id = Auth::user()->id;
            }else{
                if($request->has('provider') && $request->provider != ""){
                    $provider_id = $request->provider;
                }else{
                    $pdata = User::select('id')->where('type',2)->where('is_available',1)->orderByDesc('id')->first();
                    $provider_id = @$pdata->id;
                }
            }

            //----------- Bookings Chart START ----------
            $booking_years = Booking::select(DB::raw("YEAR(created_at) as year"))->orderByDesc('created_at')->groupBy(DB::raw("YEAR(created_at)"))->get();
            $bookings = Booking::select(DB::raw("MONTHNAME(created_at) as month_name"),DB::raw("YEAR(created_at) as years"),DB::raw("COUNT(id) as total_booking"))
                            ->groupBy(DB::raw("YEAR(created_at)"),DB::raw("MONTHNAME(created_at)"))
                            ->orderBy('created_at')
                            ->where('provider_id',$provider_id);
            if($request->has('booking_year') && $request->booking_year != ""){
                $bookings = $bookings->where(DB::raw("YEAR(created_at)"),'=',$request->booking_year);
            }else{
                $bookings = $bookings->where(DB::raw("YEAR(created_at)"),'=',date('Y'));
            }
            $bookings = $bookings->get();

            $booking_cnt[] = ['Month','Bookings'];
            foreach ($bookings as $key => $value) {
                $booking_cnt[++$key] = [$value->month_name, (int)$value->total_booking];
            }
            //----------- Bookings Chart END ----------


            $services = Service::select('id','name')->where('provider_id',$provider_id)->where('is_available',1)->where('is_deleted',2)->orderByDesc('id')->get();
            if($request->has('service') && $request->service != ""){
                $service_id = $request->service;
            }else{
                $service_id = 1;
                if(count($services)>0){
                    $service_id = $services[0]->id;
                }
            }
            //----------- Service Chart START ----------
            $service_years = Booking::select(DB::raw("YEAR(created_at) as years"))->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('id')->get();
            $service_orders_cnt = Booking::select(DB::raw("MONTHNAME(created_at) as month_name"),DB::raw("YEAR(created_at) as years"),DB::raw("COUNT(id) as total_booking"))
                            ->groupBy(DB::raw("YEAR(created_at)"),DB::raw("MONTHNAME(created_at)"))
                            ->where('service_id', $service_id);
            if($request->has('item_year') && $request->item_year != ""){
                $service_orders_cnt = $service_orders_cnt->where(DB::raw("YEAR(created_at)"),'=',$request->item_year);
            }else{
                $service_orders_cnt = $service_orders_cnt->where(DB::raw("YEAR(created_at)"),'=',date('Y'));
            }
            $service_orders_cnt = $service_orders_cnt->orderByDesc('id')->get();
            $service_orders_countt[] = ['Month','Bookings'];
            if(count($services)>0){
                foreach ($service_orders_cnt as $key => $value) {
                    $service_orders_countt[++$key] = [$value->month_name, (int)$value->total_booking];
                }
            }
            //----------- Service Chart END ----------


        // Charts End......
        if($request->ajax())
        {
            return response()->json(['users_count'=>$chart_users,'bookings_count'=>$booking_cnt,'service_orders_count'=>$service_orders_countt],200);
        }else{

            $user_chart_data = json_encode($chart_users);
            $rest_chart_data = json_encode($booking_cnt);
            $service_chart_data = json_encode($service_orders_countt);
            return view('admin.adashboard',compact('total_categories','total_services','total_providers','total_ptypes','total_coupons','total_handymans','total_cities','user_years','user_chart_data','providers','booking_years','rest_chart_data','services','service_years','service_chart_data','total_bookings','today_bookings','total_revenue','today_revenue'));
        }
    }
    public function home_page_settings()
    {
        return view('setting.home_page_settings');
    }
    public function subscribers()
    {
        $subscribers = Subscribe::orderByDesc('id')->paginate(10);
        return view('admin.subscribers',compact('subscribers'));
    }
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(),
            [   'sub_email' => 'required'],[
                'sub_email.required' => trans('messages.enter_email')]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $sub = new Subscribe();
            $sub->email = $request->sub_email;
            $sub->save();
            return redirect()->back()->with('success',trans('messages.success'));
        }
    }
}
