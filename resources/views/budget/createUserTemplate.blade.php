<div id="createBudgetTemplateModal" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="budgetTemplateSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg relative p-4 w-full  h-full md:h-auto" role="document">
        {{-- Modal Content --}}
        <div class="modal-content relative p-4 rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex justify-between items-center">
                <h2 style="font-size:20px;"><b>Create new template</b></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body flex flex-col">
                {{-- <div>
                    <label for="part_input">How many part do you want?</label>
                    <input class="rounded-md mx-3 border-0" type="number" name="input" id="input" min="1"
                        max="5" style="height: 30px;width: 100px" placeholder="e.g. 1" required>
                    <button type="submit" id="generateFields" class="bg-blue-500 rounded"
                        style="width: 80px; height: 30px;">Enter</button>
                </div> --}}
                <form method="POST" action="{{ route('budget.storeUserTemplate') }}">
                    @csrf
                    <div id="dynamicPartFields"></div>
                    <button type="button" class="bg-white border rounded mt-3" id="plusButton"
                        style="width: 35px; height: 35px; font-size: 22px">+</button>
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

    const container = document.getElementById('dynamicPartFields');
    const plusButton = document.getElementById('plusButton');

    createPart(1);

    plusButton.addEventListener('click', function() {
        if (container.childElementCount < 5) {
            const nextPartIndex = container.childElementCount + 1;
            createPart(nextPartIndex);

            if (container.childElementCount === 5) {
                plusButton.disabled = true;
                plusButton.style.display = 'none';
            }
        }
    });

    function createPart(partIndex) {
        const partField = document.createElement('div');
        partField.className = 'part-field';

        partField.innerHTML = `
                <h4 style="font-size:20px; margin-top:25px"><b>Part ${partIndex}</b></h4>
                <div class="flex items-center">
                    <label for="partName${partIndex}" class="w-32 pr-2 mt-4">Name</label>
                    <input class="rounded-md border-0" type="text" name="part_name[${partIndex}]" id="part_name${partIndex}" placeholder="Name"
                        style="height: 30px; margin:15px 0px 0px 20px;width:175px;" required>
                </div>
                <div class="flex items-center">
                    <label for="partAmount${partIndex}" class="w-32 pr-2 mt-4">Amount</label>
                    <input class="rounded-md border-0" type="number" step="0.01" name="allocation_amount[${partIndex}]" id="allocation_amount${partIndex}" placeholder="0.00"
                        style="height: 30px; margin:15px 0px 0px 20px;text-align:right;width:175px;" required>
                </div>
                <div class="flex">
                    <label for="partCategory${partIndex}" class="w-32 pr-2 mt-4">Category</label>
                    <select class="rounded-md categorySelect border-0" name="category_id[${partIndex}][]" id="category_id${partIndex}" multiple
                        required>
                        ${categories.map(category => `<option value="${category.id}">${category.name}</option>`).join('')}
                    </select>
                </div>
            `;

        container.appendChild(partField);

        $('#category_id' + partIndex).filterMultiSelect({
            placeholderText: "Please select",
        });
    }
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

    .filter-multi-select>.viewbar> span.placeholder {
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
