<?php

namespace App\Livewire\Topping;

use App\Models\Topping;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class CreateTopping extends Component
{
    //Topping properties
    public $toppingName;

    //Rules for the form
    protected $rules=[
        'toppingName' => ['required', 'regex:/^[a-zA-Z0-9\s\'-]+$/']
    ];

    public function saveTopping() {
        // Validate the form data
        $this->validate();

        // Checks if Topping name already exists
        $existingTopping = Topping::where('name', $this->toppingName)->exists();
        if ($existingTopping) {
            session()->flash('name_error', 'That topping already exists. Please create a different topping.');
            return;
        }


        //Create the pizza
        $topping = new Topping;
        $topping->name = $this->toppingName;
        $topping->save();

        Alert::success('Success', "Your topping \"$topping->name\" was created");
        return redirect('/toppings');
    }
    public function render()
    {
        return view('livewire.topping.create-topping')->layout('components.layout');
    }
}
