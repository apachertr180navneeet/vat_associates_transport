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
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-header">Basic Information</h5>
                            </div>
                            <input type="hidden" name="compid" value="{{ $compId }}">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="text" class="form-control" id="date" name="date" value="{{ $currentDate }}" placeholder="Enter Date" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-select" id="type">
                                        <option selected>Select Type</option>
                                        <option value="1">to pay</option>
                                        <option value="2">free of cost</option>
                                        <option value="3">to be billed</option>
                                        <option value="4">paid</option>
                                      </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="branch" class="form-label">Branch</label>
                                    <select class="form-select" id="branch" name="branch">
                                        <option selected>Select Branch</option>
                                        @foreach ( $branchs as $branch)
                                            <option value="{{ $branch->id }}" data-code="{{ $branch->code }}" >{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
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
                                            <input type="text" class="form-control" id="grn" name="grn" value="" placeholder="Enter GR no."/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="consigner" class="form-label">Consigner</label>
                                    <select class="form-select" id="consigner" name="consigner">
                                        <option selected>Select Consigner</option>
                                        @foreach ( $consigners as $consigner)
                                            <option value="{{ $consigner->id }}">{{ $consigner->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="conignee" class="form-label">Conignee</label>
                                    <select class="form-select" id="conignee" name="conignee">
                                        <option selected>Select Conignee</option>
                                        @foreach ( $consignees as $consignee)
                                            <option value="{{ $consignee->id }}">{{ $consignee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="form_city" class="form-label">Form City</label>
                                    <select class="form-select" id="form_city" name="form_city">
                                        <option selected>Select Form City</option>
                                        @foreach ( $cites as $city)
                                            <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="to_city" class="form-label">To City</label>
                                    <select class="form-select" id="to_city" name="to_city">
                                        <option selected>Select To City</option>
                                        @foreach ( $cites as $city)
                                            <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="good_location" class="form-label">Goods location</label>
                                    <select class="form-select" id="good_location" name="good_location">
                                        <option selected>Select Goods location</option>
                                        @foreach ( $branchs as $branch)
                                            <option value="{{ $branch->id }}" >{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_of_package" class="form-label">No. Of Package</label>
                                    <input type="text" class="form-control" id="no_of_package" name="no_of_package" value="" placeholder="Enter No. Of Package"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h5 class="card-header">Add Item</h5>
                            </div>
                            <div class="row item-row" id="addmore">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <select class="form-select item-select item" name="item[]">
                                            <option selected>Select Item</option>
                                            @foreach ( $items as $item)
                                                <option value="{{ $item->id }}" data-itemprice="{{ $item->price }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control freight_charge" name="freight_charge[]" value="" placeholder="Enter Freight Charge"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control surcharge" name="surcharge[]" value="" placeholder="Enter Surcharge"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control cover"name="cover[]" value="" placeholder="Enter Cover"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control h" name="h[]" value="" placeholder="Enter H"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control insurance" name="insurance[]" value="" placeholder="Enter Insurance"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control heading" name="heading[]" value="" placeholder="Enter Heading"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control cps" name="cps[]" value="" placeholder="Enter CPS"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control total" name="total[]" value="" placeholder="Enter Total" readonly/>
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
    
        // Event listener for branch selection change
        $branch.on('change', function () {
            var selectedBranchId = $(this).val();
            // Show all options again before hiding the selected one
            $goodLocation.find('option').show().filter('[value="' + selectedBranchId + '"]').hide();
            // Set branch code in the input field
            var branchCode = $(this).find('option:selected').data('code');
            $branchCode.val(branchCode);
        });
    
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
                            <select class="form-select item-select" name="item[]">
                                <option selected>Select Item</option>
                                @foreach ( $items as $item)
                                    <option value="{{ $item->id }}" data-itemprice="{{ $item->price }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control freight_charge" name="freight_charge[]" value="" placeholder="Enter Freight Charge"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control surcharge" name="surcharge[]" value="" placeholder="Enter Surcharge"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control cover" name="cover[]" value="" placeholder="Enter Cover"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control h" name="h[]" value="" placeholder="Enter H"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control insurance" name="insurance[]" value="" placeholder="Enter Insurance"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control heading" name="heading[]" value="" placeholder="Enter Heading"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <input type="text" class="form-control cps" name="cps[]" value="" placeholder="Enter CPS"/>
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
    
</script>



@endsection
