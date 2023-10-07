{{-- create user budget template modal --}}
<div id="createBudgetTemplateModal" class="modal fade" tabindex="-1" role="dialog" 
    aria-labelledby="budgetTemplateSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog relative p-4 w-full  h-full md:h-auto" role="document">
        {{-- Modal Content --}}
        <div class="modal-content-l relative p-4 bg-white rounded-lg shadow sm:p-5">
            <div class="modal-header flex justify-between items-center">
                <h2 style="font-size:20px;"><b>Create new template</b></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body flex flex-col">
                <div>
                    <label for="part_input">How many part do you want?</label>
                    <input class="rounded-md mx-3" type="number" name="input" id="input" min="1"
                        max="5" style="height: 30px;width: 100px" placeholder="e.g. 1" required>
                    <button type="submit" id="generateFields" class="bg-blue-500 rounded"
                        style="width: 80px; height: 30px;">Enter</button>
                </div>
                <form method="POST" action="{{ route('budget.storeUserTemplate') }}">
                    @csrf
                    <div id="partContainer"></div>
                    <input type="hidden" name="template_name" id="template_name" value="User Template">
                    <div class="float-right mt-4" id="buttons" style="display: none">
                        <button type="submit" class="bg-blue-400 rounded hover:bg-blue-300"
                            style="width: 100px">Create</button>
                        <button data-dismiss="modal" class="border bg-white rounded hover:bg-gray-100"
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
