<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use App\Models\Timing;
use App\Models\HomeSettings;
use App\Models\Rattings;
use App\Models\CMS;
use App\Models\City;
use App\Models\Banner;
use App\Models\GalleryImages;
use App\Models\BookingImages;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

$filePath = public_path('your-folder/your-file.jpg'); // Provide the path to the file you want to delete

if (File::exists($filePath)) {
    File::delete($filePath);
    // The file has been deleted
} else {
    // The file does not exist
}


class HomeController extends Controller
{
    public function index(Request $request)
    {
         $searchcategorydata = Category::select('id','name','slug','image')
            ->where('is_featured',1)->where('is_available',1)->where('is_deleted',2)
            ->orderByDesc('id')->get();
        if (isset($_COOKIE["city_name"])) {
            $city = City::select('id')->where('name',$_COOKIE['city_name'])->first();
            $categorydata = Category::select('id','name','slug','image')
                            ->where('is_featured',1)->where('is_available',1)->where('is_deleted',2)
                            ->orderByDesc('id')->take(12)->get();
                            
           
                            
            $servicedata = Service::with('rattings')
                            ->join('categories', 'services.category_id', '=', 'categories.id')
                            ->join('users', 'services.provider_id', '=', 'users.id')
                            ->select('services.id','services.name as service_name','services.slug','users.slug as user_slug','services.price','services.price_type','services.duration','services.duration_type','categories.name as category_name','categories.slug as category_slug','users.name as username','users.mobile','services.image as service_image','services.description','users.image as user_image','users.latitude','users.longitude','services.verified_flag')

                            ->where('users.city_id', 'LIKE', "%" . json_encode($city->id) . "%")
                            ->where('services.is_available',1)->where('services.is_deleted',2)
                            ->orderByDesc('services.id')->take(10)->get();
            $providerdata = User::with('rattings')
                            ->Leftjoin('cities', 'users.city_id', '=', 'cities.id')
                            ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
                            ->select('users.id','users.name as provider_name','users.email','users.mobile','users.about','users.slug',
                                'users.address','cities.name as city_name','provider_types.name as provider_type','users.image as provider_image','users.latitude','users.longitude', 'users.verified_flag','users.radius', 'users.available_status')
                                
                            ->where('users.city_id', 'LIKE', "%" . json_encode($city->id) . "%")
                            ->where('users.type',2)->where('users.is_available',1)
                            ->groupBy('users.id')->orderByDesc('users.id')->take(10)->get();
                            $collection = collect($providerdata);
                            $providerdata = $collection->sortByDesc('verified_flag')->all();
            
           

            $howworkdata = HomeSettings::first();

            $banners = Banner::with('categoryname','servicename')
                        ->leftJoin('services','banners.service_id','services.id')
                        ->leftJoin('users','services.provider_id','users.id')
                        ->leftJoin('categories','categories.id','banners.category_id')
                        ->select('banners.id','banners.service_id','banners.category_id','users.city_id','banners.image','categories.slug as category_slug','services.slug as service_slug','services.name as sname')
                        ->orderByDesc('id')
                        ->get();
            $bannerdata = array();
            foreach($banners as $bdata){
                if($bdata->service_id != ""){
                   if($bdata->city_id == @$city->id){
                      $bannerdata[] = array(
                         'id' => $bdata->id,
                         'category_id' => $bdata->category_id,
                         'service_id' => $bdata->service_id,
                         'image' => $bdata->image,
                         'category_slug' => $bdata->category_slug,
                         'service_slug' => $bdata->service_slug,
                      );
                   }
                }else{
                   $bannerdata[] = array(
                      'id' => $bdata->id,
                      'category_id' => $bdata->category_id,
                      'service_id' => $bdata->service_id,
                      'image' => $bdata->image,
                      'category_slug' => $bdata->category_slug,
                      'service_slug' => $bdata->service_slug,
                   );
                }
            }
        }else{
            $categorydata = "";
            $servicedata = "";
            $providerdata = "";
            $howworkdata = "";
            $bannerdata = "";
        }
        //echo "<pre>";
        //print_r($servicedata);
        //print_r($providerdata);
        //echo "<pre>";
        //dd($searchcategorydata);
        //die;
        return view("front.home",compact('searchcategorydata', 'categorydata','servicedata','providerdata','howworkdata','bannerdata'));
    }

    public function categories()
    {
        if (isset($_COOKIE["city_name"])) {
            $categorydata = Category::select('id','name','slug','image')->where('is_available',1)->where('is_deleted',2)->orderByDesc('id')->get();
        }else{
            $categorydata = "";
        }
        return view("front.categories",compact('categorydata'));
    }
    
