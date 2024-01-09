   
<div class="catsec">
   <div class="container-fluid">
      @if(!empty($categorydata) && count($categorydata)>0)
         <div class="row match-height">
            <div id="categories" class="owl-carousel owl-theme">
            @foreach($categorydata as $cdata)
            <div class="item text-center">
               <a href="{{ URL::to('/home/services/'.$cdata->slug)}}">
                  <img class="img-fluid" src="{{ Helper::image_path($cdata->image) }}" alt="{{trans('labels.image')}}">
               </a>
               <a href="{{ URL::to('/home/services/'.$cdata->slug)}}">
                  <h6>{{$cdata->name}}</h6>
               </a>
            </div>
            @endforeach
         </div>
      @else
         <p class="text-center">{{trans('labels.no_data')}}</p>
      @endif
   </div>
</div>