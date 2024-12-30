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
                        <table class="table table-bordered" id="branchTable">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
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
                                <tr>
                                    <td>1.</td>
                                    <td>12/05/2024</td>
                                    <td>1236547890</td>
                                    <th>Branch 1</th>
                                    <th>Consigner 1</th>
                                    <th>Consignee 1</th>
                                    <th>Jodhpur</th>
                                    <th>Jaipur</th>
                                    <th>10</th>
                                    <th>1000</th>
                                    <th>Pending</th>
                                    <th>Action</th>
                                </tr>
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
</script>
@endsection
