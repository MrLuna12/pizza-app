<div>
    <div>
        <div class="container">
            <h1>Create a Pizza</h1>

            {{--  Error Messages  --}}
            @if(session()->has('name_error'))
                <div class="alert alert-danger">{{ session('name_error') }}</div>
            @endif

            {{--Form--}}
            <form wire:submit.prevent="savePizza">
                <div class="col-12 mb-3">
                    {{-- Name Input --}}
                    <label for="name" class="form-label">1. Pizza Name</label>
                    <input wire:model="pizzaName" type="text" class="form-control" id="name" placeholder="My Favorite...">
                    @error('pizzaName') <p class="text-danger">{{ $message }}</p> @enderror
                </div>

                <div class="col-12 mb-3">
                    {{-- Sauce Input --}}
                    2. Sauce
                    <div class="form-check">
                        <input wire:model="isSauceSelected" class="form-check-input" type="radio" name="sauce" id="yesSauce" value="1" checked>
                        <label class="form-check-label" for="yesSauce">
                            Tomato Sauce
                        </label>
                    </div>
                    <div class="form-check">
                        <input wire:model="isSauceSelected" class="form-check-input" type="radio" name="sauce" id="noSauce" value="0">
                        <label class="form-check-label" for="noSauce">
                            No Tomato Sauce
                        </label>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    {{-- Cheese Input --}}
                    3. Cheese
                    <div class="form-check">
                        <input wire:model="isCheeseSelected" class="form-check-input" type="radio" name="cheese" id="yesCheese" value="1" checked>
                        <label class="form-check-label" for="yesCheese">
                            Cheese
                        </label>
                    </div>
                    <div class="form-check">
                        <input wire:model="isCheeseSelected" class="form-check-input" type="radio" name="cheese" id="noCheese" value="0">
                        <label class="form-check-label" for="noCheese">
                            No Cheese
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    {{-- Toppings Input --}}
                    4. Select Toppings
                    @foreach($toppings as $topping)
                        <ul class="list-group">
                            <li class="list-group-item">
                                <input wire:model="selectedToppings" class="form-check-input me-1" type="checkbox" id="{{$topping->id}}" value="{{$topping->id}}">
                                <label class="form-check-label" for="{{$topping->name}}">
                                    {{$topping->name}}
                                </label>
                            </li>
                        </ul>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
