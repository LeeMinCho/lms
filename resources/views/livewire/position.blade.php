<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Position</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <button wire:click="create()" class="btn btn-primary mb-3" data-toggle="modal"
                    data-target="#positionModal">
                    <i class="fas fa-plus"></i> Add
                </button>
                <div class="row justify-content-end">
                    <div class="col-3">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm" name="search" placeholder="Search"
                                wire:model="search">
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Position Code</th>
                            <th>Position Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->position_code }}</td>
                            <td>{{ $item->position_name }}</td>
                            <td>
                                <button class="btn btn-warning" data-toggle="modal" data-target="#positionModal"
                                    wire:click="edit({{ $item->position_id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger"
                                    wire:click="$emit('deletePosition', {{ $item->position_id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">Data Not Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="row mt-3">
                    <div class="col-6">
                        <i>Total Record: {{ $count_data }} @if ($search)
                            Filtered: {{ $data->total() }}
                            @endif</i>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            {!! $data->links() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>

    <div class="modal fade" data-backdrop="static" id="positionModal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        @if ($isUpdate)
                        Edit Position
                        @else
                        Create Position
                        @endif
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label for="position_code">Position Code</label>
                        <input type="text" class="form-control {{ $errors->has('position_code') ? 'is-invalid' : '' }}"
                            name="position_code" id="position_code" wire:model="position_code">
                        @error('position_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="position_name">Position Name</label>
                        <input type="text" class="form-control {{ $errors->has('position_name') ? 'is-invalid' : '' }}"
                            name="position_name" id="position_name" wire:model="position_name">
                        @error('position_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    @if ($isUpdate)
                    <button type="button" class="btn btn-primary" wire:click.prevent="update()">Update</button>
                    @else
                    <button type="button" class="btn btn-primary" wire:click.prevent="store()">Save</button>
                    @endif
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    @push('scripts')
    <script>
        window.livewire.on('positionDataChange', (message) => {
            $('#positionModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message,
                showConfirmButton: false,
                timer: 2000,
            });
        });

        window.livewire.on('deletePosition', (positionId) => {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert it",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('destroy', positionId);
                }
            });
        });
    </script>
    @endpush
</div>