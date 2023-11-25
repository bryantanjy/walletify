<div id="editUserBudgetModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editUserBudgetModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg relative p-4 w-full h-full md:h-auto" role="document">
        {{-- Modal Content --}}
        <div class="modal-content relative p-4 rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex justify-between items-center">
                <h2 style="font-size:20px;"><b>Edit User Template</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body flex flex-col">
                @if (isset($budget))
                    <form method="POST" action="{{ route('budget.updateUserTemplate', ['budget' => $budget->id]) }}">
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

                        @foreach ($budget->partAllocations as $part)
                            <input type="hidden" name="part_allocation_id[]" value="{{ $part->id }}">

                            <h4 style="font-size:20px; margin-top:25px"><b>Part {{ $loop->index + 1 }}</b></h4>
                            <div class="flex items-center">
                                <label for="partName" class="w-32 pr-2 mt-4">Name</label>
                                <input class="rounded-md border-0" type="text" name="part_name[]"
                                    id="part_name{{ $loop->index }}"
                                    style="height: 30px; margin:15px 0px 0px 20px;width:175px;"
                                    value="{{ $part->name }}" required>
                            </div>
                            <div class="flex items-center">
                                <label for="partAmount" class="w-32 pr-2 mt-4">Amount</label>
                                <input class="rounded-md border-0" type="number" step="0.01" name="amount[]"
                                    id="amount{{ $loop->index }}" value="{{ $part->amount }}"
                                    style="height: 30px; margin:15px 0px 0px 20px;text-align:right;width:175px;"
                                    required>
                            </div>
                            <div class="flex">
                                <label for="partCategory" class="w-32 pr-2 mt-4">Category</label>
                                <select class="rounded-md border-0" name="partCategory[{{ $loop->index }}][]"
                                    id="partCategory{{ $loop->index }}" multiple required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if ($part->partCategories->contains('id', $category->id)) selected @endif>
                                            {{ $category->name }}
                                    @endforeach
                                </select>
                            </div>
                        @endforeach

                        <input type="hidden" name="type" id="type" value="{{ $budget->type }}">
                        <div class="float-right mt-4" id="buttons">
                            <button type="submit" class="bg-blue-400 rounded hover:bg-blue-300"
                                style="width: 100px">Save</button>
                            <button type="button" data-bs-dismiss="modal"
                                class="border bg-white rounded hover:bg-gray-100"
                                style="width: 100px; margin-left:10px">Cancel</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .filter-multi-select {
        min-width: 175px;
        max-width: 500px;
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