    public function providers()
    {
        if(isset($_COOKIE["city_name"])){
            $city = City::select('id')->where('name',$_COOKIE['city_name'])->first();
            
            $providerdata = User::with('rattings')
                        //->join('cities', 'users.city_id', '=', 'cities.id')
                        ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
                        ->select('users.id','users.name as provider_name','users.email','users.mobile','users.about','users.slug',
                            //'users.address','cities.name as city_name','provider_types.name as provider_type','users.image as provider_image','users.latitude','users.longitude')
                            'users.address','provider_types.name as provider_type','users.image as provider_image','users.latitude','users.longitude')
                        //->where('users.city_id',@$city->id)
                        //->whereIn(json_decode('users.city_id'), [$city->id])
                         ->where('users.city_id', 'LIKE', "%" . json_encode($city->id) . "%")
                        ->where('users.type',2)->where('users.is_available',1)
                        ->paginate(10);
        }else{
            $providerdata = "";
        }
        return view("front.providers",compact('providerdata'));
    }
    
    public function provider_details($provider)
    {
        if(isset($_COOKIE["city_name"])){
            
            $city = City::select('id')->where('name',$_COOKIE['city_name'])->first();
            
            $providerdata = User::select('users.id','users.name as provider_name','users.address','users.email','users.mobile','users.about','users.slug','users.image as provider_image','users.latitude','users.longitude')
                //->where('users.city_id',@$city->id)
                ->where('users.city_id','LIKE',"%" . @$city->id . "%")
                //->whereIn(json_decode('users.city_id'), [$city->id])
                ->where('users.type',2)->where('users.is_available',1)->where('users.slug',$provider)
                ->first();
            if(empty($providerdata)){
                return redirect(route('home'));
            }else{
                $timingdata = Timing::select('day','open_time','close_time','is_always_close')->where('provider_id',$providerdata->id)->get();
            }
        }else{
            $providerdata = "";
            $timingdata = "";
        }
        return view("front.provider_details",compact('providerdata','timingdata'));
    }
    
    public function provider_rattings($provider)
    {
        if(isset($_COOKIE["city_name"])){
            
            $city = City::select('id')->where('name',$_COOKIE['city_name'])->first();
            
            $providerdata = User::select('users.id','users.name as provider_name','users.slug','users.image as provider_image')
               // ->where('users.city_id',@$city->id)
                ->where('users.city_id','LIKE',"%" . @$city->id . "%")
                //->whereIn(json_decode('users.city_id'), [$city->id])
                ->where('users.type',2)->where('users.is_available',1)->where('users.slug',$provider)
                ->first();
            if(empty($providerdata)){
                return redirect(route('home'));
            }else{
                $providerrattingsdata = Rattings::join('users', 'rattings.user_id', '=', 'users.id')
                    ->select('rattings.id','rattings.ratting','rattings.comment','users.name as user_name','users.image as user_image',
                       DB::raw('DATE(rattings.created_at) AS date'))
                    ->where('rattings.provider_id',$providerdata->id)
                    ->paginate(10);
            }
        }else{
            $providerdata = "";
            $providerrattingsdata = "";
        }
        return view("front.provider_rattings",compact('providerdata','providerrattingsdata'));
    }
    
    public function provider_services($provider)
    {
         $citiesData = array();
        if(isset($_COOKIE["city_name"])){
            
            $city = City::select('id', 'name')->where('name',$_COOKIE['city_name'])->first();
            
            $providerdata = User::select('users.id','users.name as provider_name','users.slug','users.image as provider_image','users.latitude','users.longitude','users.verified_flag','users.radius','users.about', 'users.city_id', 'users.mobile', 'users.email', 'users.address')
                
                ->where('users.city_id','LIKE',"%" . @$city->id . "%")
                
                ->where('users.type',2)->where('users.is_available',1)->where('users.slug',$provider)
                ->first();
                //dd($providerdata);
            $timingdata = Timing::select('day','open_time','close_time','is_always_close')->where('provider_id',$providerdata->id)->get();
            $cities = City::select('name','image','is_available')->whereIn('id', explode(",",$providerdata->city_id))->get();
            $services = Service::select('name','slug')->where('provider_id', $providerdata->provider_id)->get();
            
           $providerrattingsdata = Rattings::Leftjoin('users', 'rattings.user_id', '=', 'users.id')
                    ->select('rattings.id','rattings.ratting','rattings.comment','users.name as user_name','users.image as user_image',
                       DB::raw('DATE(rattings.created_at) AS date'))
                    ->where('rattings.provider_id',$providerdata->id)
                    //->toSql();
                    ->paginate(10);
            //dd($providerrattingsdata);        
            $provideraverageratting = Rattings::select(DB::raw('ROUND(avg(rattings.ratting),2) as avg_ratting'))
                    ->where('provider_id',$providerdata->id)
                    ->first();
            if(!empty($cities)) {
              
                foreach($cities as $citiesRow){
                    array_push($citiesData, $citiesRow->name);
                }
                //$citiesData = implode(",",$citiesArr);
            }
            if(empty($providerdata)){
                return redirect(route('home'));
            }else{
                $servicedata = Service::with('rattings')
                    ->join('categories', 'services.category_id', '=', 'categories.id')
                    ->join('users', 'services.provider_id', '=', 'users.id')
                    ->select('services.id','services.name as service_name','services.price','users.city_id','services.price_type','services.duration','services.duration_type','categories.name as category_name','services.slug','services.image as service_image','users.mobile as provider_mobile','users.name as username','services.description','users.image as user_image','users.slug as user_slug','users.latitude','users.longitude','services.verified_flag')
                    ->where('services.provider_id',$providerdata->id)
                    ->where('services.is_available',1)
                    ->where('services.is_deleted',2)
                    ->paginate(9);
            }
        }else{
            $providerdata = "";
            $servicedata = "";
            $timingdata = '';
            $services = '';
            $providerrattingsdata = '';
          
        }
        //dd($timingdata);
        return view("front.provider_services",compact('provideraverageratting', 'city', 'providerrattingsdata', 'services', 'citiesData', 'timingdata', 'servicedata','providerdata'));
    }
    
