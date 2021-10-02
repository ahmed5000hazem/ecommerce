<?php

namespace App\Http\Livewire;
use App\Models\Cart;
use Livewire\Component;

class AddToCartFrom extends Component
{

    public $product;

    public $message;

    

    public Cart $cart;
    
    protected $rules = [
        'cart.size' => 'required|numeric|min:1',
        'cart.color' => 'required|numeric|min:1',
        'cart.qty' => 'required|numeric|max:12',
    ];

    public function addToCart () {
        $this->validate();

        return response()->json(["message" => "good"]);
        // $this->cart->product_id = $this->product->id;
        // $this->cart->save();
    }

    public function message()
    {
        $this->message = "clicked and prevent-default";
    }

    public function render()
    {
        return view('livewire.add-to-cart-from');
    }
}
