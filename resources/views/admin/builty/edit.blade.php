@extends('admin.layouts.app') @section('style') @endsection @section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6 text-start">
            <h5 class="py-2 mb-2">
                <span class="text-primary fw-light">Booking Builty Add</span>
            </h5>
        </div>
        <div class="col-md-6 text-end">
            
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form role="form" action="{{ route('admin.builty.store') }}" method="post" id="coustomer_add" enctype="multipart/form-data">
                        @csrf
                        <!-- Display Error Message -->
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-header">Basic Information</h5>
                            </div>
                            <input type="hidden" name="builtyid" value="{{ $builty->id }}">
                            <input type="hidden" name="compid" value="{{ $compId }}">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="text" class="form-control" id="date" name="date" value="{{ $builty->date }}" placeholder="Enter Date" readonly/>
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="to_pay" {{ $builty->type == 'to_pay' ? 'selected' : '' }}>to pay</option>
                                        <option value="free_of_cost" {{ $builty->type == 'free_of_cost' ? 'selected' : '' }}>free of cost</option>
                                        <option value="to_be_billed" {{ $builty->type == 'to_be_billed' ? 'selected' : '' }}>to be billed</option>
                                        <option value="paid" {{ $builty->type == 'paid' ? 'selected' : '' }}>paid</option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="branch" class="form-label">Branch</label>
                                    <select class="form-select" id="branch" name="branch" required>
                                        <option value="">Select Branch</option>
                                        @foreach ( $branchs as $branch)
                                            <option value="{{ $branch->id }}" data-code="{{ $branch->code }}" {{ $builty->branch == $branch->id ? 'selected' : '' }} >{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="branch" class="form-label">G.R NO.</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="branch_code" name="branch_code" placeholder="Enter Branch Code" readonly/>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="grn" name="grn" value="{{ $builty->grno }}" placeholder="Enter GR no." required/>
                                            @error('grn')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="consigner" class="form-label">Consigner</label>
                                    <select class="form-select" id="consigner" name="consigner" required>
                                        <option value="">Select Consigner</option>
                                        @foreach ( $consigners as $consigner)
                                            <option value="{{ $consigner->id }}" {{ $builty->consigner == $consigner->id ? 'selected' : '' }}>{{ $consigner->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('consigner')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="conignee" class="form-label">Conignee</label>
                                    <select class="form-select" id="conignee" name="conignee" required>
                                        <option value="">Select Conignee</option>
                                        @foreach ( $consignees as $consignee)
                                            <option value="{{ $consignee->id }}" {{ $builty->conignee == $consignee->id ? 'selected' : '' }}>{{ $consignee->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('conignee')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="form_city" class="form-label">Form City</label>
                                    <select class="form-select" id="form_city" name="form_city" required>
                                        <option value="">Select Form City</option>
                                        @foreach ( $cites as $city)
                                            <option value="{{ $city->id }}" {{ $builty->from_city == $city->id ? 'selected' : '' }}>{{ $city->city_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('form_city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="to_city" class="form-label">To City</label>
                                    <select class="form-select" id="to_city" name="to_city" required>
                                        <option value="">Select To City</option>
                                        @foreach ( $cites as $city)
                                            <option value="{{ $city->id }}" {{ $builty->to_city == $city->id ? 'selected' : '' }}>{{ $city->city_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('to_city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="good_location" class="form-label">Goods location</label>
                                    <select class="form-select" id="good_location" name="good_location" required>
                                        <option value="">Select Goods location</option>
                                        @foreach ( $branchs as $branch)
                                            <option value="{{ $branch->id }}" {{ $builty->good_location == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('good_location')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_of_package" class="form-label">No. Of Package</label>
                                    <input type="text" class="form-control" id="no_of_package" name="no_of_package" value="" placeholder="Enter No. Of Package" required/>
                                    @error('no_of_package')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h5 class="card-header">Add Item</h5>
                            </div>
                            <div class="row item-row" id="addmore">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <select class="form-select item-select item" name="items[]" required>
                                            <option value="">Select Item</option>
                                            @foreach ( $items as $item)
                                                <option value="{{ $item->id }}" data-itemprice="{{ $item->price }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('item.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control freight_charge" name="freight_charge[]" value="" placeholder="Enter Freight Charge" required/>
                                        @error('freight_charge.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control surcharge" name="surcharge[]" value="" placeholder="Enter Surcharge" required/>
                                        @error('surcharge.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control cover" name="cover[]" value="" placeholder="Enter Cover" required/>
                                        @error('cover.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control h" name="h[]" value="" placeholder="Enter H" required/>
                                        @error('h.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control insurance" name="insurance[]" value="" placeholder="Enter Insurance" required/>
                                        @error('insurance.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control heading" name="heading[]" value="" placeholder="Enter Heading" required/>
                                        @error('heading.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control cps" name="cps[]" value="" placeholder="Enter CPS" required/>
                                        @error('cps.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control total" name="total[]" value="" placeholder="Enter Total" readonly/>
                                        @error('total.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <button type="button" class="btn rounded-pill btn-info" id="additem">+ Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4 text-end">
                                    <label for="total_price" class="form-label">Total Price</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="total_price" name="total_price" value="" placeholder="Enter Total Price" readonly/>
                                    @error('total_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection @section('script')

<script>
    $(document).ready(function () {
        var $branch = $('#branch');
        var $goodLocation = $('#good_location');
        var $branchCode = $('#branch_code');
        var $formCity = $('#form_city');
        var $toCity = $('#to_city');
        var $noOfPackage = $('#no_of_package');
        var $addMore = $("#addmore");
        var $totalAmount = $('#totalAmount'); // To display the overall total

        // Event listener for form_city selection change
        $formCity.on('change', function () {
            var selectedFormCity = $(this).val(); // Get the selected form city value
            // Remove the selected city from the to_city dropdown
            $toCity.find('option[value="' + selectedFormCity + '"]').remove();
        });

        // Set the input field to readonly and restrict to numbers
        $noOfPackage.on('input', function () {
            var numericValue = $(this).val().replace(/[^0-9]/g, ''); // Remove non-numeric characters
            $(this).val(numericValue); // Set the value back to the input
        });

        // Add new item on button click
        $("#additem").click(function () {
            var newItem = `
                <div class="row item-row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <select class="form-select item-select" name="items[]" required>
                                <option selected>Select Item</option>
                                @foreach ( $items as $item)
                                    <option value="{{ $item->id }}" data-itemprice="{{ $item->price }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control freight_charge" name="freight_charge[]" value="" placeholder="Enter Freight Charge" required/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control surcharge" name="surcharge[]" value="" placeholder="Enter Surcharge" required/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control cover" name="cover[]" value="" placeholder="Enter Cover" required/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control h" name="h[]" value="" placeholder="Enter H" required/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control insurance" name="insurance[]" value="" placeholder="Enter Insurance" required/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control heading" name="heading[]" value="" placeholder="Enter Heading" required/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control cps" name="cps[]" value="" placeholder="Enter CPS" required/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control total" name="total[]" value="" placeholder="Enter Total" readonly/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <button type="button" class="btn btn-danger rounded-pill remove-item">- Remove</button>
                        </div>
                    </div>
                </div>
            `;
            // Append the new item div to the addmore section
            $addMore.append(newItem);
        });

        // Event listener for remove item button
        $(document).on('click', '.remove-item', function () {
            $(this).closest('.item-row').remove();
            // Recalculate the total price
            calculateTotalPrice();
        });

        // Update total value on input change
        $(document).on('input', '.freight_charge, .surcharge, .cover, .h, .insurance, .heading, .cps, .item-select', function () {
            var $row = $(this).closest('.item-row');

            // Get the price of the selected item
            var itemPrice = parseFloat($row.find('.item-select option:selected').data('itemprice')) || 0;

            // Get other input values
            var freight = parseFloat($row.find('.freight_charge').val()) || 0;
            var surcharge = parseFloat($row.find('.surcharge').val()) || 0;
            var cover = parseFloat($row.find('.cover').val()) || 0;
            var h = parseFloat($row.find('.h').val()) || 0;
            var insurance = parseFloat($row.find('.insurance').val()) || 0;
            var heading = parseFloat($row.find('.heading').val()) || 0;
            var cps = parseFloat($row.find('.cps').val()) || 0;

            // Calculate the total
            var total = itemPrice + freight + surcharge + cover + h + insurance + heading + cps;

            // Update the total input field in the row
            $row.find('.total').val(total.toFixed(2));


             // Recalculate the total price
             calculateTotalPrice();
        });


        // Calculate the total price whenever inputs change
        function calculateTotalPrice() {
            let totalPrice = 0;

            // Loop through each '.total' input field and add its value to totalPrice
            $('.total').each(function () {
                let totalVal = parseFloat($(this).val()) || 0; // Parse value or default to 0
                totalPrice += totalVal;
            });

            // Set the calculated total price in the 'total_price' field
            $('#total_price').val(totalPrice.toFixed(2)); // Display with 2 decimal places
        }
    });

    $(document).ready(function () {
        // Function to update branch code on page load
        function updateBranchCode() {
            var selectedBranch = $("#branch").find(":selected");
            var branchCode = selectedBranch.data("code");
            $("#branch_code").val(branchCode || '');
        }
    
        // Initial update in case a branch is pre-selected
        updateBranchCode();
    
        // Update branch code on branch selection change
        $("#branch").change(function () {
            updateBranchCode();
        });
    });    
</script>
@endsection
