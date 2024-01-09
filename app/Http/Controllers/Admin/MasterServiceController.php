<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MasterServices;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class MasterServiceController extends Controller
{
    public function add()
    {
        $categories = Category::where('is_deleted', 2)->get();
        return view('master_service.add', compact('categories'));
    }
    public function master_services(Request $request)
    {
        // if($request->ajax())
        // {
        //     //dd('hjkhghkgkjhhg');
        //     $query = $request->get('query');
        //     if($query != ""){
        //         $categorydata = MasterServices::select('master_services.*', 'categories.name as category_name')->join('categories', 'categories.id', '=', 'master_services.category_id')->where('master_services.name', 'like', '%'.$query.'%')->where('master_services.is_deleted',2)->orderByDesc('master_services.id')->paginate(10);
        //     }else{
        //         $categorydata = MasterServices::select('master_services.*', 'categories.name as category_name')->join('categories', 'categories.id', '=', 'master_services.category_id')->where('master_services.is_deleted',2)->orderByDesc('master_services.id')->paginate(10);
        //     }
        //     echo "fgdfgdfg"; die;
        //     return view('master_service.category_table', compact('categorydata'))->render();
        // }else{
            $masterservicedata = MasterServices::select('master_services.*', 'categories.name as category_name')->join('categories', 'categories.id', '=', 'master_services.category_id')->where('master_services.is_deleted',2)->orderByDesc('master_services.id')->get();
            //dd($categorydata);
            
            return view('master_service.index', compact('masterservicedata'));
        //}
    }
    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(),
            [   'name' => 'required',
                'category_id' => 'required',
                'image' => 'required|image|mimes:jpeg,jpg,png'
            ],[ "category_id.required"=>trans('please select category'),
                "name.required"=>trans('messages.enter_service'),
                "image.required"=>trans('messages.enter_image'),
                "image.image"=>trans('messages.enter_image_file'),
                "image.mimes"=>trans('messages.valid_image')
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{

            // $file = $request->file("image");
            // $filename = 'master-service-'.time().".".$file->getClientOriginalExtension();
            // $file->move(storage_path().'/app/public/category/',$filename);
            
            if(!empty($request->file('image'))) {
              
             $file = $request->file("image");
             $filename = 'master-service-'.rand().".".$file->getClientOriginalExtension();
             $file->move(storage_path().'/app/public/service/',$filename);
    
            } else {
                $filename = '';
            }  
             

            $checkslug = MasterServices::where('slug',Str::slug($request->name, '-'))->first();
            if($checkslug != ""){
                $last = MasterServices::select('id')->orderByDesc('id')->first();
                $create = $request->name." ".($last->id+1);
                $slug =   Str::slug($create,'-');
            }else{
                $slug = Str::slug($request->name, '-');
            }
            //dd($filename);
            $category = new MasterServices;
            $category->category_id = $request->category_id;
            $category->name = $request->name;
            $category->image = $filename;
            $category->slug = $slug;
            $category->is_available = 1;
            if($request->is_featured == 'is_featured'){
                $category->is_featured = 1;
            }else{
                $category->is_featured = 2;
            }                
            $category->is_deleted = 2;
            $category->save();

            return redirect(route('master-services'))->with('success',trans('messages.service_added'));
        }
    }
    public function show($category)
    {
        $categories = Category::where('is_deleted', 2)->get();
        $categorydata = MasterServices::where('slug',$category)->first();
        return view('master_service.show',compact('categorydata', 'categories'));
    }
    



    public function edit(Request $request, $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png',
        ], [
            'name.required' => trans('messages.enter_category'),
            'image.image' => trans('messages.enter_image_file'),
            'image.mimes' => trans('messages.valid_image'),
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $rec = MasterServices::where('slug', $category)->first();
    
        
         if(!empty($request->file('image'))) {
              
             if(file_exists(storage_path("app/public/service/".$rec->image))){
                    unlink(storage_path("app/public/service/".$rec->image));
             } 
             $file = $request->file("image");
             $filename = 'master-service-'.rand().".".$file->getClientOriginalExtension();
             $file->move(storage_path().'/app/public/service/',$filename);
             $rec->update([
                'image' => $filename,
            ]);
            } 
    
        $checkslug = MasterServices::where('slug', Str::slug($request->name, '-'))
            ->where('id', '!=', $rec->id)
            ->first();
    
        if ($checkslug) {
            $last = MasterServices::select('id')->orderByDesc('id')->first();
            $create = $request->name . ' ' . ($last->id + 1);
            $slug = Str::slug($create, '-');
        } else {
            $slug = Str::slug($request->name, '-');
        }
    
        $rec->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
        ]);
    
        return redirect()->route('master-services')->with('success', trans('messages.service_updated'));
    }


    public function is_featured(Request $request)
    {
        $success = MasterServices::where('id',$request->id)->update(['is_featured'=>$request->is_featured]);
        if($success) {
            return 1;
        } else {
            return 0;
        }                                        
    }
    public function status(Request $request)
    {
        $success = MasterServices::where('id',$request->id)->update(['is_available'=>$request->status]);
        Service::where('category_id',$request->id)->update(['is_available'=>$request->status]);
        if($success) {
            return 1;
        } else {
            return 0;
        }                                        
    }
    public function destroy(Request $request, $id)
    {
        //dd($id);
        $success = MasterServices::where('id',$id)->update(['is_deleted'=>1]);
        //MasterServices::where('category_id',$id)->update(['is_available'=>2]);
        if($success) {
            //return 1;
            return redirect()->route('master-services')->with('success', trans('Master service deleted'));
        } else {
            //return 0;
            return redirect()->route('master-services')->with('danger', trans('Master service not deleted'));
        }
    }
}
