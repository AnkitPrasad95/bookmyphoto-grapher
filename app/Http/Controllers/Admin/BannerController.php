<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class BannerController extends Controller
{
    public function index()
    {
        $bannerdata = Banner::select('banners.*', 'categories.name as category_name')->leftjoin('categories', 'categories.id', '=', 'banners.category_id')->orderBy('id','DESC')->paginate(10);
        
        //dd($bannerdata);
        return view('banner.index',compact('bannerdata'));
    }
    public function add()
    {
        $categorydata = Category::where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();
        $servicedata = Service::where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get(); 
        return view('banner.add',compact('categorydata','servicedata'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'type' => 'required',
                'image' => 'required|image|mimes:jpeg,jpg,png'
            ],  [ 
                'type.required' => trans('messages.select_banner_type'),
                'image.required' => trans('messages.enter_image'),
                'image.image' => trans('messages.enter_image_file'),
                'image.mimes' =>  trans('messages.valid_image')
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $file = $request->file("image");
            $filename = 'banners-'.time().".".$file->getClientOriginalExtension();
            $file->move(storage_path().'/app/public/banner/',$filename);
            
            if($request->type == 1)
            {
                $validator = Validator::make($request->all(),[
                        'category_id' => 'required'
                    ],  [ 
                        'category_id.required' => trans('messages.select_category')
                    ]);
        
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $banner = new Banner();
                    $banner->image = $filename;
                    $banner->type = $request->type;
                    $banner->category_id = $request->category_id;
                    $banner->save();
                    return redirect(route('banners'))->with('success',trans('messages.banner_added'));
                }  
            }
            if($request->type == 2)
            {
                $validator = Validator::make($request->all(),[
                        'service_id' => 'required'
                    ],  [ 
                        'service_id.required' => trans('messages.select_service')
                    ]);
            
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $banner = new Banner();
                    $banner->image = $filename;
                    $banner->type = $request->type;
                    $banner->service_id = $request->service_id;
                    $banner->save();
                    return redirect(route('banners'))->with('success',trans('messages.banner_added'));
                }  
            }
        }
    }
    public function show(Request $request,$id)
    {
        $bannerdata = Banner::find($id);
        if($bannerdata->type == 1){
            $categorydata = Category::where('id','!=',$bannerdata->category_id)->where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();
            $servicedata = Service::where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();   
        }elseif($bannerdata->type == 2){
            $categorydata = Category::where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();
            $servicedata = Service::where('id','!=',$bannerdata->service_id)->where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();
        }
        return view('banner.show',compact('bannerdata','categorydata','servicedata'));
    }
    public function edit(Request $request,$id)
    {
        $validator = Validator::make($request->all(),
            ['type' => 'required'],
            [ 'type.required' => trans('messages.select_banner_type')]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if($request->file('image') != "")
            {
                $validator = Validator::make($request->all(),
                    ['image' => 'required|image|mimes:jpeg,jpg,png'],
                    [ 'image.required' => trans('messages.enter_image'),
                    'image.image' => trans('messages.enter_image_file'),
                    'image.mimes' =>  trans('messages.valid_image')]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $rec = Banner::find($id); 
                    if(file_exists(storage_path("app/public/banner/".$rec->image))){
                        unlink(storage_path("app/public/banner/".$rec->image));
                    }
                    $file = $request->file("image");
                    $filename = 'banners-'.time().".".$file->getClientOriginalExtension();
                    $file->move(storage_path().'/app/public/banner/',$filename);
                    Banner::where('id',$id)->update([
                        "image"=>$filename
                    ]);
                }
            }
            if($request->type == 1)
            {
                $validator = Validator::make($request->all(),
                    ['category_id' => 'required'],
                    [ 'category_id.required' => trans('messages.select_category')]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    Banner::where('id',$id)->update([
                        "type"=>$request->type,
                        "category_id"=>$request->category_id,
                        "service_id"=>NULL
                    ]);
                    return redirect(route('banners'))->with('success',trans('messages.banner_updated'));
                }  
            }
            if($request->type == 2)
            {
                $validator = Validator::make($request->all(),
                    ['service_id' => 'required'],
                    ['service_id.required' => trans('messages.select_service')]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    Banner::where('id',$id)->update([
                        "type"=>$request->type,
                        "category_id"=>NULL,
                        "service_id"=>$request->service_id
                    ]);
                    return redirect(route('banners'))->with('success',trans('messages.banner_updated'));
                }  
            }
        }
    }
    public function destroy(Request $request)
    {
        $rec = Banner::find($request->id); 
        if(file_exists(storage_path("app/public/banner/".$rec->image))){
            unlink(storage_path("app/public/banner/".$rec->image));
        }
        if($rec->delete()){
            return 1;
        }else{
            return 0;
        }

    }
}
