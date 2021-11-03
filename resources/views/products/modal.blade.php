<form action="{{ isset($product->id) ? route('dashboard.products.update', $product->id) : route('dashboard.products.store') }}"
    method="post" data-form="ajax-form" data-modal="#ajax_model" data-datatable="#stores-table" id="form-pointer" enctype="multipart/form-data">
    {!! csrf_field() !!}

    @if (isset($product->id))
        @method('PUT')
    @endif

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
                        value="{{isset($product->name) ? $product->name : ''}}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="form-group">
                    <label class="control-label">Description</label>
                </div>
            </div>
            <div class="col-md-9 col-sm-9">
                <div class="form-group">
                    <textarea class="form-control" name="description"
                        rows="3" required>{{isset($product->description) ? $product->description : ''}}</textarea>
                </div>
            </div>
        </div>

       

        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="form-group">
                    <label class="control-label">Price&nbsp;<span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="col-md-9 col-sm-9">
                <div class="form-group">
                    <input type="number" class="form-control" name="price"
                        value="{{isset($product->price) ? $product->price : ''}}" required>
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
                    <option value="1"  selected="">Active</option>
                    <option value="0" >Inactive</option>
                   
                </select>
                </div>
            </div>            
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="form-group">
                    <label class="control-label">Image</label>
                </div>
            </div>
            <div class="col-md-9 col-sm-9">
                <div class="form-group">
                    <input type="file" class="form-control" name="image" >
                </div>
            </div>
        </div>

       

    </div>



    <div class="modal-footer">
        <button type="submit" class="btn btn-light" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success" data-button="submit">{{ !isset($product)? 'Save' : 'Update'}}</button>
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