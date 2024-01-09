<?php



namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;

use App\Models\Service;

use App\Models\Slider;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Purifier;



class SliderController extends Controller

{

    public function index()

    {

        $sliderdata = Slider::where('is_deleted',2)->orderBy('id','DESC')->paginate(10);



        return view('slider.index',compact('sliderdata'));

    }

    public function add()

    {

        $servicedata = Service::where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();



        return view('slider.add',compact('servicedata'));

    }

    public function store(Request $request)

    {

        $validator = Validator::make($request->all(),[

                'title' => 'required',

                'image' => 'required|image|mimes:jpg,jpeg,png',

                'service_id' => 'required',

                'description' => 'required'

            ],[ 

                'title.required' => trans('messages.enter_slider_title'),

                'image.required' => trans('messages.enter_image'),

                'image.image' => trans('messages.enter_image_file'),

                'image.mimes' => trans('messages.valid_image'),

                'service_id.required' => trans('messages.select_service'),

                'description.required' => trans('messages.enter_description')

            ]);

        if ($validator->fails()) {



            return redirect()->back()->withErrors($validator)->withInput();



        }else{



            $file = $request->file('image');

            $filename = 'slider-'.time().".".$file->getClientOriginalExtension();

            $file->move(storage_path().'/app/public/slider/',$filename);

            $description = strip_tags(Purifier::clean($request->description));

            $slider = new Slider();

            $slider->title = $request->title;

            $slider->service_id = $request->service_id;

            $slider->image = $filename;

            $slider->description = $description;

            $slider->is_available = 1;

            $slider->is_deleted = 2;

            $slider->save();



            return redirect(route('sliders'))->with('success',trans('messages.slider_added'));

        }

    }

    public function show($id)

    {

        $sliderdata = Slider::find($id);



        $servicedata = Service::where('id','!=',$sliderdata['servicename']->id)->where('is_deleted',2)->where('is_available',1)->orderBy('id','DESC')->get();



        return view('slider.show',compact('sliderdata','servicedata'));

    }

    public function edit(Request $request,$id)

    {

        $validator = Validator::make($request->all(),[

                'title' => 'required',

                'service_id' => 'required',

                'description' => 'required'

            ],[

                'title.required' => trans('messages.enter_slider_title'),

                'service_id.required' => trans('messages.select_service'),

                'description.required' => trans('messages.enter_description')

            ]);

        if ($validator->fails()) {



            return redirect()->back()->withErrors($validator)->withInput();

            

        }else{

            

            if($request->file('image') != ""){

                $validator = Validator::make($request->all(),[

                        'image' => 'required|image|mimes:jpg,jpeg,png',

                    ],[

                        'image.required' => trans('messages.enter_image'),

                        'image.image' => trans('messages.enter_image_file'),

                        'image.mimes' => trans('messages.valid_image'),

                    ]);

                if ($validator->fails()) {

        

                    return redirect()->back()->withErrors($validator)->withInput();

                    

                }else{

                    $rec = Slider::find($id); 

                    if(file_exists(storage_path("app/public/slider/".$rec->image))){

                        unlink(storage_path("app/public/slider/".$rec->image));

                    }

                    

                    $file = $request->file('image');

                    $filename = 'slider-'.time().".".$file->getClientOriginalExtension();

                    $file->move(storage_path().'/app/public/slider/',$filename);

    

                    Slider::where('id',$id)->update(['image'=>$filename]);



                }  

            }

            $description = strip_tags(Purifier::clean($request->description));

            Slider::where('id',$id)

                ->update([

                    'title'=>$request->title,

                    'service_id'=>$request->service_id,

                    'description'=>$description

                ]);



            return redirect(route('sliders'))->with('success',trans('messages.slider_updated'));

        }

    }

    public function status(Request $request)

    {

        $success = Slider::where('id',$request->id)->update(['is_available'=>$request->status]);

        if($success) {

            return 1;

        } else {

            return 0;

        }

    }

    public function destroy(Request $request)

    {

        $success = Slider::where('id',$request->id)->update(['is_deleted'=>1]);

        if($success) {

            return 1;

        } else {

            return 0;

        }

    }

}

