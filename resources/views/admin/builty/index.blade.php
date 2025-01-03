@extends('admin.layouts.app') @section('style') @endsection @section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6 text-start">
            <h5 class="py-2 mb-2">
                <span class="text-primary fw-light">Booking Builty List</span>
            </h5>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.builty.add') }}" class="btn btn-primary">
                Add Builty
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered" id="builtyTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>G.R. No.</th>
                                    <th>Branch</th>
                                    <th>Consigner</th>
                                    <th>Consignee</th>
                                    <th>From City</th>
                                    <th>To City</th>
                                    <th>No. Of Package</th>
                                    <th>Charges</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($builtys as $builty)    
                                    <tr>
                                        <td>{{ $builty->date }}</td>
                                        <td>{{ $builty->branch_code }}-{{ $builty->grno }}</td>
                                        <th>{{ $builty->branch_name }}</th>
                                        <th>{{ $builty->consigner_name }}</th>
                                        <th>{{ $builty->conignee_name }}</th>
                                        <th>{{ $builty->from_name }}</th>
                                        <th>{{ $builty->to_name }}</th>
                                        <th>{{ $builty->no_of_package }}</th>
                                        <th>{{ $builty->total_price }}</th>
                                        <th>
                                            @if ($builty->status == 'delivered')
                                                <span class="badge bg-label-success me-1">Delivered</span>    
                                            @else
                                                <span class="badge bg-label-warning me-1">Pending</span>
                                            @endif
                                        </th>
                                        <th>
                                            {{--  <a href="{{ route('admin.builty.edit', $builty->id ) }}" class="btn btn-sm btn-warning">Edit</a>  --}}
                                            <a href="{{ route('admin.builty.report', $builty->id ) }}" class="btn btn-sm btn-info">Report</a>
                                            {{--   <a href="" class="btn btn-sm btn-warning">SMS</a>  --}}

                                            @if ($builty->status == 'pending')
                                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser({{ $builty->id }})">Delete</button>
                                                @if ($builty->status == 'pending')
                                                    <button type="button" class="btn btn-sm btn-success" onclick="updateUserStatus({{ $builty->id }} , 'delivered')">Delivered</button>    
                                                @else
                                                    <button type="button" class="btn btn-sm btn-warning" onclick="updateUserStatus({{ $builty->id }} , 'pending')">Pending</button>
                                                @endif
                                            @endif
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection @section('script')
<script>
    $(document).ready(function() {
        const table = $('#builtyTable').DataTable({
            processing: true,
        });

        // Delete user
        window.deleteUser = function(userId) {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to delete this Builty?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    const url = '{{ route("admin.builty.destroy", ":userId") }}'.replace(":userId", userId);
                    $.ajax({
                        type: "DELETE",
                        url,
                        data: { _token: $('meta[name="csrf-token"]').attr('content') },
                        success: function (response) {
                            if (response.success) {
                                setFlash("success", "Builty deleted successfully.");
                            } else {
                                setFlash("error", "There was an issue deleting the dealer. Please contact your system administrator.");
                            }
                            window.location.reload();
                        },
                        error: function () {
                            setFlash("error", "There was an issue processing your request. Please try again later.");
                        },
                    });
                }
            });
        };

        // Update user status
        window.updateUserStatus = function(userId, status) {
            const message = status === "pending" ? "Builty will be  pending." : "Builty will be delivered.";

            Swal.fire({
                title: "Are you sure?",
                text: message,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Okay",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.builty.status') }}",
                        data: { userId, status, _token: $('meta[name="csrf-token"]').attr('content') },
                        success: function (response) {
                            if (response.success) {
                                const successMessage = status === "pending" ? "Builty pending successfully." : "Builty delivered successfully.";
                                setFlash("success", successMessage);
                            } else {
                                setFlash("error", "There was an issue changing the status. Please contact your system administrator.");
                            }
                            window.location.reload();
                        },
                        error: function () {
                            setFlash("error", "There was an issue processing your request. Please try again later.");
                        },
                    });
                } else {
                    table.ajax.reload();
                }
            });
        };

        // Flash message function using Toast.fire
        function setFlash(type, message) {
            Toast.fire({
                icon: type,
                title: message
            });
        }
    });
</script>
@endsection
