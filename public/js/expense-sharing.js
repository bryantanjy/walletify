




// modal delete for account
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