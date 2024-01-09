<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Handyman;
use App\Models\Provider;
use App\Models\City;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Purifier;
use Str;

class HandymanController extends Controller
{
    public function index()
    {
        if (Auth::user()->type == 1) {
            $handymandata = User::where('type', 3)->orderByDesc('id')->paginate(10);
        } elseif (Auth::user()->type == 2) {

            $handymandata = User::where('provider_id', Auth::user()->id)->where('type', 3)->orderBy('id', 'DESC')->paginate(10);
        }
        return view('provider.handyman.index', compact('handymandata'));
    }
    public function add()
    {

        $citydata = City::where('is_available', 1)->where('is_deleted', 2)->orderBy('id', 'DESC')->get();

        return view('provider.handyman.add', compact('citydata'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'mobile' => 'required|',
            'address' => 'required',
            'city_id' => 'required'
        ],  [
            'name.required' => trans('messages.enter_full_name'),
            'email.required' => trans('messages.enter_email'),
            'email.email' => trans('messages.valid_email'),
            'email.unique' => trans('messages.email_exist'),
            'password.required' => trans('messages.enter_password'),
            'image.required' => trans('messages.enter_image'),
            'image.image' => trans('messages.enter_image_file'),
            'image.mimes' => trans('messages.valid_image'),
            'mobile.required' => trans('messages.enter_mobile'),
            'address.required' => trans('messages.enter_address'),
            'city_id.required' => trans('messages.enter_city')
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $file = $request->file("image");
            $filename = 'handyman-' . time() . "." . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/handyman/', $filename);

            $checkslug = User::where('slug', Str::slug($request->name, '-'))->first();
            if ($checkslug != "") {
                $last = User::select('id')->orderByDesc('id')->first();
                $create = $request->name . " " . ($last->id + 1);
                $slug =   Str::slug($create, '-');
            } else {
                $slug = Str::slug($request->name, '-');
            }
            $address = strip_tags(Purifier::clean($request->address));
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->image = $filename;
            $user->password = Hash::make($request->password);
            $user->type = 3;
            $user->provider_id = Auth::user()->id;
            $user->address = $address;
            $user->city_id = json_encode($request->city_id);
            $user->login_type = "email";
            $user->is_verified = 1;
            $user->is_available = 1;
            $user->available_status = 1;
            $user->slug = $slug;
            $user->description = $request->description;
            $user->booking_price = $request->booking_price;
            $user->save();

            return redirect(route('handymans'))->with('success', trans('messages.handyman_added'));
        }
    }
    public function status(Request $request)
    {
        $success = User::where('id', $request->id)->update(['is_available' => $request->status]);
        if ($success) {
            return 1;
        } else {
            return 0;
        }
    }
    public function show($handyman)
    {
        $handymandata = User::where('id', $handyman)->first();
        //dd($handymandata);
        $cityID = json_decode($handymandata->city_id);
        $citydata = City::where('is_available', 1)->where('is_deleted', 2)->orderBy('id', 'DESC')->get();
        //dd($citydata);

        return view('provider.handyman.show', compact('handymandata', 'citydata', 'cityID'));
    }
    public function edit(Request $request, $handyman)
    {
        //dd($request->input());
        $hdata = User::where('slug', $handyman)->first();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $hdata->id,
            'mobile' => 'required|numeric',
            'address' => 'required',
            'city_id' => 'required'
        ], [
            'name.required' => trans('messages.enter_full_name'),
            'email.required' => trans('messages.enter_email'),
            'email.email' => trans('messages.valid_email'),
            'email.unique' => trans('messages.email_exist'),
            'mobile.required' => trans('messages.enter_mobile'),
            'address.required' => trans('messages.enter_address'),
            'city_id.required' => trans('messages.enter_city')
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if ($request->file("image") != "") {

                $validator = Validator::make($request->all(), [
                    'image' => 'required|image|mimes:jpeg,jpg,png',
                ], [
                    'image.required' => trans('messages.enter_image'),
                    'image.image' => trans('messages.enter_image_file'),
                    'image.mimes' => trans('messages.valid_image'),
                ]);
                if ($validator->fails()) {

                    return redirect()->back()->withErrors($validator)->withInput();
                } else {
                    if (file_exists(storage_path() . '/app/public/handyman/' . $hdata->image) && $hdata->image != "default.png") {
                        unlink(storage_path() . '/app/public/handyman/' . $hdata->image);
                    }

                    $file = $request->file("image");
                    $filename = 'handyman-' . time() . "." . $file->getClientOriginalExtension();
                    $file->move(storage_path() . '/app/public/handyman/', $filename);

                    User::where('id', $hdata->id)->update(['image' => $filename]);
                }
            }
            if ($request->is_available) {
                $status = 1;
            } else {
                $status = 2;
            }
            $checkslug = User::where('slug', Str::slug($request->name, '-'))->first();
            if ($checkslug != "") {
                $last = User::select('id')->orderByDesc('id')->first();
                $create = $request->name . " " . ($last->id + 1);
                $slug =   Str::slug($create, '-');
            } else {
                $slug = Str::slug($request->name, '-');
            }
            $city_id = json_encode($request->city_id);
            $address = strip_tags(Purifier::clean($request->address));
            User::where('id', $hdata->id)->update([
                'name' =>  $request->name,
                'email' =>  $request->email,
                'mobile' =>  $request->mobile,
                'address' =>  $address,
                'city_id' =>  $city_id,
                'is_available' =>  $status,
                'slug' =>  $slug,
                'description' => $request->description,
                'booking_price' => $request->booking_price,
            ]);

            return redirect(route('handymans'))->with('success', trans('messages.handyman_updated'));
        }
    }
    public function showhandyman(Request $request, $handyman)
    {
        $handymandata = User::where('id', $handyman)->first();
        $total_bookings = Booking::where('handyman_id', $handymandata->id)->count();
        $total_completed = Booking::where('handyman_id', $handymandata->id)->where('status', 3)->count();
        $total_pending = Booking::where('handyman_id', $handymandata->id)->where('status', 2)->count();

        // bookings-chart-start 
        $years = Booking::select(DB::raw("YEAR(created_at) as year"))->orderByDesc('created_at')->where('handyman_id', $handymandata->id)->groupBy(DB::raw("YEAR(created_at)"))->get();
        $bookings = Booking::select(DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("YEAR(created_at) as year"), DB::raw("COUNT(id) total"))
            ->groupBy(DB::raw("YEAR(created_at)"), DB::raw("MONTHNAME(created_at)"))
            ->orderBy('created_at')
            ->where('handyman_accept', 1)->where('status', 3)
            ->where('handyman_id', $handymandata->id);
        if ($request->has('year') && $request->year != "") {
            $bookings = $bookings->where(DB::raw("YEAR(created_at)"), '=', $request->year);
        } else {
            $bookings = $bookings->where(DB::raw("YEAR(created_at)"), '=', date('Y'));
        }
        $bookings = $bookings->get();
        $result[] = ['Month', 'Bookings'];
        foreach ($bookings as $key => $value) {
            $result[++$key] = [$value->month_name, (int)$value->total];
        }
        // bookings-chart-end

        if ($request->ajax()) {
            echo json_encode($result);
        } else {
            $bookings_count = json_encode($result);
            //dd($handymandata);
            return view('provider.handyman.showhandyman', compact('handymandata', 'total_bookings', 'total_completed', 'total_pending', 'years', 'bookings_count'));
        }
    }

