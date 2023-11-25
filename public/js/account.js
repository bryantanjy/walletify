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
            console.log('Account updated successfully:', response);
            $.get(document.URL, function(data) {
                // Find and replace the specific container content
                var updatedContent = $(data).find('#account-container').html();
                $('#account-container').html(updatedContent);

                // Close the modal
                editModal.modal('hide');
            });
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


// trigger toast @ notification
$(document).ready(function () {
    $('.toast').toast({ delay: 5000 }).toast('show');
});