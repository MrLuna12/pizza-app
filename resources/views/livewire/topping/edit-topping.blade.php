<div>
    <button class="btn mb-3" wire:click.prevent="goBack">
        <i class="bi bi-backspace"> Go Back</i>
    </button>
    <h1>Edit Topping</h1>
    {{--  Error Messages  --}}
    @if(session()->has('name_error'))
        <div class="alert alert-danger">{{ session('name_error') }}</div>
    @endif

        <form wire:submit.prevent="updateTopping" wire:click="isFormEdit">
            <div class="col-4 mb-3">
                <label for="toppingName" class="form-label">Topping Name</label>
                <input wire:model.defer="toppingName" type="text" class="form-control mb-3" id="toppingName">
                @error('toppingName') <p class="text-danger">{{ $message }}</p> @enderror
                <button type="submit" class="btn btn-outline-primary">Save</button>
            </div>
        </form>

    @push('scripts')
        {{-- Confirmation Sctipt for alert --}}
        <script>
            Livewire.on('show-confirm-modal', () => {
                Swal.fire({
                    title: 'Save Changes?',
                    text: 'Do you want to save your changes?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                    @this.call('updateTopping');
                    } else {
                        window.location.href = '/toppings';
                    }
                });
            });
        </script>
    @endpush
</div>