    public function fetch_handyman(Request $request)
    {
        if ($request->ajax()) {
            $query1 = $request->get('query');
            $query = User::query();

            $query = $query->join('users as provider', 'provider.id', 'users.provider_id')->select('users.*', 'provider.name as provider_name')->where('users.type', 3);

            if ($query1 != '') {
                if (Auth::user()->type == 2) {
                    $query = $query->where('users.provider_id', Auth::user()->id);
                } elseif ($request->get('provider') != "") {
                    $query = $query->where('users.provider_id', $request->get('provider'));
                }
                $query = $query->where('users.is_available', 1)
                    ->where(function ($queryy) use ($query1) {
                        $queryy->where('users.name', 'like', '%' . $query1 . '%')
                            ->orWhere('users.email', 'like', '%' . $query1 . '%')
                            ->orWhere('users.mobile', 'like', '%' . $query1 . '%')
                            ->orWhere('provider.name', 'like', '%' . $query1 . '%');
                    });
            } else {
                if (Auth::user()->type == 2) {
                    $query = $query->where('users.provider_id', Auth::user()->id);
                } elseif ($request->get('provider') != "") {
                    $query = $query->where('users.provider_id', $request->get('provider'));
                }
            }
            $handymandata = $query->paginate(10);
            return view('provider.handyman.handyman_table', compact('handymandata'))->render();
        }
    }
}
