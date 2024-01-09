<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingImages;
use App\Models\City;
use App\Models\Notification;
use App\Models\Rattings;
use App\Models\User;
use App\Models\Transaction;
use App\Models\BookingAddress;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Purifier;
use Storage;
use Helper;
use Str;

use App\Http\Requests;


class FrontUserController extends Controller
{
    public function add_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'street_address' => 'required',
            'landmark' => 'required',
            'postalcode' => 'required'
        ], [
            'fullname.required' => trans('messages.enter_full_name'),
            'email.required' => trans('messages.enter_email'),
            'email.email' => trans('messages.enter_valid_email'),
            'mobile.required' => trans('messages.enter_mobile'),
            'street_address.required' => trans('messages.enter_street_address'),
            'landmark.required' => trans('messages.enter_landmark'),
            'postalcode.required' => trans('messages.enter_postalcode'),
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $address = new BookingAddress();
            $address->user_id = Auth::user()->id;
            $address->name = $request->fullname;
            $address->street = $request->street_address;
            $address->landmark = $request->landmark;
            $address->postcode = $request->postalcode;
            $address->email = $request->email;
            $address->mobile = $request->mobile;
            $address->latitude = $request->latitude;
            $address->longitude = $request->longitude;
            $address->save();
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }
    public function changepassform()
    {
        return view('front.user.change_password');
    }
    public function changepass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_pass' => 'required',
            'new_pass' => 'required|different:old_pass',
            'confirm_pass' => 'required|same:new_pass'
        ], [
            'old_pass.required' => trans('messages.enter_old_password'),
            'new_pass.required' => trans('messages.enter_new_password'),
            'new_pass.different' => trans('messages.new_password_different'),
            'confirm_pass.required' => trans('messages.enter_confirm_password'),
            'confirm_pass.same' => trans('messages.confirm_password_same'),
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if (Hash::check($request->old_pass, Auth::user()->password)) {
                User::where('id', Auth::user()->id)->update(['password' => Hash::make($request->new_pass)]);

                return redirect(route('user_dashboard'))->with("success", trans('messages.password_changed'));
            } else {
                return redirect()->back()->with("error", trans('messages.old_pass_invalid'));
            }
        }
    }

    public function clearnotification()
    {
        $update = Notification::where('user_id', Auth::user()->id)->update(["is_read" => 1]);
        return json_encode($update);
    }
    public function dashboard()
    {
        if (isset($_COOKIE["city_name"])) {

            $bookings = Booking::where('bookings.user_id', Auth::user()->id)->get();
            $reviews = Rattings::where('rattings.user_id', Auth::user()->id)->get();
            $notifications = Notification::where('user_id', Auth::user()->id)->where('is_read', 2)->get();
        } else {
            $bookings = "";
            $reviews = "";
            $notifications = "";
        }
        return view('front.user.dashboard', compact('bookings', 'reviews', 'notifications'));
    }
    public function notifications()
    {
        if (isset($_COOKIE["city_name"])) {
            $notifications = Notification::select('notification.id', 'notification.booking_id', 'notification.booking_status', 'notification.title', 'notification.message', 'notification.canceled_by', 'notification.is_read', DB::raw('DATE(notification.created_at) AS date'))
                ->where('notification.user_id', Auth::user()->id)
                ->orderByDesc('notification.id')
                ->paginate(10);
        } else {
            $notifications = "";
        }
        return view('front.user.notifications', compact('notifications'));
    }
    public function bookings()
    {
        if (isset($_COOKIE["city_name"])) {
           
            
           // $bookingdata = Booking::join('services', 'bookings.service_id', 'services.id')
                //->join('users', 'bookings.provider_id', 'users.id')
                 $bookingdata = Booking::select(
                    'bookings.booking_id',
                    'bookings.service_id',
                    'bookings.service_name',
                    'bookings.handyman_id',
                    'users.name as provider_name',
                    'users.slug as provider_slug',
                    'bookings.canceled_by',
                    'bookings.handyman_accept',
                    'bookings.date',
                    'bookings.time',
                    'bookings.total_amt',
                    'bookings.assign_otp',
                    'bookings.completed_otp',
                    'bookings.address',
                    'bookings.status',
                    'bookings.provider_id',
                    'users.image as provider_image',
                    'bookings.service_image as service_image',
                    'bookings.cancel_reason'
                )
                ->join('users', 'bookings.provider_id', 'users.id')
                ->where('bookings.user_id', Auth::user()->id)
                ->orderByDesc('bookings.id')
                ->paginate(10);
                // $data = array();
                // foreach($bookingdata as $row){
                //     $newData = [
                //         'bookings=>$row->booking_id,
                //         'bookings.service_id',
                //         'bookings.service_name',
                //         'bookings.handyman_id',
                //         'users.name as provider_name',
                //         'users.slug as provider_slug',
                //         'bookings.canceled_by',
                //         'bookings.handyman_accept',
                //         'bookings.date',
                //         'bookings.time',
                //         'bookings.total_amt',
                //         'bookings.assign_otp',
                //         'bookings.completed_otp',
                //         'bookings.address',
                //         'bookings.status',
                //         'bookings.provider_id',
                //         'users.image as provider_image',
                //         'bookings.service_image as service_image',
                //         'bookings.cancel_reason'
                //             ];
                // }
               
                
                
        } else {
            $bookingdata = "";
        }
        return view('front.user.bookings', compact('bookingdata'));
    }
    public function booking_details($id)
    {
        if (isset($_COOKIE["city_name"])) {
            $bookingdata = Booking::select(
                    'bookings.booking_id',
                    'bookings.service_id',
                    'bookings.service_name',
                    'bookings.provider_name',
                    'bookings.duration as instant_duration',
                    'bookings.duration_type as instant_duration_type',
                    'bookings.date',
                    'bookings.time',
                    'bookings.price',
                    'bookings.payment_type',
                    'bookings.total_amt',
                    'bookings.discount',
                    'bookings.address',
                    'bookings.note',
                    'bookings.status',
                    'bookings.assign_otp',
                    'bookings.completed_otp',
                    'bookings.provider_id',
                    'users.name as provider_name',
                    'users.slug as provider_slug',
                    'categories.name as category_name',
                    'services.price as service_price',
                    'services.price_type',
                    'services.description',
                    'services.duration_type',
                    'services.duration',
                    'services.slug as service_slug',
                    'bookings.handyman_accept',
                    'handyman.id as handyman_id',
                    'handyman.name as handyman_name',
                    'handyman.email as handyman_email',
                    'handyman.mobile as handyman_mobile',
                    'users.email as provider_email',
                    'users.mobile as provider_mobile',
                    'handyman.image as handyman_image',
                    'users.image as provider_image',
                    'bookings.service_image as service_image',
                    DB::raw('(case when rattings.service_id is null then 0 else 1 end) as is_rated'),
                    DB::raw('DATE(bookings.created_at) AS created_date'),
                    'users.latitude',
                    'users.longitude'
                )
                //->join('services', 'bookings.service_id', 'services.id')
                //->join('categories', 'services.category_id', 'categories.id')
                ->join('users', 'bookings.provider_id', 'users.id')
                 ->leftJoin('services', 'bookings.service_id', 'services.id')
                 ->leftJoin('categories', 'services.category_id', 'categories.id')
                ->leftJoin('users as handyman', 'bookings.handyman_id', 'handyman.id')
                ->leftJoin('rattings', function ($query) {
                    $query->on('rattings.service_id', '=', 'bookings.service_id')
                        ->where('rattings.user_id', '=', Auth::user()->id);
                })
            
                ->where('bookings.booking_id', $id)
                ->first();
        } else {
            $bookingdata = "";
        }
       
        //dd($bookingdata->toArray);
        return view('front.user.booking_details', compact('bookingdata'));
    }

    public function gallery_details($id)
    {
        if (isset($_COOKIE["city_name"])) {
            $bookingdata1 = BookingImages::where('booking_id', $id)->get();
        } else {
            $bookingdata1 = "";
        }
        return view('front.user.gallery', compact('bookingdata1'));
    }
    public function reviews()
    {
        if (isset($_COOKIE["city_name"])) {
            $rattingsdata = Rattings::leftJoin('users', 'rattings.provider_id', '=', 'users.id')
                ->leftJoin('services', 'rattings.service_id', '=', 'services.id')
                ->select(
                    'rattings.id',
                    'rattings.ratting',
                    'rattings.comment',
                    'services.id as service_id',
                    'services.name as service_name',
                    'services.slug as service_slug',
                    'users.id as provider_id',
                    'users.name as provider_name',
                    'users.slug as provider_slug',
                    'services.image as service_image',
                    'users.image as provider_image',
                    DB::raw('DATE(rattings.created_at) AS date')
                )
                ->where('rattings.user_id', Auth::user()->id)
                ->paginate(10);
        } else {
            $rattingsdata = "";
        }
        return view('front.user.reviews', compact('rattingsdata'));
    }
    public function profile()
    {
        if (isset($_COOKIE["city_name"])) {
            $citydata = City::select('id', 'name')->where('is_available', 1)->where('is_deleted', 2)->orderBy('name')->get();
        } else {
            $citydata = "";
        }
        return view('front.user.profile', compact('citydata'));
    }
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'about' => 'required'
        ], [
            'name.required' => trans('messages.enter_fullname'),
            'address.required' => trans('messages.enter_address'),
            'city.required' => trans('messages.enter_city'),
            'about.required' => trans('messages.enter_about'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            if ($request->file('image') != "") {
                $validator = Validator::make(
                    $request->all(),
                    ['image' => 'image|mimes:jpg,jpeg,png'],
                    [
                        'image.image' => trans('messages.enter_image_file'),
                        'image.mimes' => trans('messages.valid_image')
                    ]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {
                    if (Auth::user()->image != "default.png") {
                        if (file_exists(storage_path("app/public/profile/" . Auth::user()->image))) {
                            unlink(storage_path("app/public/profile/" . Auth::user()->image));
                        }
                    }
                    $file = $request->file('image');
                    $filename = 'profile-' . time() . "." . $file->getClientOriginalExtension();
                    $file->move(storage_path() . '/app/public/profile/', $filename);

                    User::where('id', Auth::user()->id)->update(['image' => $filename]);
                }
            }
            $update = User::where('id', Auth::user()->id)->update([
                'name' => $request->name,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'city_id' => $request->city,
                'about' => strip_tags(Purifier::clean($request->about))
            ]);
            return redirect(route('user_profile'))->with('success', trans('messages.success'));
        }
    }

    public function get_bookings_by(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query1 = $request->get('search_by');
            if ($query1 == 'all') {
                $data = Booking::join('users as provider', 'bookings.provider_id', 'provider.id')
                    ->select('bookings.*', 'provider.name as provider_name', 'provider.slug as provider_slug', 'provider.image as provider_image', 'bookings.service_image as service_image', 'provider.latitude', 'provider.longitude')
                    ->where('user_id', Auth::user()->id)
                    ->orderByDesc('bookings.id')
                    ->get();
            } else {
                $data = Booking::join('users as provider', 'bookings.provider_id', 'provider.id')
                    ->select('bookings.*', 'provider.name as provider_name', 'provider.slug as provider_slug', 'bookings.service_image as service_image', 'provider.image as provider_image', 'provider.latitude', 'provider.longitude')
                    ->where('user_id', Auth::user()->id)
                    ->where('bookings.status', $query1)
                    ->orderByDesc('bookings.id')
                    ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {
                $i = 1;
                foreach ($data as $row) {
                    if(!empty($row->handyman_id)){
                        $handyData = User::where('id', $row->handyman_id)->first();
                    } else {
                        $handyData = '';
                    }
                    
                    if ($row->status == 1) {
                        $status = "<span class='badge bg-warning-light'>" . trans('labels.pending') . "</span>";
                    } elseif ($row->status == 2) {
                        $status = "<span class='badge bg-info-light'>" . trans('labels.accepted') . "</span>";
                    }
                    if ($row->status == 1) {
                        $action = "<a class='btn btn-sm bg-danger-light' onclick='cancelbooking(" . $row->booking_id . ")'><i class='fas fa-close'></i> " . trans('labels.cancel_booking') . " </a>";
                    } elseif ($row->status == 2) {
                        $action = "<h5><span class='badge bg-primary-light'><i class='fas fa-clock'></i> " . trans('labels.inprogress') . " </span></h5>";
                        $status = NULL;
                    } elseif ($row->status == 3) {
                        $action = "<h5><span class='badge bg-success-light'><i class='fas fa-check'></i> " . trans('labels.completed') . " </span></h5>";
                        $status = NULL;
                    } elseif ($row->status == 4) {
                        if ($row->canceled_by == 1) {
                            $action = "<h5><span class='badge bg-danger-light'><i class='fas fa-close'></i> " . trans('labels.cancel_by_provider') . " </span></h5>";
                        } else {
                            $action = "<h5><span class='badge bg-danger-light'><i class='fas fa-close'></i> " . trans('labels.cancel_by_you') . " </span></h5>";
                        }
                        $status = NULL;
                    } elseif ($row->status == 5) {
                        $action = "<h5><span class='badge bg-success-light'><i class='fas fa-check'></i> " . trans('Photographer Arrived') . " </span></h5>";
                        $status = NULL;
                        
                    } elseif ($row->status == 6) {
                        $action = "<h5><span class='badge bg-danger-light'><i class='fas fa-check'></i> " . trans('Not Available') . " </span></h5>";
                        $status = NULL;
                        
                    }

                    $output .= "
                        <div class='booking-list'>
                            <div class='booking-widget'>
                                <a href='" . URL("/home/user/bookings/" . $row->booking_id) . "' class='booking-img text-center'>
                                    <img src='" . Helper::image_path($row->service_image) . "' alt='" . trans('labels.service_image') . "'>
                                    <span class='badge bg-success-light'>" . trans('labels.booking') . " : <strong>" . $row->booking_id . "</strong></span>
                                </a>
                                <div class='booking-det-info'>
                                    <h3>
                                       
                                        
                                        <a href='" . URL("/home/user/bookings/" . $row->booking_id) . "'>" . $row->service_name . "</a>
                                        " . $status . "
                                    </h3>
                                    <ul class='booking-details'>";
                                    
                                        
                                        if(!empty($handyData)) {
                                             $output .= "<li><span>" . trans('Photographer') . "</span> " . $handyData->name . " </li>";
                                            }
                                        
                                        
                                       
                                        $output .= "<li><span>" . trans('labels.booking_date') . "</span> " . date('d F Y', strtotime($row->date)) . " </li>
                                        <li><span>" . trans('labels.booking_time') . "</span> " . $row->time . " </li>
                                        <li><span>" . trans('labels.amount') . "</span> " . Helper::currency_format($row->total_amt) . " </li>
                                        <li>
                                            <span>" . trans('labels.provider') . "</span>
                                            <div class='avatar avatar-xs mr-1'>
                                                <img class='avatar-img rounded-circle' alt='" . trans('labels.provider_image') . "' src='" . Helper::image_path($row->provider_image) . "'>
                                            </div>
                                            <a href='" . URL('/home/providers-services/' . $row->provider_slug) . "' class='text-muted'>" . $row->provider_name . "</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class='booking-action'>" . $action . "</div>
                        </div>
                    ";
                }
            } else {
                $output = '
                    <div class="d-flex justify-content-center">
                      ' . trans('labels.bookings_not_found') . '
                   </div>
                ';
            }
            return Response::json(['status' => 1, 'bookings_by' => $output], 200);
        }
    }
    
    public static function getHandymanData($id){
         return $handyData = User::where('id', $id)->first();
        //return view('front.user.bookings', compact('handyData'));
         //dd($handyData);
    }

    public function get_bookings(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query1 = $request->get('query');
            if ($query1 != '') {
                $data = Booking::join('users as provider', 'bookings.provider_id', 'provider.id')
                    ->select('bookings.*', 'provider.name as provider_name', 'provider.slug as provider_slug', 'provider.image as provider_image', 'bookings.service_image as service_image', 'users.latitude', 'users.longitude')
                    ->where('user_id', Auth::user()->id)
                    ->where(function ($query) use ($query1) {
                        $query->where('bookings.booking_id', 'like', '%' . $query1 . '%');
                    })
                    ->orderByDesc('bookings.id')
                    ->get();
            } else {
                $data = Booking::join('users as provider', 'bookings.provider_id', 'provider.id')
                    ->select('bookings.*', 'provider.name as provider_name', 'provider.slug as provider_slug', 'provider.image as provider_image', 'bookings.service_image as service_image', 'users.latitude', 'users.longitude')
                    ->where('user_id', Auth::user()->id)
                    ->where(function ($query) use ($query1) {
                        $query->where('bookings.booking_id', 'like', '%' . $query1 . '%');
                    })
                    ->orderByDesc('bookings.id')
                    ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {
                $i = 1;
                foreach ($data as $row) {
                    if ($row->status == 1) {
                        $status = "<span class='badge bg-warning-light'>" . trans('labels.pending') . "</span>";
                    } elseif ($row->status == 2) {
                        $status = "<span class='badge bg-info-light'>" . trans('labels.accepted') . "</span>";
                    }
                    if ($row->status == 1) {
                        $action = "<a class='btn btn-sm bg-danger-light' onclick='cancelbooking(" . $row->booking_id . ")'><i class='fas fa-close'></i> " . trans('labels.cancel_booking') . " </a>";
                    } elseif ($row->status == 2) {
                        $action = "<h5><span class='badge bg-primary-light'><i class='fas fa-clock'></i> " . trans('labels.inprogress') . " </span></h5>";
                        $status = NULL;
                    } elseif ($row->status == 3) {
                        $action = "<h5><span class='badge bg-success-light'><i class='fas fa-check'></i> " . trans('labels.completed') . " </span></h5>";
                        $status = NULL;
                    } elseif ($row->status == 4) {
                        if ($row->canceled_by == 1) {
                            $action = "<h5><span class='badge bg-danger-light'><i class='fas fa-close'></i> " . trans('labels.cancel_by_provider') . " </span></h5>";
                        } else {
                            $action = "<h5><span class='badge bg-danger-light'><i class='fas fa-close'></i> " . trans('labels.cancel_by_you') . " </span></h5>";
                        }
                        $status = NULL;
                    }

                    $output .= "
                        <div class='booking-list'>
                            <div class='booking-widget'>
                                <a href='" . URL("/home/user/bookings/" . $row->booking_id) . "' class='booking-img text-center'>
                                    <img src='" . Helper::image_path($row->service_image) . "' alt='" . trans('labels.service_image') . "'>
                                    <span class='badge bg-success-light'>" . trans('labels.booking') . ": <strong>" . $row->booking_id . "</strong></span>
                                </a>
                                <div class='booking-det-info'>
                                    <h3>
                                        <a href='" . URL("/home/user/bookings/" . $row->booking_id) . "'>" . $row->service_name . "</a>
                                        " . $status . "
                                    </h3>
                                    <ul class='booking-details'>
                                        <li><span>" . trans('labels.booking_date') . "</span> " . date('d F Y', strtotime($row->date)) . " </li>
                                        <li><span>" . trans('labels.booking_time') . "</span> " . $row->time . " </li>
                                        <li><span>" . trans('labels.amount') . "</span> " . Helper::currency_format($row->total_amt) . " </li>
                                        <li><span>" . trans('labels.location') . "</span> " . Str::limit($row->address, 50) . " </li>
                                        <li>
                                            <span>" . trans('labels.provider') . "</span>
                                            <div class='avatar avatar-xs mr-1'>
                                                <img class='avatar-img rounded-circle' alt='" . trans('labels.provider_image') . "' src='" . Helper::image_path($row->provider_image) . "'>
                                            </div>
                                            <a href='" . URL('/home/providers-services/' . $row->provider_slug) . "' class='text-muted'>" . $row->provider_name . "</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class='booking-action'>" . $action . "</div>
                        </div>
                    ";
                }
            } else {
                $output = '
                    <div class="d-flex justify-content-center">
                      ' . trans('labels.bookings_not_found') . '
                   </div>
                ';
            }
            return Response::json(['status' => 1, 'bookings' => $output], 200);
        }
    }
    public function addrattings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider' => 'required',
            'service' => 'required',
            'ratting' => 'required',
            'message' => 'required'
        ], [
            'provider.required' => trans('messages.wrong'),
            'service.required' => trans('messages.wrong'),
            'ratting.required' => trans('messages.enter_rattings'),
            'message.required' => trans('messages.enter_review')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $rattings = new Rattings();
            $rattings->user_id = Auth::user()->id;
            $rattings->service_id = $request->service;
            $rattings->provider_id = $request->provider;
            $rattings->ratting = $request->ratting;
            $rattings->comment = $request->message;
            $rattings->save();
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }
    public function downloadFile($file_name)
    {
        $file1 = Helper::image_path($file_name); //Storage::disk('public')->get($file_name);
        $file = storage_path("app/public/service/" . $file_name);
        return response()->download($file);
    }
}
