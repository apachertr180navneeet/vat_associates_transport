@extends('admin.layouts.app') @section('style') @endsection @section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6 text-start">
            <h5 class="py-2 mb-2">
                <span class="text-primary fw-light">Builty</span>
            </h5>
        </div>
        <div class="col-md-6 text-end">
            
        </div>
    </div>
    <div class="row">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row invoice-preview">
                <!-- Invoice -->
                <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4" id="printIt">
                    <div class="card invoice-preview-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column p-sm-3 p-0">
                                <div class="mb-xl-0 mb-4">
                                    <div class="d-flex svg-illustration mb-3 gap-2">
                                        <span class="app-brand-text demo text-body fw-bold">{{ $firm->firm_name}}</span>
                                    </div>
                                    <p class="mb-1">{{ $firm->address}}</p>
                                    <p class="mb-1">{{ $firm->city}}, {{ $firm->state}}, India</p>
                                    <p class="mb-0">+91 - {{ $firm->phone}}</p>
                                </div>
                                <div>
                                    <h4>G. R. No. :-  {{ $builty->branch_code }}-{{ $builty->grno }}</h4>
                                    <div class="mb-2">
                                        <span class="me-1">Date Issues:</span>
                                        <span class="fw-medium">{{ $builty->date }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row p-sm-3 p-0">
                                <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                                    <h6 class="pb-2">Consignee:</h6>
                                    <p class="mb-1">{{ $builty->conignee_name }}</p>
                                    <p class="mb-1">{{ $builty->conignee_contact }}</p>
                                    <p class="mb-0">{{ $builty->conignee_email }}</p>
                                </div>
                                <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                    <h6 class="pb-2">Consigner:</h6>
                                    <p class="mb-1">{{ $builty->consigner_name }}</p>
                                    <p class="mb-1">{{ $builty->consigner_contact }}</p>
                                    <p class="mb-0">{{ $builty->consigner_email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table border-top m-0">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Freight Charge</th>
                                        <th>Surcharge</th>
                                        <th>Cover</th>
                                        <th>H</th>
                                        <th>Insurance</th>
                                        <th>Heading</th>
                                        <th>CPS</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($builtyItems as $builtyItem)
                                        
                                    @endforeach
                                    <tr>
                                        <td class="text-nowrap">{{ $builtyItem->item_name }}({{ $builtyItem->item_skucode }})</td>
                                        <td>{{ $builtyItem->freight_charge }}</td>
                                        <td>{{ $builtyItem->surcharge }}</td>
                                        <td>{{ $builtyItem->cover }}</td>
                                        <td>{{ $builtyItem->h }}</td>
                                        <td>{{ $builtyItem->insurance }}</td>
                                        <td>{{ $builtyItem->heading }}</td>
                                        <td>{{ $builtyItem->cps }}</td>
                                        <td>{{ $builtyItem->total }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="align-top px-4 py-5">
                                            <p class="mb-2">
                                                <span class="me-1 fw-medium">Builty By:</span>
                                                <span>{{ $user->full_name }}</span>
                                            </p>
                                            <span>Thanks for your business</span>
                                        </td>
                                        <td class="px-4 py-5">
                                            <p class="mb-2">No. Of package:</p>
                                            <p class="mb-0">Total:</p>
                                        </td>
                                        <td class="px-4 py-5">
                                            <p class="fw-medium mb-2">{{ $builty->no_of_package }}</p>
                                            <p class="fw-medium mb-0">{{ $builty->total_price }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <span class="fw-medium">Note:</span>
                                    <span>It was a pleasure working with you and your team. We hope you will keep us in mind for future freelance projects. Thank You!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Invoice -->

                <!-- Invoice Actions -->
                <div class="col-xl-3 col-md-4 col-12 invoice-actions">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary d-grid w-100 mb-3" id="printInvoice">
                                <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="bx bx-printer bx-xs me-1"></i>Print</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /Invoice Actions -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function(){
        $('#printInvoice').on('click', function() {
            var printContents = $('#printIt').html();
            var originalContents = $('body').html(); // Store original content

            // Replace the body content with print contents
            $('body').html(printContents);

            // Trigger the print dialog
            window.print();

            // Restore the original content
            $('body').html(originalContents);

            // Rebind the event listener
            window.location.reload(); // Reload the page to restore events and scripts
        });
    });
</script>
@endsection

