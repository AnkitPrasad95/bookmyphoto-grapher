<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\GalleryImages;
use App\Models\BookingImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class GalleryImagesController extends Controller
{

    public function add(Request $request)
    {
        

		
		if ($request->hasFile('image')) {
            foreach ($request->file('image') as $key => $file) {
                $filename = 'gallery-' . rand() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/service'), $filename);
    
                $s = new GalleryImages();
                $s->service_id = $request->service_id;
                $s->image = $filename;
                $s->save();
            }
    
            //return redirect()->back()->with('success', 'Images uploaded successfully');
        }

            if($s) {
                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully'
                    ]
                ); 
            } else {
                return Response::json(array(
                    'success' => false,
                    'message' => "Please select only jpg,jpeg,png type of image file to upload"
                ), 400);
            }

             
        
    }
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'gimage_id' => 'required',
                'image' => 'bail|required|image|mimes:jpeg,jpg,png'
            ],[
                "gimage_id.required" => "Something went wrong !",
                "image.required" => "Please select an image to upload",
                "image.image" => "Please select an image type of file to upload ",
                "image.mimes" => "Select only jpg,jpeg,png type of image file to upload"
            ]);
        if ($validator->fails()) {

            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400);
            
        }else{
            $oldData = GalleryImages::find($request->gimage_id);
            if(file_exists(storage_path("app/public/service/".$oldData->image))){
                unlink(storage_path("app/public/service/".$oldData->image));
            }

            $file = $request->file("image");
            $filename = 'gallery-'.rand().".".$file->getClientOriginalExtension();
            $file->move(storage_path().'/app/public/service/',$filename);

            GalleryImages::where('id',$request->gimage_id)->update(['image'=>$filename]);

            return response()->json([
                'success' => true,
                'message' => 'Image updated successfully'
                ]
            );  
        }
    }
    public function destroy(Request $request)
    {
        $gimage = GalleryImages::find($request->id);
        if(file_exists(storage_path("app/public/service/".$gimage->image))){
            unlink(storage_path("app/public/service/".$gimage->image));
        }
        
        $success = $gimage->delete();

        if($success) {
            return 1;
        } else {
            return 0;
        }
    }
    
    public function add_gallery(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'gallery_booking_id' => 'required',
                //'gallery_image' => 'bail|required|image|mimes:jpeg,jpg,png'
            ],[
                "gallery_booking_id.required" => "Something went wrong !",
                //"gallery_image.required" => "Please select an image to upload",
                //"gallery_image.image" => "Please select an image type of file to upload",
                //"gallery_image.mimes" => "Please select only jpg,jpeg,png type of image file to upload"
            ]);
        if ($validator->fails()) {

            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400);

        }else{
            if(!empty($request->file('gallery_image'))) {
              // dd($request->file('gallery_image'));
              foreach ($request->file('gallery_image') as $imagefile) {
                $file = $imagefile; //$request->file("gallery_image");
                $filename = 'gallery-'.rand().".".$file->getClientOriginalExtension();
                $file->move(storage_path().'/app/public/service/',$filename);
    
                $s = new BookingImages();
                $s->booking_id = $request->gallery_booking_id;
                $s->image = $filename;
                $s->provider_id= Auth::user()->id;
                $s->save();
              }
               return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully'
                    ]
                );  
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Please upload any images'
                    ]
                );
            }
          

           
        }
    }
}
