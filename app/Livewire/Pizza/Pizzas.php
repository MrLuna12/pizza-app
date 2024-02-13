<?php

namespace App\Livewire\Pizza;

use App\Livewire\Table;
use App\Models\Pizza;
use RealRashid\SweetAlert\Facades\Alert;


class Pizzas extends Table
{
    //Specifying the default field to sort by
    public $sortField = 'updated_at';
    public $pizzaIdToDelete;

    public function delete($id) {
        $this->pizzaIdToDelete = $id;
        $this->dispatch('show-confirm-modal');
    }

    public function deletePizza() {
        $pizza = Pizza::find( $this->pizzaIdToDelete);
        $pizza->toppings()->detach();
        $pizza->delete();
        $this->pizzaIdToDelete = null;

        Alert::toast("Pizza \"$pizza->name\" was delete", 'success');
        return redirect('/pizzas');
    }

    public function render()
    {
        $pizzas = Pizza::with('toppings')->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
        return view('livewire.pizza.pizzas', compact('pizzas'))->layout('components.layout');
    }
}
