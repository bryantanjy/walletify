// Account Section
// fetch account details to edit modal
$(document).on('click', '.editAccountBtn', function () {
    var accountId = $(this).val();
    var editModal = $('#editAccountModal');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/account/edit/' + accountId,
        success: function (data) {
            editModal.find('#account_id').val(data.id);
            editModal.find('#account_type').val(data.type);
            editModal.find('#account_name').val(data.name);

            editModal.modal('show');
        },
        error: function (error) {
            console.log(error);
        }
    });
});

// pass item to update
$(document).on('submit', '#edit-form', function (event) {
    event.preventDefault();
    var editModal = $('#editAccountModal');
    var formData = $(this).serialize();
    var accountId = editModal.find('#account_id').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'PUT',
        url: '/account/update/' + accountId,
        data: formData,
        success: function (response) {
            window.location.reload();
            editModal.modal('hide');
        },
        error: function (error) {
            console.log(error);
        }
    });
});

// modal delete for account
function showDeleteModal(accountId) {
    var deleteForm = document.getElementById('deleteForm');
    var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteForm.action = '/account/delete/' + accountId;
    modal.show();
}

// Record Section
// modal edit for record


// modal delete for record
// function recordDeleteModal(recordId) {
//     var deleteForm = document.getElementById('deleteForm');
//     var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
//     deleteForm.action = '/record/delete/' + recordId;
//     modal.show();
// }

// Budget Section
// open create modal
$(document).on('click', '.createTemplate', function () {
    const selectionModal = $('#budgetTemplateSelectionModal');
    const createTemplate = $('#createBudgetTemplateModal');

    selectionModal.modal('hide');
    createTemplate.modal('show');
});

$(document).on('click', '.defaultTemplate', function () {
    const selectionModal = $('#budgetTemplateSelectionModal');
    const defaultTemplate = $('#defaultBudgetTemplateModal');

    selectionModal.modal('hide');
    defaultTemplate.modal('show');
});


// js for create budget template
document.addEventListener("DOMContentLoaded", function () {
    // user template js
    const generateButton = document.getElementById("generateFields");
    const partContainer = document.getElementById("partContainer");
    const buttonsDiv = document.getElementById('buttons');


    generateButton.addEventListener("click", function () {
        const numberOfParts = parseInt(document.getElementById('input').value);

        if (numberOfParts >= 1 && numberOfParts <= 5) {
            partContainer.innerHTML = "";

            for (let i = 1; i <= numberOfParts; i++) {
                const partDiv = document.createElement("div");
                const partIndex = i;

                partDiv.innerHTML = `
                    <h4 style="font-size:20px; margin-top:25px"><b>Part ${partIndex}</b></h4>
                    <div class="flex items-center">
                        <label for="partName${partIndex}" class="w-32 pr-2 mt-4">Name</label>
                        <input class="rounded-md" type="text" name="part_name[${partIndex}]" id="part_name${partIndex}" placeholder="Name"
                            style="height: 30px; margin:15px 0px 0px 20px;width:175px;" required>
                    </div>
                    <div class="flex items-center">
                        <label for="partAmount${partIndex}" class="w-32 pr-2 mt-4">Amount</label>
                        <input class="rounded-md" type="number" step="0.01" name="allocation_amount[${partIndex}]" id="allocation_amount${partIndex}" placeholder="0.00"
                            style="height: 30px; margin:15px 0px 0px 20px;text-align:right;width:175px;" required>
                    </div>
                    <div class="flex">
                        <label for="partCategory${partIndex}" class="w-32 pr-2 mt-4">Category</label>
                        <select class="rounded-md categorySelect"  name="category_id[${partIndex}][]" id="category_id${partIndex}" multiple
                            required>
                            ${categories.map(category => `<option value="${category.id}">${category.name}</option>`).join('')}
                        </select>
                    </div>
                `;

                partContainer.appendChild(partDiv);

                $('#category_id' + partIndex).filterMultiSelect({
                    placeholderText: "Please select",
                });
            }
            buttonsDiv.style.display = "block";
        }
    });

    // Default template js

});

// js for edit budget


// modal delete for budget
function budgetDeleteModal(budgetId) {
    var deleteForm = document.getElementById('deleteForm');
    var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteForm.action = '/budget/delete/' + budgetId;
    modal.show();
}