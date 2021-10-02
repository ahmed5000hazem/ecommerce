<div>
<!-- Form -->

<form class="cart-form clearfix" wire:submit.prevent="addToCart">
    @csrf
    <!-- Select Box -->
    <div class="select-box d-flex mt-50 mb-30">
        <select name="size" wire:model="cart.size" class="col" id="productSize" class="mr-5">
            <option value="0">{{__("app.size")}}</option>
            @foreach ($product->sizes()->get() as $size)
                <option value="{{$size->id}}">{{$size->size}}</option>
            @endforeach
        </select>
        <select name="color" wire:model="cart.color" class="col" id="productColor">
            <option value="0">{{__("app.color")}}</option>
            @foreach ($product->colors()->get() as $color)
                <option value="{{$color->id}}">{{$color->color_name}}</option>
            @endforeach
        </select>
        <input type="number" wire:model="cart.qty" class="form-control col rounded-0 border border-1" name="qty" value="1" min="1" max="12">
    </div>
    <!-- Cart & Favourite Box -->
    <div class="cart-fav-box d-flex align-items-center">
        <!-- Cart -->
        <button type="submit" name="addtocart" class="btn essence-btn">{{__("app.add-to-cart")}}</button>
    </div>
</form>
</div>