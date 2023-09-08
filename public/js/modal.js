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
            editModal.find('#account_id').val(data.account_id);
            editModal.find('#account_type').val(data.account_type);
            editModal.find('#account_name').val(data.account_name);

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

// modal edit for record
$(document).on('click', '.editRecordBtn', function () {
    var editRecord = $('#editRecordModal');
    var recordId = $(this).data('record-id'); 
    var accountId = $(this).data('account-id');
    var recordType = $(this).data('record-type');
    var categoryId = $(this).data('category-id');
    var amount = $(this).data('amount');
    var date = $(this).data('date');
    var time = $(this).data('time');
    var recordDescription = $(this).data('record-description');

    // Populate the modal fields with the record data
    editRecord.find('#record_id').val(recordId);
    editRecord.find('#account_id').val(accountId);
    editRecord.find('#record_type').val(recordType);
    editRecord.find('#category_id').val(categoryId);
    editRecord.find('#amount').val(amount);
    editRecord.find('#date').val(date);
    editRecord.find('#time').val(time);
    editRecord.find('#record_description').val(recordDescription);
    
    editRecord.modal('show');
});

// modal delete for record
function recordDeleteModal(recordId) {
    var deleteForm = document.getElementById('deleteForm');
    var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteForm.action = '/record/delete/' + recordId;
    modal.show();
}