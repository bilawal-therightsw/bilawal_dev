<form action="{{ isset($user->id) ? route('dashboard.users.update', $user->id) : route('dashboard.users.store') }}"
    method="post" data-form="ajax-form" data-modal="#ajax_model" data-datatable="#stores-table" id="form-pointer" enctype="multipart/form-data">
    {!! csrf_field() !!}

    @if (isset($user->id))
        @method('PUT')
    @endif
    <input type="hidden" value="user" name="user_type">
    <div class="modal-body">

        <div class="row">   
            <div class="col-md-3 col-sm-3">
                <div class="form-group">
                    <label class="control-label">Name&nbsp;<span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-md-9 col-sm-9">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" minlength="3"
                        value="{{isset($user->name) ? $user->name : ''}}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="form-group">
                    <label class="control-label">Email&nbsp;<span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-md-9 col-sm-9">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" minlength="3"
                        value="{{isset($user->email) ? $user->email : ''}}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="form-group">
                    <label class="control-label">Phone&nbsp;<span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-md-9 col-sm-9">
                <div class="form-group">
                    <input type="number" class="form-control" name="phone" 
                        value="{{isset($user->phone) ? $user->phone : ''}}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="form-group">
                    <label class="form-control-label">Countries</label>
                </div>
            </div>
           
            <div class="col-md-9 col-sm-9">
                <div class="form-group">
                <select class="form-control" name="country">
                    <option selected disabled>Select Your Country</option>
                    @foreach (config('countries.countries') as $country)
                        <option value="{{ $country['name'] }}" {{isset($user->country) ? ($user->country == $country['name']) ? 'selected' : "" : ""}}>{{ $country['name'] }}</option>
                     @endforeach
                </select>
                </div>
            </div>            
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-3   ">
                <div class="form-group">
                    <label class="control-label">City</label>
                </div>
            </div>
            <div class="col-md-9 col-sm-9">
                <div class="form-group">
                    <input type="text" class="form-control" name="city" 
                        value="{{isset($user->city) ? $user->city : ''}}" >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="form-group">
                    <label class="form-control-label">Status&nbsp;<span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-md-9 col-sm-9">
                <div class="form-group">
                <select class="form-control" name="status">
                    <option value="1" {{ isset($user->status) ? $user->status ? 'selected' : '' : '' }}>Active</option>
                    <option value="0" {{ isset($user->status) ? !$user->status ? 'selected' : '' : '' }}>Inactive</option>
                   
                </select>
                </div>
            </div>            
        </div>

        @if(!isset($user))
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Password&nbsp;<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-9 col-sm-9">
                    <div class="form-group">
                        <input type="password" class="form-control" name="password"
                            value="{{isset($user->password) ? $user->password : ''}}" required>
                    </div>
                </div>
            </div>
        @endif

    </div>



    <div class="modal-footer">
        <button type="submit" class="btn btn-light" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success" data-button="submit">{{ !isset($user)? 'Save' : 'Update'}}</button>
    </div>
</form>
<script>
    $('input:text').on('keypress', function (event) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
</script>