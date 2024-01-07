// edit participant modal
$(document).on('click', '.editMemberBtn', function () {
    var userId = $(this).data('member');
    var groupId = $(this).data('group');
    var editGroup = $('#editParticipantModal');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/groups/edit/' + groupId + '/' + userId,
        success: function (data) {

            // console.log(data.permissions);
            editGroup.find('#role').val(data.role_id);
            editGroup.find('#user_id').val(data.user_id);

            editGroup.find('input[name="permissions[]"]').prop('checked', false);

            // Parse the JSON array and check the corresponding checkboxes
            if (data.permissions) {
                var permissionsArray = JSON.parse(data.permissions);

                permissionsArray.forEach(function (permissionId) {
                    editGroup.find('#permission' + permissionId).prop('checked', true);
                });
            }

            editGroup.modal('show');
        },
        error: function (error) {
            console.log(error);
        }
    });
});

function disableFormFields() {
    // Disable the role select
    $('#role').prop('disabled', true);

    // Disable all checkboxes
    $('input[name="permissions[]"]').prop('disabled', true);

    // Optionally, you can add visual indication (e.g., gray out) for disabled fields
    // Example using a CSS class:
    $('#role').addClass('disabled-field');
    $('input[name="permissions[]"]').addClass('disabled-field');
}

// function submit form
$(document).on('submit', '#editParticipantForm', function (event) {
    var userId = $('#editParticipantModal').find('#user_id').val();
    var groupId = $('#editParticipantModal').find('#group_id').val();
    var formAction = '/groups/update/' + ':groupId/' + ':userId';
    formAction = formAction.replace(':groupId', groupId).replace(':userId', userId);

    // Set the action attribute of the form
    $('#editParticipantForm').attr('action', formAction);
    var roleId = $('#editParticipantModal').find('#role').val();
    var permissions = $('#editParticipantModal').find('input[name="permissions[]"]:checked').map(function () {
        return this.value;
    }).get();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'PUT',
        // url: '/groups/update/' + groupId + '/' + userId,
        data: {
            role: roleId,
            permissions: permissions,
        },
        success: function (data) {
            $('#editParticipantModal').modal('hide');
            alert('Participant updated successfully');
        },
        error: function (error) {
            console.log('Error updating participant:', error);
        }
    });
});

// modal delete for group participant
function showDeleteModal(groupId, userId) {
    var deleteForm = document.getElementById('deleteForm');
    var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    // deleteForm.action = '/groups/delete/' + groupId;
    modal.show();
}

// trigger toast @ notification
$(document).ready(function () {
    $('.toast').toast({
        delay: 5000
    }).toast('show');
});