    public function category_services($category)
    {
       
        if(isset($_COOKIE["city_name"])){
            $city = City::select('id')->where('name',$_COOKIE['city_name'])->first();
            $servicedata = Service::with('rattings')
                        ->join('categories', 'services.category_id', '=', 'categories.id')
                        ->join('users', 'services.provider_id', '=', 'users.id')
                        ->select('services.id','services.name as service_name','services.price','services.price_type','services.duration','services.duration_type','categories.name as category_name','users.mobile','services.slug','services.image as service_image','services.description','users.image as user_image','users.name as username','users.slug as user_slug','services.verified_flag', 'users.latitude', 'users.longitude')
                        ->where('categories.slug',$category)
                        ->where('users.city_id','LIKE',"%" . @$city->id . "%")
                        ->where('services.is_available',1)->where('services.is_deleted',2)
                        ->orderByDesc('services.id')
                        ->paginate(12);
        }else{
            $servicedata = "";
        }
        
        return view("front.services",compact('servicedata'));
    }
    
    public function services(Request $request)
    {
        
        
        if(isset($_COOKIE["city_name"])){
            $city = City::select('id')->where('name',$_COOKIE['city_name'])->first();
           
            $servicedata = Service::with('rattings')
                        ->join('categories', 'services.category_id', '=', 'categories.id')
                        ->join('users', 'services.provider_id', '=', 'users.id')
                        ->select('services.id','services.name as service_name','services.slug','users.slug as user_slug','services.price','services.price_type','services.duration','services.duration_type','categories.name as category_name','categories.slug as category_slug','users.mobile','services.image as service_image','services.description','users.image as user_image','users.name as username','users.latitude','users.longitude','services.verified_flag')
                        ->where('users.city_id','LIKE',"%" . @$city->id . "%")
                        //->whereIn(json_decode('users.city_id'), [$city->id])
                        ->where('services.is_available',1)
                        ->where('services.is_deleted',2)
                        ->orderByDesc('services.id')
                        ->paginate(12);
        }else{
            $servicedata = "";
        }
        return view("front.services",compact('servicedata'));
    }
    
