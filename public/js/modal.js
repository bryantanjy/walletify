$(document).on('click', '.editAccountBtn', function () {
    var accountId = $(this).val();
    var editModal = $('#editAccountModal');

    $.ajax({
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

// account list for create record 
$(document).ready(function () {
    // Fetch accounts data via AJAX request
    $.get('/account', function (data) {
        var accountSelect = $('#accountSelect');
        accountSelect.empty(); 
        accountSelect.append(new Option('Select an account', ''));
        if ($.isArray(data)) {
            // Add the new options from the fetched data
            $.each(data, function (index, account) {
                accountSelect.append(new Option(account.account_name, account.account_id));
            });
        } else {
            // Render the HTML response as is
            $('#accountIndexContainer').html(data);
        }
    });
});