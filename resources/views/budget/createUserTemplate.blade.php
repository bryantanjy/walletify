<div id="createBudgetTemplateModal" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="budgetTemplateSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg relative p-4 w-full h-full md:h-auto" role="document">
        {{-- Modal Content --}}
        <div class="modal-content relative p-4 rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex justify-between items-center">
                <h2 style="font-size:20px;"><b>Create New Budget</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body ">
                <form method="POST" action="{{ route('budget.storeUserTemplate') }}">
                    @csrf
                    <div id="dynamicPartFields"></div>
                    <button type="button" class="bg-white border rounded mt-3" id="plusButton"
                        style="width: 35px; height: 35px; font-size: 22px; display:none">+</button>
                    <input type="hidden" name="type" id="type" value="User Template">
                    <div class="float-right mt-4" id="buttons">
                        <button type="submit" class="bg-blue-400 rounded hover:bg-blue-300"
                            style="width: 100px">Create</button>
                        <button type="button" data-bs-dismiss="modal" class="border bg-white rounded hover:bg-gray-100"
                            style="width: 100px; margin-left:10px">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const categories = @json($categories);
</script>

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

    .filter-multi-select>.viewbar {
        border: 0;
    }

    .filter-multi-select>.viewbar>span.placeholder {
        background-color: transparent;
        cursor: pointer;
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
