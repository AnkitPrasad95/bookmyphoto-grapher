<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Str;

class CategoryController extends Controller
{
    public function add()
    {
        return view('category.add');
    }
    public function categories(Request $request)
    {
        if($request->ajax())
        {
            $query = $request->get('query');
            if($query != ""){
                $categorydata = Category::where('name', 'like', '%'.$query.'%')->where('is_deleted',2)->orderByDesc('id')->paginate(10);
            }else{
                $categorydata = Category::where('is_deleted',2)->orderByDesc('id')->paginate(10);
            }
            return view('category.category_table', compact('categorydata'))->render();
        }else{
            $categorydata = Category::where('is_deleted',2)->orderByDesc('id')->paginate(10);
            return view('category.index', compact('categorydata'));
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [   'name' => 'required',
                'image' => 'required|image|mimes:jpeg,jpg,png'
            ],[ "name.required"=>trans('messages.enter_category'),
                "image.required"=>trans('messages.enter_image'),
                "image.image"=>trans('messages.enter_image_file'),
                "image.mimes"=>trans('messages.valid_image')
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{

            $file = $request->file("image");
            $filename = 'category-'.time().".".$file->getClientOriginalExtension();
            $file->move(storage_path().'/app/public/category/',$filename);

            $checkslug = Category::where('slug',Str::slug($request->name, '-'))->first();
            if($checkslug != ""){
                $last = Category::select('id')->orderByDesc('id')->first();
                $create = $request->name." ".($last->id+1);
                $slug =   Str::slug($create,'-');
            }else{
                $slug = Str::slug($request->name, '-');
            }

            $category = new Category;
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

            return redirect(route('categories'))->with('success',trans('messages.category_added'));
        }
    }
    public function show($category)
    {
        $categorydata = Category::where('slug',$category)->first();
        return view('category.show',compact('categorydata'));
    }
    public function edit(Request $request,$category)
    {
        $validator = Validator::make($request->all(),[
                'name' => 'required'
            ],[
                "name.required"=>trans('messages.enter_category')
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{
            if($request->file("image") != ""){
                $validator = Validator::make($request->all(),
                    [   'image' => 'image|mimes:jpeg,jpg,png'
                    ],  [   'image.image' => trans('messages.enter_image_file'),
                            'image.mimes' => trans('messages.valid_image')
                    ]);
                if ($validator->fails()) {

                    return redirect()->back()->withErrors($validator)->withInput();

                }else{
                    $rec = Category::where('slug',$category)->first(); 
                    if(file_exists(storage_path("app/public/category/".$rec->image)))
                    {
                        unlink(storage_path("app/public/category/".$rec->image));
                    }
                    
                    $file = $request->file("image");
                    $filename = 'category-'.time().".".$file->getClientOriginalExtension();
                    $file->move(storage_path().'/app/public/category/',$filename);

                    Category::where('slug', $category)->update(['image' => $filename]);    
                }
            }
            if($request->is_featured == 'is_featured'){
                $featured = 1;
            }else{
                $featured = 2;
            }
            if($request->is_available == 'is_available'){
                $available = 1;
            }else{
                $available = 2;
            }
            $cdata = Category::where('slug',$category)->first();
            $checkslug = Category::where('slug',Str::slug($request->name, '-'))->where('id','!=',$cdata->id)->first();
            if($checkslug != ""){
                $last = Category::select('id')->orderByDesc('id')->first();
                $create = $request->name." ".($last->id+1);
                $slug =   Str::slug($create,'-');
            }else{
                $slug = Str::slug($request->name, '-');
            }
            Category::where('slug', $category)
                    ->update([
                        'name' => $request->name,
                        'slug' => $slug,
                        'is_available' => $available,
                        'is_featured' => $featured
                    ]);
            return redirect()->route('categories')->with('success',trans('messages.category_updated'));
        }
    }
    public function is_featured(Request $request)
    {
        $success = Category::where('id',$request->id)->update(['is_featured'=>$request->is_featured]);
        if($success) {
            return 1;
        } else {
            return 0;
        }                                        
    }
    public function status(Request $request)
    {
        $success = Category::where('id',$request->id)->update(['is_available'=>$request->status]);
        Service::where('category_id',$request->id)->update(['is_available'=>$request->status]);
        if($success) {
            return 1;
        } else {
            return 0;
        }                                        
    }
    public function destroy(Request $request)
    {
        $success = Category::where('id',$request->id)->update(['is_deleted'=>1]);
        Service::where('category_id',$request->id)->update(['is_available'=>2]);
        if($success) {
            return 1;
        } else {
            return 0;
        }
    }
}
