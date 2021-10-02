@section('modal')
<!-- Modal -->
<div class="modal select-product-images-modal fade" id="select-product-images" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Product Images</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row modal-body-container">
                    <div class="col-lg-3 col-md-4 col-sm-6 modal-body-content mb-4">
                        
                        <div class="card d-none">
                            <img src="" class="card-img-top" alt="">
                            <div class="card-body">
                                <h5 class="card-title text-info">Image Name</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="images[]" value="" aria-label="...">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{__("app.select")}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("app.save")}}</button>
        </div>
        </div>
    </div>
</div>
@endsection