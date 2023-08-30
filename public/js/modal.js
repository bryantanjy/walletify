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
            // Fill the data in the input fields
            editModal.find('#account_id').val(data.account_id);
            editModal.find('#account_type').val(data.account_type);
            editModal.find('#account_name').val(data.account_name);

            // Show the edit modal
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

// modal delete
function showDeleteModal(accountId) {
    var deleteForm = document.getElementById('deleteForm');
    var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteForm.action = '/account/delete/' + accountId;
    modal.show();
}


//edit record
// $(document).on('click', '.editRecordBtn', function () {
//     var recordId = $(this).val();
//     var editRecord = $('#editRecordModal');

//     $.ajax({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type: 'GET',
//         url: '/record/edit/' + recordId,
//         success: function (data) {
//             editRecord.find('#account_name').val(data.account_id);
//             editRecord.find('#record_type').val(data.record_type);
//             editRecord.find('#category_name').val(data.category_id);
//             editRecord.find('#amount').val(data.amount);
//             editRecord.find('#date').val(data.date);
//             editRecord.find('#time').val(data.time);
//             editRecord.find('#record_description').val(data.record_description);
//             editRecord.find('#record_id').val(data.record_id);

//             // Show the edit modal
//             editRecord.modal('show');
//         },
//         error: function (error) {
//             console.log(error);
//         }
//     });
// });