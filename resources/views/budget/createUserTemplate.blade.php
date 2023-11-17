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

    const container = document.getElementById('dynamicPartFields');
    const plusButton = document.getElementById('plusButton');
    plusButton.style.display = 'block';
    createPart(1);

    plusButton.addEventListener('click', function() {
        if (container.childElementCount <= 4) {
            const nextPartIndex = container.childElementCount + 1;
            createPart(nextPartIndex);
        } 
    });

    function createPart(partIndex) {
        const partField = document.createElement('div');
        partField.className = 'part-field';
        partField.id = `partField${partIndex}`;

        partField.innerHTML = `
                <h4 style="font-size:20px; margin-top:25px">Part ${partIndex}</h4>
                <div class="flex items-center">
                    <label for="partName${partIndex}" class="w-32 pr-2 mt-4">Name</label>
                    <input class="rounded-md border-0" type="text" name="part_name[${partIndex}]" id="part_name${partIndex}" placeholder="Name"
                        style="height: 30px; margin:15px 0px 0px 20px;width:175px;" required>
                </div>
                <div class="flex items-center">
                    <label for="partAmount${partIndex}" class="w-32 pr-2 mt-4">Amount</label>
                    <input class="rounded-md border-0" type="number" step="0.01" name="amount[${partIndex}]" id="amount${partIndex}" placeholder="0.00"
                        style="height: 30px; margin:15px 0px 0px 20px;text-align:right;width:175px;" required>
                </div>
                <div class="flex">
                    <label for="partCategory${partIndex}" class="w-32 pr-2 mt-4">Category</label>
                    <select class="rounded-md categorySelect border-0" name="categoryId[${partIndex}][]" id="categoryId${partIndex}" multiple
                        required>
                        ${categories.map(category => `<option value="${category.id}">${category.name}</option>`).join('')}
                    </select>
                </div>
                <button type="button" class="bg-white border rounded mt-2 float-right" id="removeButton${partIndex}"
                    style="width: 35px; height: 35px; font-size: 22px;">-</button>
            `;

        container.appendChild(partField);

        $('#categoryId' + partIndex).filterMultiSelect({
            placeholderText: "Please select",
        });

        const removeButton = document.getElementById(`removeButton${partIndex}`);
        if (container.childElementCount === 1) {
            removeButton.style.display = "none";
        } else {
            removeButton.addEventListener('click', function() {
                container.removeChild(partField);
                updatePartNumbers();
            });
        }
    }

    function updatePartNumbers() {
        const partFields = container.querySelectorAll('.part-field');
        partFields.forEach((partField, index) => {
            const partIndex = index + 1;
            const partHeader = partField.querySelector('h4');
            const partLabelText = partHeader.innerText;
            partHeader.innerText = `Part ${partIndex}`;
            partField.id = `partField${partIndex}`;
            // Update the input names and IDs
            partField.querySelectorAll('[id^=part_name]').forEach(input => input.name =
                `part_name[${partIndex}]`);
            partField.querySelectorAll('[id^=amount]').forEach(input => input.name =
                `amount[${partIndex}]`);
            partField.querySelectorAll('[id^=categoryId]').forEach(select => {
                select.name = `categoryId[${partIndex}][]`;
                select.id = `categoryId${partIndex}`;
            });
            // Update the button ID
            const removeButton = partField.querySelector('[id^=removeButton]');
            removeButton.id = `removeButton${partIndex}`;
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
