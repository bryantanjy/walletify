// handle the modal to fetch data into edit form
$(document).on('click', '.editGroupBtn', function () {
    var groupId = $(this).val();
    var editGroup = $('#editGroupModal');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/expense-sharing/edit/' + groupId,
        success: function (data) {
            editGroup.find('#group_id').val(data.id);
            editGroup.find('#name').val(data.name);
            editGroup.find('#description').val(data.description);

            editGroup.modal('show');
        },
        error: function (error) {
            console.log('Error fetching record data for editing:', error);
        }
    });
});




// modal delete for group
function showDeleteModal(groupId) {
    var deleteForm = document.getElementById('deleteForm');
    var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteForm.action = '/expense-sharing/delete/' + groupId;
    modal.show();
}


// trigger toast @ notification
$(document).ready(function () {
    $('.toast').toast({ delay: 5000 }).toast('show');
});