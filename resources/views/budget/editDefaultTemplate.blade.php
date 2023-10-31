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
                <div>
                    <label for="total_allocation">Total Budget Allocation</label>
                    <input class="rounded-md text-right mx-3" type="number" name="total_allocation"
                        id="total_allocation" step="0.01" style="height: 30px; width:150px" placeholder="e.g. 1000">
                    <button type="button" id="setAllocation" class="bg-green-400 rounded"
                        style="width: 80px;height: 30px;">Set</button>
                    <div id="totalBudgetError" class="text-red-500"></div>
                </div>

                <form id="budget_form" method="POST" action="">
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

                    @foreach ($budget['parts'] as $partIndex => $part)
                        <h4 style="font-size:20px; margin-top:25px"><b>Part {{ $partIndex + 1 }}</b></h4>
                        <div class="flex items-center">
                            <label for="partName{{ $partIndex + 1 }}" class="w-32 pr-2 mt-4">Name</label>
                            <input class="rounded-md" type="text" name="part_name[{{ $partIndex + 1 }}]"
                                id="part{{ $partIndex + 1 }}_name" placeholder="Name"
                                style="height: 30px; margin:15px 0px 0px 20px;width:175px;"
                                value="{{ $part['part_name'] }}" readonly>
                        </div>
                        <div class="flex items-center">
                            <label for="partAmount{{ $partIndex + 1 }}" class="w-32 pr-2 mt-4">Amount</label>
                            <input class="rounded-md" type="number" step="0.01"
                                name="allocation_amount[{{ $partIndex + 1 }}]" id="part{{ $partIndex + 1 }}Amount"
                                placeholder="0.00" value="{{ $part['allocation_amount'] }}"
                                style="height: 30px; margin:15px 0px 0px 20px;text-align:right;width:175px;" readonly
                                required>
                        </div>
                        <div class="flex">
                            <label for="partCategory{{ $partIndex + 1 }}" class="w-32 pr-2 mt-4">Category</label>
                            <select lass="rounded-md" name="category_id[{{ $partIndex + 1 }}][]"
                                id="categoryId{{ $partIndex + 1 }}" multiple disabled>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}"
                                        @if (in_array($category->category_id, $part['category_ids'])) selected @endif>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="part1AmountError" class="text-red-500"></div>
                    @endforeach

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
    document.getElementById("setAllocation").addEventListener("click", function () {
        const totalAllocation = parseFloat(document.getElementById("total_allocation").value);

        if (totalAllocation < 1) {
            document.getElementById('totalBudgetError').innerHTML =
                'Total allocation must be greater than or equal to 1.';
            return;
        }

        // Calculate allocation amounts based on percentages
        const part1Amount = totalAllocation * 0.5;
        const part2Amount = totalAllocation * 0.3;
        const part3Amount = totalAllocation * 0.2;

        // Update the readonly input fields with calculated amounts
        document.getElementById("part1Amount").value = part1Amount.toFixed(2);
        document.getElementById("part2Amount").value = part2Amount.toFixed(2);
        document.getElementById("part3Amount").value = part3Amount.toFixed(2);
    });

    $(document).ready(function() {
        $('#categoryId1, #categoryId2, #categoryId3').filterMultiSelect();
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
