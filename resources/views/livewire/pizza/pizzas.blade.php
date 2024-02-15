<div>
    <div class="container">
        {{-- Button To create Pizza --}}
        <a class="btn btn-outline-primary float-end mb-3" href="/pizzas/create" role="button">
            <i class="bi bi-plus-circle" ></i>
            New Pizza
        </a>

        <h1>Pizzas</h1>
        <div class="table-responsive">
            {{-- Table Displaying all created pizzas --}}
            <table class="table table-hover">
                <caption>List of Pizzas</caption>
                <thead>
                <tr>
                    <th wire:click="sortBy('name')">
                        Name
                        <i class="bi bi-arrow-up {{$sortField === 'name' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                        <i class="bi bi-arrow-down {{$sortField === 'name' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                    </th>
                    <th>Sauce</th>
                    <th>Cheese</th>
                    <th>Toppings</th>
                    <th wire:click="sortBy('updated_at')">
                        Date
                        <i class="bi bi-arrow-up {{$sortField === 'updated_at' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                        <i class="bi bi-arrow-down {{$sortField === 'updated_at' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                    </th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($pizzas as $pizza)
                    <tr>
                        {{-- Name Data --}}
                        <td>{{$pizza->name}}</td>

                        {{-- Sauce Data --}}
                        <td>
                            @if($pizza->sauce == 1)
                                Tomato Sauce
                            @else
                                No Tomato Sauce
                            @endif
                        </td>

                        {{-- Cheese Data --}}
                        <td>
                            @if($pizza->cheese == 1)
                                Cheese
                            @else
                                No Cheese
                            @endif
                        </td>

                        {{-- Topping Data --}}
                        <td>
                            <ul>
                                @foreach ($pizza->toppings as $topping)
                                    <li>{{ $topping->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        {{-- Date Data --}}
                        <td>{{$pizza->updated_at->format('m-d-Y')}}</td>

                        {{-- Action Data --}}
                        <td>
                            <a class="btn btn-outline-secondary" href="/pizzas/edit/{{$pizza->id}}">Edit</a>
                            <button wire:click="delete({{$pizza->id}})" class="btn btn-outline-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {{ $pizzas->links() }}
        </div>
    </div>
</div>

{{-- Script for the confirmation alert --}}

@push('scripts')
    <script>
        Livewire.on('show-confirm-modal', () => {
            Swal.fire({
                title: 'STOP',
                text: 'Are you sure you want to delete this pizza',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                @this.call('deletePizza');
                } else {
                    window.location.href = '/pizzas';
                }
            });
        });
    </script>
@endpush
