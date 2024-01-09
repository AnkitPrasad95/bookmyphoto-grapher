<form class="form form-horizontal striped-rows form-bordered" action="{{URL::to('/profile-settings/add-bank')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-body">
        <h4 class="form-section"><i class="fa fa-university"></i> {{trans('labels.add_bank')}}</h4>
        <div class="form-group row">
            <label class="col-md-2 label-control" for="bank_name">{{trans('labels.bank_name')}}</label>
            <div class="col-md-10">
                <input type="text" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror" placeholder="{{trans('labels.enter_bank_name')}}" name="bank_name">
                @error('bank_name')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 label-control" for="account_holder">{{trans('labels.account_holder')}}</label>
            <div class="col-md-10">
                <input type="text" id="account_holder" class="form-control @error('account_holder') is-invalid @enderror" placeholder="{{trans('labels.enter_account_holder')}}" name="account_holder">
                @error('account_holder')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 label-control" for="account_type">{{trans('labels.account_type')}}</label>
            <div class="col-md-10">
                <input type="text" id="account_type" class="form-control @error('account_type') is-invalid @enderror" placeholder="{{trans('labels.enter_account_type')}}" name="account_type">
                @error('account_type')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 label-control" for="account_number">{{trans('labels.account_number')}}</label>
            <div class="col-md-10">
                <input type="text" id="account_number" class="form-control @error('account_number') is-invalid @enderror" placeholder="{{trans('labels.enter_account_number')}}" name="account_number">
                @error('account_number')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 label-control" for="routing_number">{{trans('labels.routing_number')}}</label>
            <div class="col-md-10">
                <input type="text" id="routing_number1" class="form-control @error('routing_number') is-invalid @enderror" placeholder="{{trans('labels.enter_routing_number')}}" name="routing_number">
                @error('routing_number')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
    <div class="form-actions">
        @if (env('Environment') == 'sendbox')
            <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"><i class="fa fa-paper-plane"></i> {{trans('labels.add')}}</button>
        @else
            <button type="submit" class="btn btn-raised btn-primary"><i class="fa fa-paper-plane"></i> {{trans('labels.add')}}</button>
        @endif
    </div>
</form>