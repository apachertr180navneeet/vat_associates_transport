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
                                        <td>{{ $builty->grno }}</td>
                                        <th>{{ $builty->branch_name }}</th>
                                        <th>{{ $builty->consigner_name }}</th>
                                        <th>{{ $builty->conignee_name }}</th>
                                        <th>{{ $builty->from_name }}</th>
                                        <th>{{ $builty->to_name }}</th>
                                        <th>{{ $builty->no_of_package }}</th>
                                        <th>{{ $builty->total_price }}</th>
                                        <th>
                                            @if ($builty->total_price == 'delivered')
                                                <span class="badge bg-label-success me-1">Delivered</span>    
                                            @else
                                                <span class="badge bg-label-warning me-1">Pending</span>
                                            @endif
                                        </th>
                                        <th>
                                            <a href="" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="" class="btn btn-sm btn-warning">Report</a>
                                            <a href="" class="btn btn-sm btn-warning">SMS</a>
                                            <a href="" class="btn btn-sm btn-danger">Delete</a>
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
    });
</script>
@endsection
