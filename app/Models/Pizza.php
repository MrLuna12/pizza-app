<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pizza extends Model
{
    use HasFactory;

    //The roles that belong to the Pizzas Model
    public function toppings(): BelongsToMany
    {
        return $this->belongsToMany(Topping::class);
    }


}
