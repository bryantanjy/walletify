//  budget js
// create default budget template section
$(document).ready(function () {
    const percentages = {
        part1: 0.5,
        part2: 0.3,
        part3: 0.2,
    };

    $('#category_id1').filterMultiSelect();
    $('#category_id2').filterMultiSelect();
    $('#category_id3').filterMultiSelect();

    document.getElementById("setBtn").addEventListener("click", function () {
        const totalBudget = parseFloat(document.getElementById("totalBudget").value);

        // Calculate allocation amounts based on percentages
        const part1Amount = totalBudget * percentages.part1;
        const part2Amount = totalBudget * percentages.part2;
        const part3Amount = totalBudget * percentages.part3;

        // Update the readonly input fields with calculated amounts
        document.getElementById("part1Amount").value = part1Amount.toFixed(2);
        document.getElementById("part2Amount").value = part2Amount.toFixed(2);
        document.getElementById("part3Amount").value = part3Amount.toFixed(2);
    });
});


// create user budget template section
$(document).ready(function () {
    const container = document.getElementById('dynamicPartFields');
    const plusButton = document.getElementById('plusButton');
    plusButton.style.display = 'block';
    createPart(1);

    plusButton.addEventListener('click', function () {
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
            removeButton.addEventListener('click', function () {
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
});


// edit default budget template section
$(document).ready(function () {
    const categorySelectElements = document.querySelectorAll('[id^=categories]');
    for (const categorySelectElement of categorySelectElements) {
        $(categorySelectElement).filterMultiSelect();
    }


    document.getElementById('setButton').addEventListener('click', function () {
        const totalAllocation = parseFloat(document.getElementById('total_allocation').value);
        const totalBudgetError = document.getElementById('totalBudgetError');
        const percent = {
            p1: 0.5,
            p2: 0.3,
            p3: 0.2,
        };


        // Check if the total allocation is valid
        if (totalAllocation <= 1 || isNaN(totalAllocation)) {
            const errorAmount = document.getElementById('errorAmount');
            errorAmount.textContent = 'Your input must be more than 1';
            return;
        }

        totalBudgetError.textContent = ''; // Clear any previous error message

        // Calculate the allocation amounts for three parts (50%, 30%, 20%)
        const part1Allocation = (totalAllocation * percent.p1).toFixed(2);
        const part2Allocation = (totalAllocation * percent.p2).toFixed(2);
        const part3Allocation = (totalAllocation * percent.p3).toFixed(2);

        // Update the input fields with the calculated amounts
        document.getElementById('allocation_amount0').value = part1Allocation;
        document.getElementById('allocation_amount1').value = part2Allocation;
        document.getElementById('allocation_amount2').value = part3Allocation;
    });
});


// edit user budget template section
$(document).ready(function () {
    $('.editUserBudgetBtn').on('click', function () {
        const categorySelectElements = $('[id^=partCategory]');
        categorySelectElements.each(function () {
            $(this).filterMultiSelect();
        });
    });
});


// modal delete for budget section
function budgetDeleteModal(budgetId) {
    var deleteForm = document.getElementById('deleteForm');
    var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteForm.action = '/budget/delete/' + budgetId;
    modal.show();
}


// trigger toast @ notification
$(document).ready(function () {
    $('.toast').toast({ delay: 5000 }).toast('show');
});