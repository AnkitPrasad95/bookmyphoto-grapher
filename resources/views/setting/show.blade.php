@extends('layout.main')
@section('page_title',trans('labels.settings'))
@section('content')
   <section id="basic-form-layouts">
      <div class="row">
         <div class="col-sm-12">
            <div class="content-header">{{trans('labels.settings')}}</div>
         </div>
      </div>
      <div class="row justify-content-md-center">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <div class="px-3">
                        <form class="form form-horizontal striped-rows form-bordered" id="edit_setting_form" action="{{URL::to('settings/edit')}}" method="POST" enctype="multipart/form-data">
                           @csrf
                           <div class="form-body">
                              <h4 class="form-section"><i class="ft-user"></i> Basic Info</h4>
                              <div class="form-group row" style="display:none">
                                 <label class="col-md-2 label-control" for="firebase_key">{{trans('labels.firebase_key')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" id="edit_firebase_key" class="form-control" name="firebase_key" value="{{$settingdata->firebase_key}}" placeholder="{{trans('labels.enter_firebase_key')}}">
                                    @error('firebase_key')<span class="text-danger" id="firebase_key_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row" style="display:none">
                                 <label class="col-md-2 label-control" for="currency">{{trans('labels.currency')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" id="edit_currency" class="form-control" name="currency" value="{{$settingdata->currency}}" placeholder="{{trans('labels.enter_currency')}}">
                                    @error('currency')<span class="text-danger" id="currency_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last" style="display:none">
                                 <label class="col-md-2 label-control" for="currency_position">{{trans('labels.currency_position')}}</label>
                                 <div class="col-md-10">
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="currency_position" id="left" value="left" @if($settingdata->currency_position == "left") checked="checked" @endif>
                                       <label class="form-check-label" for="left">{{trans('labels.left')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="currency_position" id="right" value="right" @if($settingdata->currency_position == "right") checked="checked" @endif>
                                       <label class="form-check-label" for="right">{{trans('labels.right')}}</label>
                                    </div>
                                    @error('currency_position')<span class="text-danger" id="currency_position_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label class="col-md-2 label-control" for="referral_amount">{{trans('labels.referral_amount')}}</label>
                                 <div class="col-md-10">
                                       <input type="text" id="edit_referral_amount" class="form-control" name="referral_amount" value="{{$settingdata->referral_amount}}" placeholder="{{trans('labels.enter_referral_amount')}}">
                                       @error('referral_amount')<span class="text-danger" id="referral_amount_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="withdrawable_amount">{{trans('labels.withdrawable_amount')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" id="edit_withdrawable_amount" class="form-control" name="withdrawable_amount" value="{{$settingdata->withdrawable_amount}}" placeholder="{{trans('labels.enter_withdrawable_amount')}}">
                                    @error('withdrawable_amount')<span class="text-danger" id="withdrawable_amount_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="timezone">{{trans('labels.timezone')}} </label>
                                 <div class="col-md-10">
                                    <select class="form-control selectpicker" name="timezone" id="timezone" data-live-search="true">
                                       <option value="Pacific/Midway" {{$settingdata->timezone == "Pacific/Midway"  ? 'selected' : ''}}>(GMT-11:00) Midway Island, Samoa</option>
               <option value="America/Adak" {{$settingdata->timezone == "America/Adak"  ? 'selected' : ''}}>(GMT-10:00) Hawaii-Aleutian</option>
               <option value="Etc/GMT+10" {{$settingdata->timezone == "Etc/GMT+10"  ? 'selected' : ''}}>(GMT-10:00) Hawaii</option>
               <option value="Pacific/Marquesas" {{$settingdata->timezone == "Pacific/Marquesas"  ? 'selected' : ''}}>(GMT-09:30) Marquesas Islands</option>
               <option value="Pacific/Gambier" {{$settingdata->timezone == "Pacific/Gambier"  ? 'selected' : ''}}>(GMT-09:00) Gambier Islands</option>
               <option value="America/Anchorage" {{$settingdata->timezone == "America/Anchorage"  ? 'selected' : ''}}>(GMT-09:00) Alaska</option>
               <option value="America/Ensenada" {{$settingdata->timezone == "America/Ensenada"  ? 'selected' : ''}}>(GMT-08:00) Tijuana, Baja California</option>
               <option value="Etc/GMT+8" {{$settingdata->timezone == "Etc/GMT+8"  ? 'selected' : ''}}>(GMT-08:00) Pitcairn Islands</option>
               <option value="America/Los_Angeles" {{$settingdata->timezone == "America/Los_Angeles"  ? 'selected' : ''}}>(GMT-08:00) Pacific Time (US & Canada)</option>
               <option value="America/Denver" {{$settingdata->timezone == "America/Denver"  ? 'selected' : ''}}>(GMT-07:00) Mountain Time (US & Canada)</option>
               <option value="America/Chihuahua" {{$settingdata->timezone == "America/Chihuahua"  ? 'selected' : ''}}>(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
               <option value="America/Dawson_Creek" {{$settingdata->timezone == "America/Dawson_Creek"  ? 'selected' : ''}}>(GMT-07:00) Arizona</option>
               <option value="America/Belize" {{$settingdata->timezone == "America/Belize"  ? 'selected' : ''}}>(GMT-06:00) Saskatchewan, Central America</option>
               <option value="America/Cancun" {{$settingdata->timezone == "America/Cancun"  ? 'selected' : ''}}>(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
               <option value="Chile/EasterIsland" {{$settingdata->timezone == "Chile/EasterIsland"  ? 'selected' : ''}}>(GMT-06:00) Easter Island</option>
               <option value="America/Chicago" {{$settingdata->timezone == "America/Chicago"  ? 'selected' : ''}}>(GMT-06:00) Central Time (US & Canada)</option>
               <option value="America/New_York" {{$settingdata->timezone == "America/New_York"  ? 'selected' : ''}}>(GMT-05:00) Eastern Time (US & Canada)</option>
               <option value="America/Havana" {{$settingdata->timezone == "America/Havana"  ? 'selected' : ''}}>(GMT-05:00) Cuba</option>
               <option value="America/Bogota" {{$settingdata->timezone == "America/Bogota"  ? 'selected' : ''}}>(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
               <option value="America/Caracas" {{$settingdata->timezone == "America/Caracas"  ? 'selected' : ''}}>(GMT-04:30) Caracas</option>
               <option value="America/Santiago" {{$settingdata->timezone == "America/Santiago"  ? 'selected' : ''}}>(GMT-04:00) Santiago</option>
               <option value="America/La_Paz" {{$settingdata->timezone == "America/La_Paz"  ? 'selected' : ''}}>(GMT-04:00) La Paz</option>
               <option value="Atlantic/Stanley" {{$settingdata->timezone == "Atlantic/Stanley"  ? 'selected' : ''}}>(GMT-04:00) Faukland Islands</option>
               <option value="America/Campo_Grande" {{$settingdata->timezone == "America/Campo_Grande"  ? 'selected' : ''}}>(GMT-04:00) Brazil</option>
               <option value="America/Goose_Bay" {{$settingdata->timezone == "America/Goose_Bay"  ? 'selected' : ''}}>(GMT-04:00) Atlantic Time (Goose Bay)</option>
               <option value="America/Glace_Bay" {{$settingdata->timezone == "America/Glace_Bay"  ? 'selected' : ''}}>(GMT-04:00) Atlantic Time (Canada)</option>
               <option value="America/St_Johns" {{$settingdata->timezone == "America/St_Johns" ? 'selected' : ''}}>(GMT-03:30) Newfoundland</option>
               <option value="America/Araguaina" {{$settingdata->timezone == "America/Araguaina"  ? 'selected' : ''}}>(GMT-03:00) UTC-3</option>
               <option value="America/Montevideo" {{$settingdata->timezone == "America/Montevideo"  ? 'selected' : ''}}>(GMT-03:00) Montevideo</option>
               <option value="America/Miquelon" {{$settingdata->timezone == "America/Miquelon"  ? 'selected' : ''}}>(GMT-03:00) Miquelon, St. Pierre</option>
               <option value="America/Godthab" {{$settingdata->timezone == "America/Godthab"  ? 'selected' : ''}}>(GMT-03:00) Greenland</option>
               <option value="America/Argentina/Buenos_Aires" {{$settingdata->timezone == "America/Argentina/Buenos_Aires"  ? 'selected' : ''}}>(GMT-03:00) Buenos Aires</option>
               <option value="America/Sao_Paulo" {{$settingdata->timezone == "America/Sao_Paulo"  ? 'selected' : ''}}>(GMT-03:00) Brasilia</option>
               <option value="America/Noronha" {{$settingdata->timezone == "America/Noronha"  ? 'selected' : ''}}>(GMT-02:00) Mid-Atlantic</option>
               <option value="Atlantic/Cape_Verde" {{$settingdata->timezone == "Atlantic/Cape_Verde"  ? 'selected' : ''}}>(GMT-01:00) Cape Verde Is.</option>
               <option value="Atlantic/Azores" {{$settingdata->timezone == "Atlantic/Azores"  ? 'selected' : ''}}>(GMT-01:00) Azores</option>
               <option value="Europe/Belfast" {{$settingdata->timezone == "Europe/Belfast"  ? 'selected' : ''}}>(GMT) Greenwich Mean Time : Belfast</option>
               <option value="Europe/Dublin" {{$settingdata->timezone == "Europe/Dublin"  ? 'selected' : ''}}>(GMT) Greenwich Mean Time : Dublin</option>
               <option value="Europe/Lisbon" {{$settingdata->timezone == "Europe/Lisbon"  ? 'selected' : ''}}>(GMT) Greenwich Mean Time : Lisbon</option>
               <option value="Europe/London" {{$settingdata->timezone == "Europe/London"  ? 'selected' : ''}}>(GMT) Greenwich Mean Time : London</option>
               <option value="Africa/Abidjan" {{$settingdata->timezone == "Africa/Abidjan"  ? 'selected' : ''}}>(GMT) Monrovia, Reykjavik</option>
               <option value="Europe/Amsterdam" {{$settingdata->timezone == "Europe/Amsterdam"  ? 'selected' : ''}}>(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
               <option value="Europe/Belgrade" {{$settingdata->timezone == "Europe/Belgrade"  ? 'selected' : ''}}>(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
               <option value="Europe/Brussels" {{$settingdata->timezone == "Europe/Brussels"  ? 'selected' : ''}}>(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
               <option value="Africa/Algiers" {{$settingdata->timezone == "Africa/Algiers"  ? 'selected' : ''}}>(GMT+01:00) West Central Africa</option>
               <option value="Africa/Windhoek" {{$settingdata->timezone == "Africa/Windhoek"  ? 'selected' : ''}}>(GMT+01:00) Windhoek</option>
               <option value="Asia/Beirut" {{$settingdata->timezone == "Asia/Beirut"  ? 'selected' : ''}}>(GMT+02:00) Beirut</option>
               <option value="Africa/Cairo" {{$settingdata->timezone == "Africa/Cairo"  ? 'selected' : ''}}>(GMT+02:00) Cairo</option>
               <option value="Asia/Gaza" {{$settingdata->timezone == "Asia/Gaza"  ? 'selected' : ''}}>(GMT+02:00) Gaza</option>
               <option value="Africa/Blantyre" {{$settingdata->timezone == "Africa/Blantyre"  ? 'selected' : ''}}>(GMT+02:00) Harare, Pretoria</option>
               <option value="Asia/Jerusalem" {{$settingdata->timezone == "Asia/Jerusalem"  ? 'selected' : ''}}>(GMT+02:00) Jerusalem</option>
               <option value="Europe/Minsk" {{$settingdata->timezone == "Europe/Minsk" ? 'selected' : ''}}>(GMT+02:00) Minsk</option>
               <option value="Asia/Damascus" {{$settingdata->timezone == "Asia/Damascus" ? 'selected' : ''}}>(GMT+02:00) Syria</option>
               <option value="Europe/Moscow" {{$settingdata->timezone == "Europe/Moscow"  ? 'selected' : ''}}>(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
               <option value="Africa/Addis_Ababa" {{$settingdata->timezone == "Africa/Addis_Ababa"  ? 'selected' : ''}}>(GMT+03:00) Nairobi</option>
               <option value="Asia/Tehran" {{$settingdata->timezone == "Asia/Tehran"  ? 'selected' : ''}}>(GMT+03:30) Tehran</option>
               <option value="Asia/Dubai" {{$settingdata->timezone == "Asia/Dubai"  ? 'selected' : ''}}>(GMT+04:00) Abu Dhabi, Muscat</option>
               <option value="Asia/Yerevan" {{$settingdata->timezone == "Asia/Yerevan"  ? 'selected' : ''}}>(GMT+04:00) Yerevan</option>
               <option value="Asia/Kabul" {{$settingdata->timezone == "Asia/Kabul"  ? 'selected' : ''}}>(GMT+04:30) Kabul</option>
               <option value="Asia/Yekaterinburg" {{$settingdata->timezone == "Asia/Yekaterinburg"  ? 'selected' : ''}}>(GMT+05:00) Ekaterinburg</option>
               <option value="Asia/Tashkent" {{$settingdata->timezone == "Asia/Tashkent"  ? 'selected' : ''}}>(GMT+05:00) Tashkent</option>
               <option value="Asia/Kolkata" {{$settingdata->timezone == "Asia/Kolkata"  ? 'selected' : ''}}>(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
               <option value="Asia/Katmandu" {{$settingdata->timezone == "Asia/Katmandu"  ? 'selected' : ''}}>(GMT+05:45) Kathmandu</option>
               <option value="Asia/Dhaka" {{$settingdata->timezone == "Asia/Dhaka"  ? 'selected' : ''}}>(GMT+06:00) Astana, Dhaka</option>
               <option value="Asia/Novosibirsk" {{$settingdata->timezone == "Asia/Novosibirsk"  ? 'selected' : ''}}>(GMT+06:00) Novosibirsk</option>
               <option value="Asia/Rangoon" {{$settingdata->timezone == "Asia/Rangoon"  ? 'selected' : ''}}>(GMT+06:30) Yangon (Rangoon)</option>
               <option value="Asia/Bangkok" {{$settingdata->timezone == "Asia/Bangkok"  ? 'selected' : ''}}>(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
               <option value="Asia/Kuala_Lumpur" {{$settingdata->timezone == "Asia/Kuala_Lumpur"  ? 'selected' : ''}}>(GMT+08:00) Kuala Lumpur</option>
               <option value="Asia/Krasnoyarsk" {{$settingdata->timezone == "Asia/Krasnoyarsk"  ? 'selected' : ''}}>(GMT+07:00) Krasnoyarsk</option>
               <option value="Asia/Hong_Kong" {{$settingdata->timezone == "Asia/Hong_Kong"  ? 'selected' : ''}}>(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
               <option value="Asia/Irkutsk" {{$settingdata->timezone == "Asia/Irkutsk"  ? 'selected' : ''}}>(GMT+08:00) Irkutsk, Ulaan Bataar</option>
               <option value="Australia/Perth" {{$settingdata->timezone == "Australia/Perth"  ? 'selected' : ''}}>(GMT+08:00) Perth</option>
               <option value="Australia/Eucla" {{$settingdata->timezone == "Australia/Eucla"  ? 'selected' : ''}}>(GMT+08:45) Eucla</option>
               <option value="Asia/Tokyo" {{$settingdata->timezone == "Asia/Tokyo"  ? 'selected' : ''}}>(GMT+09:00) Osaka, Sapporo, Tokyo</option>
               <option value="Asia/Seoul" {{$settingdata->timezone == "Asia/Seoul"  ? 'selected' : ''}}>(GMT+09:00) Seoul</option>
               <option value="Asia/Yakutsk" {{$settingdata->timezone == "Asia/Yakutsk"  ? 'selected' : ''}}>(GMT+09:00) Yakutsk</option>
               <option value="Australia/Adelaide" {{$settingdata->timezone == "Australia/Adelaide"  ? 'selected' : ''}}>(GMT+09:30) Adelaide</option>
               <option value="Australia/Darwin" {{$settingdata->timezone == "Australia/Darwin"  ? 'selected' : ''}}>(GMT+09:30) Darwin</option>
               <option value="Australia/Brisbane" {{$settingdata->timezone == "Australia/Brisbane"  ? 'selected' : ''}}>(GMT+10:00) Brisbane</option>
               <option value="Australia/Hobart" {{$settingdata->timezone == "Australia/Hobart"  ? 'selected' : ''}}>(GMT+10:00) Hobart</option>
               <option value="Asia/Vladivostok" {{$settingdata->timezone == "Asia/Vladivostok"  ? 'selected' : ''}}>(GMT+10:00) Vladivostok</option>
               <option value="Australia/Lord_Howe" {{$settingdata->timezone == "Australia/Lord_Howe"  ? 'selected' : ''}}>(GMT+10:30) Lord Howe Island</option>
               <option value="Etc/GMT-11" {{$settingdata->timezone == "Etc/GMT-11"  ? 'selected' : ''}}>(GMT+11:00) Solomon Is., New Caledonia</option>
               <option value="Asia/Magadan" {{$settingdata->timezone == "Asia/Magadan"  ? 'selected' : ''}}>(GMT+11:00) Magadan</option>
               <option value="Pacific/Norfolk" {{$settingdata->timezone == "Pacific/Norfolk"  ? 'selected' : ''}}>(GMT+11:30) Norfolk Island</option>
               <option value="Asia/Anadyr" {{$settingdata->timezone == "Asia/Anadyr"  ? 'selected' : ''}}>(GMT+12:00) Anadyr, Kamchatka</option>
               <option value="Pacific/Auckland" {{$settingdata->timezone == "Pacific/Auckland"  ? 'selected' : ''}}>(GMT+12:00) Auckland, Wellington</option>
               <option value="Etc/GMT-12" {{$settingdata->timezone == "Etc/GMT-12"  ? 'selected' : ''}}>(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
               <option value="Pacific/Chatham" {{$settingdata->timezone == "Pacific/Chatham"  ? 'selected' : ''}}>(GMT+12:45) Chatham Islands</option>
               <option value="Pacific/Tongatapu" {{$settingdata->timezone == "Pacific/Tongatapu"  ? 'selected' : ''}}>(GMT+13:00) Nuku'alofa</option>
               <option value="Pacific/Kiritimati" {{$settingdata->timezone == "Pacific/Kiritimati"  ? 'selected' : ''}}>(GMT+14:00) Kiritimati</option>
                                    </select>
                                    @error('timezone')<span class="text-danger" id="timezone_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="address">{{trans('labels.address')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" name="address" class="form-control" placeholder="{{trans('labels.address')}}" value="{{$settingdata->address}}">
                                    @error('address')<span class="text-danger" id="timezone_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="contact">{{trans('labels.contact')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" name="contact" class="form-control" placeholder="{{trans('labels.contact')}}" value="{{$settingdata->contact}}">
                                    @error('contact')<span class="text-danger" id="timezone_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="email">{{trans('labels.email')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" name="email" class="form-control" placeholder="{{trans('labels.enter_email')}}" value="{{$settingdata->email}}">
                                    @error('email')<span class="text-danger" id="timezone_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="copyright">{{trans('labels.copyright')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" name="copyright" class="form-control" placeholder="{{trans('labels.enter_copyright')}}" value="{{$settingdata->copyright}}">
                                    @error('copyright')<span class="text-danger" id="timezone_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="logo">{{trans('labels.logo')}} </label>
                                 <div class="col-md-10">
                                    @error('logo')<span class="text-danger" id="logo_error">{{ $message }}</span>@enderror
                                    <input type="file" id="edit_logo" class="form-control" name="logo" value="{{ old('logo') }}">
                                    <img src="{{Helper::image_path($settingdata->logo)}}" alt="{{trans('labels.logo')}}" class="rounded media-object round-media setting-profile mt-2">
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="banner">{{trans('labels.banner')}} </label>
                                 <div class="col-md-10">
                                    @error('banner')<span class="text-danger" id="banner_error">{{ $message }}</span>@enderror
                                    <input type="file" id="edit_banner" class="form-control" name="banner" value="{{ old('banner') }}">
                                    <img src="{{Helper::image_path($settingdata->banner)}}" alt="{{trans('labels.banner')}}" class="rounded media-object round-media setting-profile mt-2">
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="favicon">{{trans('labels.favicon')}} </label>
                                 <div class="col-md-10">
                                    @error('favicon')<span class="text-danger" id="favicon_error">{{ $message }}</span>@enderror
                                    <input type="file" id="edit_favicon" class="form-control" name="favicon" value="{{ old('favicon') }}">
                                    <img src="{{Helper::image_path($settingdata->favicon)}}" alt="{{trans('labels.favicon')}}" class="rounded media-object round-media setting-profile mt-2">
                                 </div>
                              </div>
                              <h4 class="form-section"><i class="fa fa-bar-chart"></i> {{trans('labels.seo')}} </h4>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="website_title">{{trans('labels.website_title')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" name="website_title" class="form-control" placeholder="{{trans('labels.enter_website_title')}}" value="{{$settingdata->website_title}}">
                                    @error('website_title')<span class="text-danger" id="website_title_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="meta_title">{{trans('labels.meta_title')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" name="meta_title" class="form-control" placeholder="{{trans('labels.enter_meta_title')}}" value="{{$settingdata->meta_title}}">
                                    @error('meta_title')<span class="text-danger" id="meta_title_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="meta_description">{{trans('labels.meta_description')}}</label>
                                 <div class="col-md-10">
                                    <textarea class="form-control" name="meta_description" placeholder="{{trans('labels.enter_meta_description')}}">{{$settingdata->meta_description}}</textarea>
                                    @error('meta_description')<span class="text-danger" id="meta_description_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
      
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="og_image">{{trans('labels.og_image')}}</label>
                                 <div class="col-md-10">
                                    @error('og_image')<span class="text-danger" id="og_image_error">{{ $message }}</span>@enderror
                                    <input type="file" id="og_image" class="form-control" name="og_image" value="{{ old('og_image') }}">
                                    <img src="{{Helper::image_path($settingdata->og_image)}}" alt="{{trans('labels.og_image')}}" class="rounded media-object round-media setting-profile mt-2">
                                 </div>
                              </div>
                              <h4 class="form-section"><i class="fa fa-bar-chart"></i> {{trans('labels.social_accounts')}} </h4>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="facebook_link">{{trans('labels.facebook')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" name="facebook_link" class="form-control" placeholder="{{trans('labels.facebook')}}" value="{{$settingdata->facebook_link}}">
                                    @error('facebook_link')<span class="text-danger" id="facebook_link_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="twitter_link">{{trans('labels.twitter')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" name="twitter_link" class="form-control" placeholder="{{trans('labels.twitter')}}" value="{{$settingdata->twitter_link}}">
                                    @error('twitter_link')<span class="text-danger" id="twitter_link_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="instagram_link">{{trans('labels.instagram')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" name="instagram_link" class="form-control" placeholder="{{trans('labels.instagram')}}" value="{{$settingdata->instagram_link}}">
                                    @error('instagram_link')<span class="text-danger" id="instagram_link_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="linkedin_link">{{trans('labels.linkedin')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" name="linkedin_link" class="form-control" placeholder="{{trans('labels.linkedin')}}" value="{{$settingdata->linkedin_link}}">
                                    @error('linkedin_link')<span class="text-danger" id="linkedin_link_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                           </div>
                           <div class="form-actions left">
                              @if (env('Environment') == 'sendbox')
                                 <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                              @else
                                 <button type="submit" id="btn_setting" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                              @endif
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection