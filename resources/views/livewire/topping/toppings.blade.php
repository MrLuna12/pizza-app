<div>
    <div class="container">
        <h1 class="mt-3">Create a Topping</h1>

        {{--  Error Messages  --}}
        @if(session()->has('name_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('name_error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Create Topping Form --}}
        <form wire:submit.prevent="createTopping">
            <div class="input-group">
                <input wire:model="newToppingName" type="text" class="form-control" placeholder="Cheese...">
                <button class="btn btn-outline-primary" type="submit">Save</button>
            </div>
            <div class="mb-4">
                @error('newToppingName') <p class="text-danger">{{ $message }}</p> @enderror
            </div>
        </form>

        <h3>Toppings</h3>

        {{-- Table Displaying all created Toppings --}}
        <table class="table table-hover">
            <caption>List of Toppings</caption>
            <thead>
            <tr>
                <th wire:click="sortBy('name')">
                    Name
                    <i class="bi bi-arrow-up {{$sortField === 'name' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                    <i class="bi bi-arrow-down {{$sortField === 'name' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                </th>
                <th wire:click="sortBy('updated_at')">
                    Date
                    <i class="bi bi-arrow-up {{$sortField === 'updated_at' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                    <i class="bi bi-arrow-down {{$sortField === 'updated_at' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                </th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach($toppings as $topping)
                <tr>
                    <td>{{$topping->name}}</td>
                    <td>{{$topping->updated_at->format('m-d-Y')}}</td>
                    <td>
                        <a class="btn btn-outline-secondary" href="/toppings/edit/{{$topping->id}}">Edit</a>
{{--                        <a class="btn btn-outline-secondary">Edit</a>--}}


                        <button wire:click="delete({{$topping->id}})" class="btn btn-outline-danger">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            {{ $toppings->links() }}
        </div>
    </div>
</div>

{{-- Script for the confirmation alert --}}

@push('scripts')
    <script>
        Livewire.on('show-confirm-modal', () => {
            Swal.fire({
                title: 'STOP',
                text: 'Are you sure you want to delete this topping? This topping will be deleted from existing pizzas',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                @this.call('deleteTopping');
                } else {
                    window.location.href = '/toppings';
                }
            });
        });
    </script>
@endpush
