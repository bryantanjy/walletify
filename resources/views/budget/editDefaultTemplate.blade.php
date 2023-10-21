<div id="editDefaultBudgetModal" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="editDefaultBudgetModalLabel" aria-hidden="true">
    <div class="modal-dialog relative p-4 w-full h-full md:h-auto" role="document">
        {{-- Modal Content --}}
        <div class="modal-content-l relative p-4 bg-white rounded-lg shadow sm:p-5">
            <div class="modal-header flex justify-between items-center">
                <h2 style="font-size:20px;"><b>Edit Default Budget</b></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body flex flex-col">
                <form id="budget_form" method="POST" action="{{ route('budget.update') }}">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <input type="hidden" name="budget_form" value="1">
                
                    <label for="part_input">Total Budget Allocation</label>
                    <input class="rounded-md text-right mx-3" type="number" name="totalBudget" id="totalBudget"
                        step="0.01" style="height: 30px; width:150px" placeholder="e.g. 1000" required>
                    <button type="submit" id="setAllocation" class="bg-green-400 rounded"
                        style="width: 80px;height: 30px;">Set</button>
                    <div id="totalBudgetError" class="text-red-500"></div>
                
                    
                    {{-- Part 1 --}}
                    <h4 style="font-size:20px; margin-top:25px"><b>Part 1 (50%)</b></h4>
                    <div class="flex items-center">
                        <label for="partName1" class="w-32 pr-2 mt-4">Name</label>
                        <input class="rounded-md" type="text" name="part_name[]" id="part1_name" placeholder="Name"
                            style="height: 30px; margin:15px 0px 0px 20px;width:175px;" value="Needs" readonly>
                    </div>
                    <div class="flex items-center">
                        <label for="partAmount1" class="w-32 pr-2 mt-4">Amount</label>
                        <input class="rounded-md" type="number" step="0.01" name="allocation_amount[]"
                            id="part1Amount" placeholder="0.00"
                            style="height: 30px; margin:15px 0px 0px 20px;text-align:right;width:175px;" readonly
                            required>
                    </div>
                    <div class="flex">
                        <label for="partCategory1" class="w-32 pr-2 mt-4">Category</label>
                        <select lass="rounded-md" name="category_id[1][]" id="category_id1" multiple disabled>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}"
                                    @if (in_array($category->category_name, [
                                            'Housing',
                                            'Transportation',
                                            'Utilities',
                                            'Food & Drink',
                                            'Health & Fitness',
                                            'Education',
                                        ])) selected @endif>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div id="part1AmountError" class="text-red-500"></div>

                    {{-- Part 2 --}}
                    <h4 style="font-size:20px; margin-top:25px"><b>Part 2 (30%)</b></h4>
                    <div class="flex items-center">
                        <label for="partName2" class="w-32 pr-2 mt-4">Name</label>
                        <input class="rounded-md" type="text" name="part_name[]" id="part2_name" placeholder="Name"
                            style="height: 30px; margin:15px 0px 0px 20px;width:175px;" value="Wants" readonly>
                    </div>
                    <div class="flex items-center">
                        <label for="partAmount2" class="w-32 pr-2 mt-4">Amount</label>
                        <input class="rounded-md" type="number" step="0.01" name="allocation_amount[]"
                            id="part2Amount" placeholder="0.00"
                            style="height: 30px; margin:15px 0px 0px 20px;text-align:right;width:175px;" readonly
                            required>
                    </div>
                    <div class="flex">
                        <label for="partCategory2" class="w-32 pr-2 mt-4">Category</label>
                        <select class="rounded-md" name="category_id[2][]" id="category_id2" multiple disabled>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}"
                                    @if (in_array($category->category_name, ['Shopping', 'Entertainment', 'Travel', 'Personal Care', 'Miscellaneous'])) selected @endif>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div id="part2AmountError" class="text-red-500"></div>

                    {{-- Part 3 --}}
                    <h4 style="font-size:20px; margin-top:25px"><b>Part 3 (20%)</b></h4>
                    <div class="flex items-center">
                        <label for="partName3" class="w-32 pr-2 mt-4">Name</label>
                        <input class="rounded-md" type="text" name="part_name[]" id="part3_name"
                            placeholder="Name" style="height: 30px; margin:15px 0px 0px 20px;width:175px;"
                            value="Savings" readonly>
                    </div>
                    <div class="flex items-center">
                        <label for="partAmount3" class="w-32 pr-2 mt-4">Amount</label>
                        <input class="rounded-md" type="number" step="0.01" name="allocation_amount[]"
                            id="part3Amount" placeholder="0.00"
                            style="height: 30px; margin:15px 0px 0px 20px;text-align:right;width:175px;" readonly
                            required>
                    </div>
                    <div class="flex">
                        <label for="partCategory3" class="w-32 pr-2 mt-4">Category</label>
                        <select class="rounded-md" name="category_id[3][]" id="category_id3" multiple disabled>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}"
                                    @if (in_array($category->category_name, ['Investments', 'Gift & Donations', 'Income'])) selected @endif>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div id="part3AmountError" class="text-red-500"></div>

                    <input type="hidden" name="template_name" id="template_name" value="Default Template">

                    <div class="float-right mt-4">
                        <button type="submit" class="bg-blue-400 rounded hover:bg-blue-300"
                            style="width: 100px">Save</button>
                        <button data-dismiss="modal" class="border bg-white rounded hover:bg-gray-100"
                            style="width: 100px; margin-left:10px">Cancel</button>
                    </div>
                </form>
                @if ($errors->any() && old('budget_form') == true)
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Function to validate the form
    function validateForm() {
        // Reset any previous error messages
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach((errorMessage) => {
            errorMessage.textContent = '';
        });

        const part1Amount = parseFloat(document.getElementById('part1Amount').value);
        const part2Amount = parseFloat(document.getElementById('part2Amount').value);
        const part3Amount = parseFloat(document.getElementById('part3Amount').value);

        let isValid = true;

        // Example validation: Check if allocation amount is a positive number or empty
        if (isNaN(part1Amount) || part1Amount <= 0) {
            const part1AmountError = document.getElementById('part1AmountError');
            part1AmountError.textContent = 'Part 1 Amount must be a positive number';
            isValid = false;
        }

        if (isNaN(part2Amount) || part2Amount <= 0) {
            const part2AmountError = document.getElementById('part2AmountError');
            part2AmountError.textContent = 'Part 2 Amount must be a positive number';
            isValid = false;
        }

        if (isNaN(part3Amount) || part3Amount <= 0) {
            const part3AmountError = document.getElementById('part3AmountError');
            part3AmountError.textContent = 'Part 3 Amount must be a positive number';
            isValid = false;
        }

        return isValid;
    }

    // Handle form submission
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('budget_form');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            if (validateForm()) {
                // If validation succeeds, you can submit the form via AJAX or allow normal form submission
                document.querySelector('input[name="budget_form"]').value = 1;
                form.submit(); // This will submit the form normally
            }
        });
    });
</script>

<style>
    .filter-multi-select {
        min-width: 500px;
        margin: 15px 0px 0px 20px;
        border-radius: 5px;
    }

    .filter-multi-select>.dropdown-toggle::before {
        margin-right: 10px;
        top: 50%;
        position: absolute;
        right: 0;
    }

    .filter-multi-select>.viewbar>.selected-items>.item {
        color: #000;
        background-color: gainsboro;
    }

    .filter-multi-select>.viewbar>.selected-items>.item.disabled {
        background-color: cornflowerblue;
    }

    .filter-multi-select>.viewbar>.selected-items>.item>button {
        color: #bbbbbb;
        margin-left: 5px;
        margin-right: 5px;
        font-size: x-large;
    }

    .filter-multi-select .dropdown-item .custom-checkbox:checked~.custom-control-label::after {
        background-color: rgb(56, 56, 56);
        border-radius: 5px
    }
</style>
