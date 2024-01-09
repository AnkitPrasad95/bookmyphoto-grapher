<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\BookingImages;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Helper;
use App\Http\Controllers\EmailSendController;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query1 = $request->get('query');
            $query = Booking::query();
            if ($query1 != '') {
                if (Auth::user()->type == 2) {
                    $query = $query->where('bookings.provider_id', Auth::user()->id);
                } elseif ($request->get('provider') != "") {
                    $query = $query->where('bookings.provider_id', $request->get('provider'));
                }
                $query = $query->where(function ($query) use ($query1) {
                    $query->where('bookings.service_name', 'like', '%' . $query1 . '%')
                        ->orWhere('bookings.booking_id', 'like', '%' . $query1 . '%')
                        ->orWhere('bookings.date', 'like', '%' . $query1 . '%')
                        ->orWhere('bookings.time', 'like', '%' . $query1 . '%');
                });
            } else {
                if (Auth::user()->type == 2) {
                    $query = $query->where('bookings.provider_id', Auth::user()->id);
                } elseif ($request->get('provider') != "") {
                    $query = $query->where('bookings.provider_id', $request->get('provider'));
                }
            }
            $bookingdata = $query->orderByDesc('id')->paginate(10);
            return view('booking.booking_table', compact('bookingdata'))->render();
        } else if (!empty($_REQUEST['today']) && $_REQUEST['today'] == 1) {
            if (Auth::user()->type == 1) {
                $bookingdata = Booking::where('status', 3)->where('created_at', '>=', date('Y-m-d 00:00:00'))->orderByDesc('id')->paginate(10);
                $ahandymandata = "";
            } elseif (Auth::user()->type == 2) {
                $ahandymandata = User::where("provider_id", Auth::user()->id)->where('type', 3)->where('is_available', 1)->get();
                $bookingdata = Booking::where('provider_id', Auth::user()->id)->where('status', 3)->where('created_at', '>=', date('Y-m-d 00:00:00'))->orderByDesc('id')->paginate(10);
            }
            return view('booking.revenue', compact('bookingdata', 'ahandymandata'));
        } else {
            if (Auth::user()->type == 1) {
                $bookingdata = Booking::orderByDesc('id')->paginate(10);
                $ahandymandata = "";
            } elseif (Auth::user()->type == 2) {
                $ahandymandata = User::where("provider_id", Auth::user()->id)->where('type', 3)->where('is_available', 1)->get();
                $bookingdata = Booking::where('provider_id', Auth::user()->id)->orderByDesc('id')->paginate(10);
            }
            return view('booking.index', compact('bookingdata', 'ahandymandata'));
        }
    }
    public function revenue(Request $request)
    {
        if ($request->ajax()) {
            $query1 = $request->get('query');
            $query = Booking::query();
            if ($query1 != '') {
                if (Auth::user()->type == 2) {
                    $query = $query->where('bookings.provider_id', Auth::user()->id)->where('bookings.status', 3);
                } elseif ($request->get('provider') != "") {
                    $query = $query->where('bookings.provider_id', $request->get('provider'))->where('bookings.status', 3);
                } else if (Auth::user()->type == 1) {
                    $query = $query->where('bookings.status', 3);
                }
                $query = $query->where(function ($query) use ($query1) {
                    $query->where('bookings.service_name', 'like', '%' . $query1 . '%')
                        ->orWhere('bookings.booking_id', 'like', '%' . $query1 . '%')
                        ->orWhere('bookings.date', 'like', '%' . $query1 . '%')
                        ->orWhere('bookings.time', 'like', '%' . $query1 . '%')
                        ->orWhere('bookings.total_amt', 'like', '%' . $query1 . '%');
                });
            } else {
                if (Auth::user()->type == 2) {
                    $query = $query->where('bookings.provider_id', Auth::user()->id)->where('bookings.status', 3);
                } else if (Auth::user()->type == 1) {
                    $query = $query->where('bookings.status', 3);
                } elseif ($request->get('provider') != "") {
                    $query = $query->where('bookings.provider_id', $request->get('provider'))->where('bookings.status', 3);
                }
            }
            $bookingdata = $query->orderByDesc('id')->paginate(10);
            return view('booking.revenue_table', compact('bookingdata'))->render();
        } else if (!empty($_REQUEST['today']) && $_REQUEST['today'] == 1) {
            if (Auth::user()->type == 1) {
                $bookingdata = Booking::where('status', 3)->where('created_at', '>=', date('Y-m-d 00:00:00'))->orderByDesc('id')->paginate(10);
                $ahandymandata = "";
            } elseif (Auth::user()->type == 2) {
                $ahandymandata = User::where("provider_id", Auth::user()->id)->where('type', 3)->where('is_available', 1)->get();
                $bookingdata = Booking::where('provider_id', Auth::user()->id)->where('status', 3)->where('created_at', '>=', date('Y-m-d 00:00:00'))->orderByDesc('id')->paginate(10);
            }
            return view('booking.revenue', compact('bookingdata', 'ahandymandata'));
        } else {

            if (Auth::user()->type == 1) {
                $bookingdata = Booking::where('status', 3)->orderByDesc('id')->paginate(10);
                $ahandymandata = "";
            } elseif (Auth::user()->type == 2) {
                $ahandymandata = User::where("provider_id", Auth::user()->id)->where('type', 3)->where('is_available', 1)->get();
                $bookingdata = Booking::where('provider_id', Auth::user()->id)->where('status', 3)->orderByDesc('id')->paginate(10);
            }
            return view('booking.revenue', compact('bookingdata', 'ahandymandata'));
        }
    }
    public function gallery(Request $request)
    {
        if ($request->ajax()) {
            $query1 = $request->get('query');
            $query = Booking::query();
            if ($query1 != '') {
                if (Auth::user()->type == 2) {
                    $query = $query->where('bookings.provider_id', Auth::user()->id);
                } elseif ($request->get('provider') != "") {
                    $query = $query->where('bookings.provider_id', $request->get('provider'));
                }
                $query = $query ->where('bookings.status', 3)->where(function ($query) use ($query1) {
                    $query->where('bookings.service_name', 'like', '%' . $query1 . '%')
                       
                        ->orWhere('bookings.booking_id', 'like', '%' . $query1 . '%')
                        ->orWhere('bookings.date', 'like', '%' . $query1 . '%')
                        ->orWhere('bookings.time', 'like', '%' . $query1 . '%');
                });
            } else {
                if (Auth::user()->type == 2) {
                    $query = $query->where('bookings.provider_id', Auth::user()->id)->where('bookings.status', 3);
                } elseif ($request->get('provider') != "") {
                    $query = $query->where('bookings.provider_id', $request->get('provider'))->where('bookings.status', 3);
                }
            }
            $bookingdata = $query->orderByDesc('id')
            //->get();
            //dd($bookingdata->toArray());
            ->paginate(10);
            return view('gallery.gallery_table', compact('bookingdata'))->render();
        } else {
            if (Auth::user()->type == 1) {
                $bookingdata = Booking::where('status', 3)->orderByDesc('id')->paginate(10);
                $ahandymandata = "";
            } elseif (Auth::user()->type == 2) {
                $ahandymandata = User::where("provider_id", Auth::user()->id)->where('type', 3)->where('is_available', 1)->get();
                $bookingdata = Booking::where('provider_id', Auth::user()->id)->where('status', 3)
                ->orderByDesc('id')
                //->get();
                ->paginate(10);
            }
            
            //dd($bookingdata->toArray());
            return view('gallery.index', compact('bookingdata', 'ahandymandata'));
        }
    }
    public function gallery_upload($booking)
    {
        $ahandymandata = User::where("provider_id", Auth::user()->id)->where('type', 3)->where('is_available', 1)->get();
        $bookingdata = Booking::join('services', 'bookings.service_id', 'services.id')
            ->join('categories', 'services.category_id', 'categories.id')
            ->join('users', 'bookings.provider_id', 'users.id')
            ->leftJoin('users as handyman', 'bookings.handyman_id', 'handyman.id')
            ->select(
                'bookings.id',
                'bookings.booking_id',
                'bookings.service_id',
                'bookings.service_name',
                'bookings.provider_name',
                'bookings.date',
                'bookings.time',
                'bookings.price',
                'bookings.total_amt',
                'bookings.discount',
                'bookings.address',
                'bookings.note',
                'bookings.status',
                'bookings.canceled_by',
                'bookings.payment_type',
                'bookings.provider_id',
                'users.name as provider_name',
                'users.slug as provider_slug',
                'categories.name as category_name',
                'services.price_type',
                'services.duration_type',
                'services.duration',
                'services.description',
                'bookings.handyman_accept',
                'bookings.reason',
                'handyman.id as handyman_id',
                'handyman.name as handyman_name',
                'handyman.email as handyman_email',
                'handyman.mobile as handyman_mobile',
                'users.email as provider_email',
                'users.mobile as provider_mobile',
                'handyman.image as handyman_image',
                'users.image as provider_image',
                'bookings.service_image as service_image',
                'bookings.cancel_reason',
                DB::raw('DATE(bookings.created_at) AS created_date')
            )
            ->where('bookings.booking_id', $booking)
            ->first();
        return view('gallery.upload', compact('bookingdata', 'ahandymandata'));
    }

    public function gallery_details($booking)
    {
        $ahandymandata = User::where("provider_id", Auth::user()->id)->where('type', 3)->where('is_available', 1)->get();
        $bookingdata = BookingImages::where('booking_id', $booking)->get();
        return view('gallery.gallery_details', compact('bookingdata', 'ahandymandata'));
    }

    public function booking_details($booking)
    {
        //dd($booking);
        $ahandymandata = User::where("provider_id", Auth::user()->id)->where('type', 3)->where('is_available', 1)->get();
        $bookingdata = Booking::select(
                'bookings.id',
                'bookings.booking_id',
                'bookings.service_id',
                'bookings.service_name',
                'bookings.provider_name',
                'bookings.duration as instant_duration',
                'bookings.duration_type as instant_duration_type',
                'bookings.date',
                'bookings.time',
                'bookings.price',
                'bookings.total_amt',
                'bookings.discount',
                'bookings.address',
                'bookings.note',
                'bookings.status',
                'bookings.canceled_by',
                'bookings.payment_type',
                'bookings.provider_id',
                'users.name as provider_name',
                'users.slug as provider_slug',
                'categories.name as category_name',
                'services.price as service_price',
                'services.price_type',
                'services.duration_type',
                'services.duration',
                'services.description',
                'bookings.handyman_accept',
                'bookings.reason',
                'handyman.id as handyman_id',
                'handyman.name as handyman_name',
                'handyman.email as handyman_email',
                'handyman.mobile as handyman_mobile',
                'users.email as provider_email',
                'users.mobile as provider_mobile',
                'handyman.image as handyman_image',
                'users.image as provider_image',
                'bookings.service_image as service_image',
                'bookings.cancel_reason',
                'customer.name as customer_name',
                'customer.email as customer_email',
                'customer.mobile as customer_mobile',
                 'customer.image as customer_image',
                DB::raw('DATE(bookings.created_at) AS created_date')
            )
            ->join('users', 'bookings.provider_id', 'users.id')
            ->leftJoin('users as customer', 'bookings.user_id', 'customer.id')

            //->join('services', 'bookings.service_id', 'services.id')
            //->join('categories', 'services.category_id', 'categories.id')
             ->leftJoin('services', 'bookings.service_id', 'services.id')
             ->leftJoin('categories', 'services.category_id', 'categories.id')
            
            ->leftJoin('users as handyman', 'bookings.handyman_id', 'handyman.id')
            ->where('bookings.booking_id', $booking)
            ->first();
            //dd($bookingdata);
        return view('booking.booking_details', compact('bookingdata', 'ahandymandata'));
    }
    public function assign_handyman(Request $request)
    {
        //$assign = Booking::where('id', $request->id)->update(['handyman_id' => $request->handyman_id, 'handyman_accept' => 1, 'reason' => null]);
        $assign = Booking::where('id', $request->id)->update(['handyman_id' => $request->handyman_id, 'reason' => null]);
        if ($assign) {
            $checkbooking = Booking::where('id', $request->id)->first();
            helper::assign_handyman_noti($request->handyman_id, $checkbooking->booking_id);

            return redirect()->back()->with('success', trans('messages.handyman_assigned'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function accept(Request $request)
    {
        $checkbooking = Booking::where('id', $request->id)->first();
        if ($checkbooking->status == 4) {
            return response()->json(['status' => 0, 'message' => trans('messages.cancelled_by_user')], 200);
        }
        $success = Booking::where('id', $request->id)->update(['status' => $request->status]);
        if ($success) {
            //$helper = helper::accept_booking($request->id);
            $helper = EmailSendController::accept_booking($request->id);
            if ($helper == 1) {
                $checkbooking = Booking::where('id', $request->id)->first();
                helper::accept_booking_noti($checkbooking->user_id, "", $checkbooking->booking_id);
                return 1;
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.wrong_while_email')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function complete(Request $request)
    {
        $success = Booking::where('id', $request->id)->update(['status' => $request->status]);
        if ($success) {
            //$helper = helper::complete_booking($request->id);
            $helper = EmailSendController::complete_booking($request->id);
            if ($helper == 1) {
                $booking = Booking::find($request->id);
                helper::complete_booking_noti($booking->user_id, $booking->booking_id);
                // && $booking->payment_type != 2
                if ($booking->payment_type != 1) {
                    $providerdata = User::where('id', $booking->provider_id)->first();
                    $wallet = $providerdata->wallet + $booking->total_amt;
                    User::where('id', $booking->provider_id)->update(['wallet' => $wallet]);
                }
                return 1;
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.wrong_while_email')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function cancel(Request $request)
    {
        $checkbooking = Booking::where('id', $request->id)->first();
        if ($checkbooking->status == 4) {
            return response()->json(['status' => 0, 'message' => trans('messages.cancelled_by_user')], 200);
        }
        $checkbooking->status = $request->status;
        $checkbooking->canceled_by = $request->canceled_by;
        $checkbooking->cancel_reason = $request->cancel_reason;

        if ($checkbooking->payment_type != 1 && $checkbooking->payment_type != 2) {
            $wallet = Auth::user()->wallet + $checkbooking->total_amt;
            $updateuserwallet = User::where('id', Auth::user()->id)->update(['wallet' => $wallet]);

            $transaction = new Transaction;
            $transaction->user_id = Auth::user()->id;
            $transaction->service_id = $checkbooking->service_id;
            $transaction->provider_id = $checkbooking->provider_id;
            $transaction->booking_id = $checkbooking->booking_id;
            $transaction->transaction_id = $checkbooking->transaction_id;
            $transaction->amount = $checkbooking->total_amt;
            $transaction->payment_type = 1;
            $transaction->save();
        }
        if ($checkbooking->save()) {
            //$helper = helper::cancel_booking($request->id);
            $helper = EmailSendController::cancel_booking($request->id);
            
            if ($helper == 1) {
                $checkbooking = Booking::where('id', $request->id)->first();
                helper::cancel_booking_noti($checkbooking->user_id, $checkbooking->booking_id, $request->canceled_by);
                return 1;
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.wrong_while_email')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
}