    public function service_details($service)
    {
        
        if(isset($_COOKIE["city_name"])){
            $city = City::select('id', 'name')->where('name',$_COOKIE['city_name'])->first();
            $servicedata = Service::with('rattings')
                        ->join('categories', 'services.category_id','categories.id')
                        ->join('users', 'services.provider_id','users.id')
                        ->select('services.id as service_id','services.name as service_name','services.price','services.price_type','services.description','services.discount','services.slug',
                            'categories.id as category_id','categories.name as category_name','categories.slug as category_slug',
                            'services.provider_id as porvider_id','services.image as service_image','users.latitude','users.longitude','services.verified_flag')
                        ->where('services.slug',$service)
                        ->where('services.is_available',1)
                        ->where('services.is_deleted',2)
                        //->where('users.city_id',@$city->id)
                        ->where('users.city_id','LIKE',"%" . @$city->id . "%")
                        //->whereIn(json_decode('users.city_id'), [$city->id])
                        ->first();
            if(!empty($servicedata)){
               
                $serviceaverageratting = Rattings::select(DB::raw('ROUND(avg(rattings.ratting),2) as avg_ratting'))
                            ->where('service_id',$servicedata->service_id)
                            ->first();
                $servicerattingsdata = Rattings::join('users', 'rattings.user_id', '=', 'users.id')
                            ->select('rattings.id','rattings.ratting','rattings.comment','users.name as user_name','users.image as user_image',
                               DB::raw('DATE(rattings.created_at) AS date'))
                            ->where('rattings.service_id',$servicedata->service_id)
                            ->get();
                
                $galleryimages = GalleryImages::select('image as gallery_image')->where('service_id',$servicedata->service_id)->get();

                $providerdata = User::with('rattings')
                            ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
                            //->join('cities', 'users.city_id', '=', 'cities.id')
                            ->leftJoin('timings', 'timings.provider_id', '=', 'users.id')
                            //->select('users.id as provider_id','users.name as provider_name','users.email','users.slug','users.mobile','cities.name as city_name','users.about','provider_types.name as provider_type','users.image as provider_image','users.latitude','users.longitude', 'users.address', 'users.available_status','users.radius', 'users.city_id')
                            ->select('users.id as provider_id','users.name as provider_name','users.email','users.slug','users.mobile','users.about','provider_types.name as provider_type','users.image as provider_image','users.latitude','users.longitude', 'users.address', 'users.available_status','users.radius', 'users.city_id')

                            ->where('users.id',$servicedata->porvider_id)
                            ->first();
                //dd($providerdata);            
            
                $timingdata = Timing::select('day','open_time','close_time','is_always_close')->where('provider_id',$providerdata->provider_id)->get();
                
                 $citiesData = City::select('name','image','is_available')->whereIn('id', json_decode($providerdata->city_id))->get();
                
                $reletedservices = Service::with('rattings')
                    ->join('categories', 'services.category_id', '=', 'categories.id')
                    ->join('users', 'services.provider_id', '=', 'users.id')
                    ->select('services.id','services.name as service_name','services.slug','services.price','services.price_type','services.duration','services.duration_type','categories.id as category_id','categories.name as category_name','users.mobile as provider_mobile','users.image as provider_image','services.image as service_image','services.description','users.name as username','users.latitude','users.longitude','services.verified_flag')
                    ->where('services.category_id',$servicedata->category_id)
                    //->where('users.city_id',@$city->id)
                    //->where('users.city_id','LIKE',"%" . @$city->id . "%")
                    //->whereIn(json_decode('users.city_id'), [$city->id])
                    ->where('users.city_id','LIKE',"%" . @$city->id . "%")
                    ->where('services.id','!=',$servicedata->service_id)
                    ->where('services.is_available',1)->where('services.is_deleted',2)
                    ->where('users.is_available',1)->orderByDesc('services.id')
                    ->get();
                    
                    $serviceCategories = Service::select('categories.name','categories.slug')
                    ->join('categories', 'categories.id', '=', 'services.category_id')
                    ->where('services.provider_id',$servicedata->porvider_id)->get();
            }else{
                $servicedata="";$serviceaverageratting="";$servicerattingsdata="";$galleryimages="";$providerdata="";$timingdata="";$reletedservices="";
            }
        }else{
            $servicedata="";$serviceaverageratting="";$servicerattingsdata="";$galleryimages="";$providerdata="";$timingdata="";$reletedservices=""; $serviceCategories="";$cities ="";
        }
        //dd($servicedata);
        //dd($providerdata);    
        return view("front.service_details",compact('citiesData', 'serviceCategories', 'city', 'servicedata','serviceaverageratting','servicerattingsdata','galleryimages','providerdata','timingdata','reletedservices'));
    }

