<?php

namespace App\Livewire\Topping;

use App\Livewire\Table;
use App\Models\Topping;
use RealRashid\SweetAlert\Facades\Alert;

class Toppings extends Table
{
    //Overriding the original $sortField from Table class
    public $sortField = 'updated_at';

    //Var capturing the topping created
    public $newToppingName;

    //Var to capture the id of the topping to delete
    public $toppingIdToDelete;



    //Rules for the form
    protected $rules=[
        'newToppingName' => ['required', 'regex:/^[a-zA-Z\s\'-]+$/']
    ];

    public function createTopping() {
        // Validate the form data
        $this->validate();

        // Checks if Topping name already exists
        $existingTopping = Topping::where('name', ucwords($this->newToppingName))->exists();
        if ($existingTopping) {
            session()->flash('name_error', 'That topping already exists.');
            return;
        }

        //Create the topping
        $topping = new Topping;
        $topping->name = ucwords($this->newToppingName);
        $topping->created_at = now();
        $topping->save();

        Alert::toast("Topping \"$topping->name\" was created", 'success');
        return redirect('/toppings');
    }

    public function delete($id) {
        $this->toppingIdToDelete = $id;
        $this->dispatch('show-confirm-modal');
    }

    public function deleteTopping() {
        $topping = Topping::find($this->toppingIdToDelete);
        $topping->pizzas()->detach();
        $topping->delete();
        $this->toppingIdToDelete = null;

        Alert::toast("Topping \"$topping->name\" was delete", 'success');
        return redirect('/toppings');
    }

    public function render()
    {
        $toppings = Topping::orderBy($this->sortField, $this->sortDirection)->paginate(10);
        return view('livewire.topping.toppings', compact('toppings'))->layout('components.layout');
    }
}
