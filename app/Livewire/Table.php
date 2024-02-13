<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

//Table base class that we will use to create the pizza and topping tables.
//It has the logic for sorting the columns of the tables

class Table extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortField = '';
    public $sortDirection = 'desc';


    public function sortBy($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function swapSortDirection() {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }
}