    public function search(Request $request)
    {
        if(isset($_COOKIE["city_name"])){
            $city = City::select('id')->where('name',$_COOKIE['city_name'])->first();
            $categorydata = Category::select('id','name')
                            ->where('is_available',1)->where('is_deleted',2)
                            ->orderBy('id','DESC')->get();
            $citydata = City::select('cities.name','cities.id','cities.image')
                    ->where('cities.is_available',1)
                    ->where('cities.is_deleted',2)
                    ->orderBy('name')
                    ->get();  
             $min_price = Service::min('price');
            $max_price = Service::max('price'); 
            //dd($min_price,$max_price);
            $search_by = $request->search_by;
            if($search_by != ""){
                if($search_by == "service"){
                     if ($request->has('city') && $request->city != ""){
                         $servicedata = Service::with('rattings')
                                ->join('users', 'services.provider_id', '=', 'users.id')
                                ->join('categories as cat', 'services.category_id', '=', 'cat.id')
                                ->select('services.id','services.name as service_name','services.price','services.slug','services.image as service_image',
                                    'services.price_type','services.duration','services.duration_type','users.mobile','cat.name as category_name','users.name as username','users.image as user_image','services.description','users.slug as user_slug','users.latitude','users.longitude')
                                //->where('users.city_id',@$request->city)
                                ->where('users.city_id','LIKE',"%" . @$request->city . "%")
                                //->whereIn(json_decode('users.city_id'), [$city->id])
                                ->where('services.is_available',1)
                                ->where('services.is_deleted',2);
                     }else{
                         $servicedata = Service::with('rattings')
                                ->join('users', 'services.provider_id', '=', 'users.id')
                                ->join('categories as cat', 'services.category_id', '=', 'cat.id')
                                ->select('services.id','services.name as service_name','services.price','services.slug','services.image as service_image',
                                    'services.price_type','services.duration','services.duration_type','users.mobile','cat.name as category_name','users.name as username','users.image as user_image','services.description','users.slug as user_slug','users.latitude','users.longitude')
                                //->where('users.city_id',@$city->id)
                                ->where('users.city_id','LIKE',"%" . @$city->id . "%")
                                //->whereIn(json_decode('users.city_id'), [$city->id])
                                ->where('services.is_available',1)
                                ->where('services.is_deleted',2);
                         
                     }
                    
                    
                    if ($request->has('search_name') && $request->search_name != ""){
                        $servicedata = $servicedata->where('services.name', 'LIKE','%' . $request->search_name . '%');
                    }
                    if ($request->has('category') && $request->category != ""){
                        $servicedata = $servicedata->join('categories', 'services.category_id', '=', 'categories.id');
                        $servicedata = $servicedata->where('services.category_id', $request->category);
                    }
                    if ($request->has('min_price') && $request->min_price != "" && $request->has('max_price') && $request->max_price != ""){
                        //$servicedata = $servicedata->whereBetween('services.price', [$request->min_price, $request->max_price]);
                    }
                    if ($request->has('sort_by') && $request->sort_by != "") {
                        if ($request->sort_by == "newest"){
                            $servicedata = $servicedata->orderByDesc('services.id');
                        }
                        if ($request->sort_by == "oldest"){
                            $servicedata = $servicedata->orderBy('services.id');
                        }
                        if($request->sort_by == "low_to_high"){
                            $servicedata = $servicedata->orderBy('services.price');
                        }
                        if($request->sort_by == "high_to_low")
                        {
                            $servicedata = $servicedata->orderByDesc('services.price');
                        }
                    }else{
                        $service = $service->orderByDesc('services.id');
                    }
                    $servicedata = $servicedata->paginate(12);
                    if($request->ajax()){
                        $view = view('front.service_section',compact('servicedata'))->render();
                        return Response::json(['count'=>count($servicedata),'ResponseData'=>$view]);
                    }else{
                        return view("front.search",compact('servicedata','categorydata','citydata','min_price','max_price'));
                    }      
                }
                if($search_by == "provider"){
                    if ($request->has('city') && $request->city != ""){
                         $providerdata = User::with('rattings')
                                    //->join('cities','users.city_id','cities.id')
                                    ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
                                    ->select('users.id as provider_id','provider_types.name as provider_type','users.name as provider_name','users.slug','users.mobile','users.about','users.image as provider_image','users.latitude','users.longitude')
                                    ->where('users.type',2)
                                    ->where('users.is_available',1)
                                    //->where('users.city_id',@$city->id);
                                    ->where('users.city_id','LIKE',"%" . @$city->id . "%");
                                    //->whereIn(json_decode('users.city_id'), [$city->id]);

                    }else{
                    $providerdata = User::with('rattings')
                                    ->join('cities','users.city_id','cities.id')
                                    ->join('provider_types', 'users.provider_type', '=', 'provider_types.id')
                                    ->select('users.id as provider_id','provider_types.name as provider_type','users.name as provider_name','users.slug','users.mobile','users.about','users.image as provider_image','users.latitude','users.longitude')
                                    ->where('users.type',2)
                                    ->where('users.is_available',1)
                                   // ->where('users.city_id',@$request->city);
                                    ->where('users.city_id','LIKE',"%" . @$request->city . "%");
                                    //->whereIn(json_decode('users.city_id'), [$city->id]);

                                    
                    }                

                    if ($request->has('search_name') && $request->search_name != ""){
                        $providerdata = $providerdata->where('users.name', 'LIKE','%' . $request->search_name . '%');
                    }
                    if ($request->has('sort_by') && $request->sort_by != "") {
                        if ($request->sort_by == "oldest"){
                            $providerdata = $providerdata->orderBy('users.id');
                        }
                        if ($request->sort_by == "newest"){
                            $providerdata = $providerdata->orderByDesc('users.id');
                        }
                    }else{
                        $providerdata = $providerdata->orderByDesc('users.id');
                    }
                    $providerdata = $providerdata->paginate(12);

                    if($request->ajax()){
                        $view = view('front.provider_section',compact('providerdata'))->render();
                        return Response::json(['count'=>count($providerdata),'ResponseData'=>$view]);
                    }else{
                         return view("front.search",compact('providerdata','categorydata','citydata','min_price','max_price'));
                    }
                }
            }else{
                 if ($request->has('city') && $request->city != ""){
                     $servicedata = Service::with('rattings')
                    ->join('categories', 'services.category_id', '=', 'categories.id')
                    ->join('users', 'services.provider_id', '=', 'users.id')
                    ->select('services.id','services.name as service_name','services.price','services.slug','services.image as service_image',
                        'services.price_type','services.duration','services.duration_type','categories.id as category_id','categories.name as category_name','users.mobile','users.name as username','users.image as user_image','services.description','users.slug as user_slug','users.latitude','users.longitude')
                    //->where('users.city_id',@$request->city)
                    ->where('users.city_id','LIKE',"%" . @$request->city . "%")
                    //->whereIn(json_decode('users.city_id'), [$city->id])
                    ->where('services.is_available',1)->where('services.is_deleted',2)->orderByDesc('services.id')
                    ->paginate(12);
                 }else{
                $servicedata = Service::with('rattings')
                    ->join('categories', 'services.category_id', '=', 'categories.id')
                    ->join('users', 'services.provider_id', '=', 'users.id')
                    ->select('services.id','services.name as service_name','services.price','services.slug','services.image as service_image',
                        'services.price_type','services.duration','services.duration_type','categories.id as category_id','categories.name as category_name','users.mobile','users.name as username','users.image as user_image','services.description','users.slug as user_slug','users.latitude','users.longitude')
                    //->where('users.city_id',@$city->id)
                    ->where('users.city_id','LIKE',"%" . @$city->id . "%")
                    //->whereIn(json_decode('users.city_id'), [$city->id])
                    ->where('services.is_available',1)->where('services.is_deleted',2)->orderByDesc('services.id')
                    ->paginate(12);
                 }
                    
                   
            }
        }else{
            $servicedata = "";
            $categorydata = "";
            $citydata = "";
        }
        return view("front.search",compact('servicedata','categorydata','citydata','min_price','max_price'));
    }
    
