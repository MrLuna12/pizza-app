<?php

namespace App\Livewire\Topping;

use App\Models\Topping;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditTopping extends Component
{
    //Store the topping model
    public $topping;

    //var storing the current name to use for updating
    public $toppingName;

    //var storing old name to compare to the new updated one
    public $oldToppingName;

    //check to see if the form was edited
    public $isEdit;

    //Rules for the form
    protected $rules=[
        'toppingName' => ['required', 'regex:/^[a-zA-Z\s\'-]+$/']
    ];

    //Use mount to find and initialize the topping component
    public function mount ($id) {

        //Find the topping by its id
        $this->topping = Topping::find($id);

        //Form status
        $this->isEdit = false;

        //Check if the topping exist
        if ($this->topping) {

            //Initialize toppingName with the name of the topping
            $this->toppingName = $this->topping->name;
            $this->oldToppingName = $this->toppingName;

        } else {
            //If the topping doesn't exist
            Alert::error('404', 'Topping not found');
            $this->redirect('/toppings');
        }
    }

    //Check if the form has been edited
    public function isFormEdit() {
        $this->isEdit = true;
    }

    public function goBack()
    {
        if ($this->isEdit) {
            $this->dispatch('show-confirm-modal');
        } else {
            redirect('/toppings');
        }
    }

    public function updateTopping() {
        // Validate the form data
        $this->validate();

        //Checks to see if the user changed the current name of the topping.
        //If so, check if that name already exist in the database
        if (ucwords($this->toppingName) != $this->oldToppingName) {
            // Checks if topping name already exists
            $existingTopping = Topping::where('name', $this->toppingName)->exists();
            if ($existingTopping) {
                session()->flash('name_error', 'That topping already exists.');
                return;
            }
        } else{
            $this->toppingName = $this->oldToppingName;
            return redirect('/toppings');
        }

        $this->topping->name = ucwords($this->toppingName);
        $this->topping->updated_at->now();
        $this->topping->save();

        Alert::success('Success', "Your topping was updated");
        return redirect('/toppings');
    }

    public function render()
    {
        return view('livewire.topping.edit-topping')->layout('components.layout');
    }
}