    public function instantBooking(Request $request) 
    {
        // if(isset($_COOKIE["city_name"])){
        //     $city = City::select('id', 'name')->where('name',$_COOKIE['city_name'])->first();
        //     $min_price = User::min('booking_price');
        //     $max_price = User::max('booking_price'); 
        //     //dd($min_price);
        //     $instantBookings = User::select('users.id', 'users.name', 'users.slug', 'users.email', 'users.mobile', 'users.image', 'users.address', 
        //     'users.description', 'users.booking_price', 'users.provider_id', 'users.photographer_lat', 'users.photographer_long')
        //     ->where('users.type', 3)
        //     ->orderBy('users.id', 'desc')
        //     ->get();
        //     $instantData = array();
            
        //     if(!empty($instantBookings)) {
        //         foreach($instantBookings as $instantBooking){
        //             $providerData = User::select('name as studioName', 'slug as studioSlug', 'provider_type', 'image as studioImage', 'verified_flag', 'available_status', 'latitude', 'longitude')->where('id', $instantBooking->provider_id)->where('available_status', 1)->first();
        //             // echo "<pre>";
        //             // print_r($providerData->toArray());
        //             // echo "</pre>";
        //             if(!empty($providerData)){
        //                 $pushData = [
        //                 'photographer_id' => $instantBooking->id,
        //                 'photographer_name' => $instantBooking->name,
        //                 'photographer_slug' => $instantBooking->slug,
        //                 'photographer_image' => $instantBooking->image,
        //                 'photographer_mobile' => $instantBooking->mobile,
        //                 'photographer_description' => $instantBooking->description,
        //                 'photographer_lat' => $instantBooking->photographer_lat,
        //                 'photographer_long' => $instantBooking->photographer_long,
        //                 'studioName' => $providerData->studioName,
        //                 'studioSlug' => $providerData->studioSlug,
        //                 'studioImage' => $providerData->studioImage,
        //                 'verified_flag' => $providerData->verified_flag,
        //                 'available_status' => $providerData->available_status,
        //                 'latitude' => $providerData->latitude,
        //                 'longitude' => $providerData->longitude,
        //                 'provider_type' => $providerData->provider_type,
        //                 'booking_price' => $instantBooking->booking_price,
        //                 ];
                        
        //             array_push($instantData, $pushData);
        //             }
                    
        //         }
        //     }
            
            

        // }else {
        //     $instantData = "";
        //     $city = "";
        //     $min_price = "";
        //     $max_price = "";
            
        //}
        return view("front.instant-booking");
        
        //return view("front.instant-booking", compact()); 
    }
    
    

    public function aboutus()
    {
        if(isset($_COOKIE["city_name"])){
            $aboutdata = CMS::select('about_image','about_content')->first();
            $howworkdata = HomeSettings::first();
        }else{
            $aboutdata = "";
            $howworkdata = "";
        }
        return view('front.aboutus',compact('aboutdata','howworkdata'));
    }
    public function tc()
    {
        if(isset($_COOKIE["city_name"])){
            $tcdata = CMS::select('tc_content')->first();
        }else{
            $tcdata = "";
        }
        return view('front.tc',compact('tcdata'));
    }
    public function policy()
    {
        if(isset($_COOKIE["city_name"])){
            $policydata = CMS::select('privacy_content')->first();
        }else{
            $policydata = "";
        }
        return view('front.policy',compact('policydata'));
    }
    // public function find_service(Request $request)
    // {
    //     //print_r($request->All());
    //     if(isset($_COOKIE["city_name"])){
    //         $city = City::select('id')->where('name',$_COOKIE['city_name'])->first();
    //         if($request->ajax())
    //         {
    //                 //$query = $request->get('query');
    //                 $query = $request->input('query');
    //                 $cat = $request->input('select_cat');
    //                 if($query != ""){
    //                     $servicedata = Service::join('users','services.provider_id','users.id')
    //                             ->select('services.name as service_name','services.slug as service_slug')
    //                             ->join ('categories', 'categories.id', '=', 'services.category_id')
    //                             ->where('services.name', 'like', '%'.$query.'%')
    //                             ->where('services.category_id', $cat)
    //                             //->where('users.city_id',@$city->id)
    //                             ->where('users.city_id','LIKE',"%" . @$city->id . "%")
    //                              ->where('users.city_id','LIKE',"%" . @$city->id . "%")
    //                             ->where('services.is_available',1)
    //                             ->where('services.is_deleted',2)
    //                             ->orderByDesc('services.id')
    //                             ->get();
    //             }else{
    //                 $servicedata = "";
    //             }
    //         }
    //     }else{
    //         $servicedata = "";    
    //     }
       
    //     //return view('front.suggest', compact('servicedata'))->render();
    //      $result['services'] = $servicedata;
    //      return json_encode($result, true);
        
    // }
    
    public function find_service(Request $request)
    {
        if(isset($_COOKIE["city_name"])){
            $city = City::select('id')->where('name',$_COOKIE['city_name'])->first();
            if($request->ajax())
            {
                    $query = $request->get('query');
                    if($query != ""){
                        $servicedata = Service::join('users','services.provider_id','users.id')
                                ->select('services.name as service_name','services.slug as service_slug')
                                ->where('services.name', 'like', '%'.$query.'%')
                                //->where('users.city_id',@$city->id)
                                //->whereIn(json_decode('users.city_id'), [$city->id])
                                ->where('users.city_id','LIKE',"%" . @$city->id . "%")
                                ->where('services.is_available',1)
                                ->where('services.is_deleted',2)
                                ->orderByDesc('services.id')
                                ->get();
                }else{
                    $servicedata = "";
                }
            }
        }else{
            $servicedata = "";    
        }
        return view('front.suggest', compact('servicedata'))->render();
    }
    public function find_cities(Request $request)
    {
        if($request->ajax())
        {
            $query = $request->get('query');
            if($query != ""){
                $citydata = City::select('cities.name','cities.id','cities.image')
                        //->where('cities.name', 'like', '%'.$query.'%')
                        ->where('users.city_id', 'LIKE', "%" . json_encode($city->id) . "%")    
                        ->where('cities.is_available',1)
                        ->where('cities.is_deleted',2)
                        ->orderBy('name')
                        ->get();
            }else{
                $citydata = City::select('cities.name','cities.id','cities.image')
                    ->where('cities.is_available',1)
                    ->where('cities.is_deleted',2)
                    ->orderBy('name')
                    ->get();
            }
            return view('front.suggest', compact('citydata'))->render();
        }
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function googleAddress()
    {
        return view('googleAutocomplete');
    }
    
    // app/Http/Controllers/LocationController.php

    public function location_store(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        
        return $latitude.' '.$longitude;
    
        // Store the location data in the database or perform other actions as needed
        // UserLocation::create([
        //     'latitude' => $latitude,
        //     'longitude' => $longitude,
        // ]);
    
        return response()->json(['message' => 'Location data saved successfully']);
    }
    
    public function instantBookingNew(Request $request) 
    {
        
        //dd($request->input());
        if(isset($_COOKIE["city_name"]) && !empty($request->input('latitude')) && !empty($request->input('longitude'))){
        //if(!empty($request->input('latitude')) && !empty($request->input('longitude'))){
            
            $city = City::select('id', 'name')->where('name',$_COOKIE['city_name'])->first();
            $min_price = User::min('booking_price');
            $max_price = User::max('booking_price'); 
            //dd($min_price);
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $radius = 10000; // 50 kilometers
            
            $instantBookings = User::select('users.id', 'users.name', 'users.slug', 'users.email', 'users.mobile', 'users.image', 'users.address', 'users.description', 'users.booking_price', 'users.provider_id', 'users.photographer_lat', 'users.photographer_long')
                ->where('users.type', 3)
                ->where('users.is_available', 1)
                //  ->selectRaw(
                //     '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                //     [$latitude, $longitude, $latitude]
                // )
                //->having('distance', '<=', $radius)
                //->where('users.city_id', 'LIKE', "%" . json_encode($city->id) . "%")
               // ->whereIn(json_decode('users.city_id'), [$city->id])
               ->where('users.city_id','LIKE',"%" . @$city->id . "%")
                ->where('users.available_status', 1)
                ->orderBy('users.id', 'desc')
                ->get();
                
            // echo "<pre>";
            // print_r($instantBookings->toArray());
            // echo "</pre";
            //die;
            $instantDataGet = array();
            
            if(!empty($instantBookings)) {
                foreach($instantBookings as $instantBooking){
                    $providerData = User::select('name as studioName', 'slug as studioSlug', 'provider_type', 'image as studioImage', 'verified_flag', 'available_status', 'latitude', 'longitude')->where('id', $instantBooking->provider_id)->where('available_status', 1)->first();
                    // echo "<pre>";
                    // print_r($providerData);
                    // echo "</pre>";
                    //die;
                    if(!empty($providerData)){
                        $pushData = [
                        'photographer_id' => $instantBooking->id,
                        'photographer_name' => $instantBooking->name,
                        'photographer_slug' => $instantBooking->slug,
                        'photographer_image' => $instantBooking->image,
                        'photographer_mobile' => $instantBooking->mobile,
                        'photographer_description' => $instantBooking->description,
                        'photographer_lat' => $instantBooking->photographer_lat,
                        'photographer_long' => $instantBooking->photographer_long,
                        'studioName' => $providerData->studioName,
                        'studioSlug' => $providerData->studioSlug,
                        'studioImage' => $providerData->studioImage,
                        'verified_flag' => $providerData->verified_flag,
                        'available_status' => $providerData->available_status,
                        'latitude' => $providerData->latitude,
                        'longitude' => $providerData->longitude,
                        'provider_type' => $providerData->provider_type,
                        'booking_price' => $instantBooking->booking_price,
                         ];
                        
                    array_push($instantDataGet, $pushData);
                    }
                    
                }
            }
            
            
           
        }else {
            $instantDataGet = "";
            //$city = "";
            $min_price = "";
            $max_price = "";
            
        }
        $collection = collect($instantDataGet);
        $instantData = $collection->sortByDesc('verified_flag')->all();
        
        // echo "<pre>";
        // print_r($instantBookings->toArray());
        // echo "</pre";
        // die;
         
        return view("front.photographer_section",compact('instantData','min_price','max_price'))->render();
    }
    public static function sortByKeyDesc($array, $key)
{
    usort($array, function ($a, $b) use ($key) {
        return $b[$key] - $a[$key];
    });

    return $array;
}
    public function deleteGalleryImages(Request $request){
        $currentDate = date('Y-m-d'); // Get the current date in the format 'YYYY-MM-DD'
        $plusFiveDays = date('Y-m-d', strtotime($currentDate . ' -5 days')); // subtract 5 days to the current date
        $fromDate = $plusFiveDays . ' 00:00:00';
        $toDate = $plusFiveDays . ' 23:59:59';
        
        $data = BookingImages::where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->get();
        if(!empty($data->toArray)) {
            foreach($data as $dataRow){
                //dd($dataRow->image);
                ///https://gautamgupta.info/storage/app/public/service/gallery-1851338901.jpg
                //$filePath = url('storage/app/public/service/'.$dataRow->image); // Provide the path to the file you want to delete
                $filePath = storage_path().'/app/public/service/'.$dataRow->image;

                if (File::exists($filePath)) {
                    File::delete($filePath);
                    BookingImages::where('id', $dataRow->id)->delete();
                   
                    echo "The file has been deleted";
                } else {
                    echo "The file does not exist";
                }
            }
        } else {
            echo "Data not found for cron";
        }

    }

}
