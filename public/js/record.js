
// function filterSearchRecords() {
//     var searchInput = $('#search').val().toLowerCase();

//     $('.record-list').each(function () {
//         var recordDescription = $(this).find('.col-start-5').text().toLowerCase();
//         var recordElement = $(this);

//         if (recordDescription.includes(searchInput)) {
//             recordElement.show();
//         } else {
//             recordElement.hide();
//         }
//     });
// }

// $('#search').on('input', function () {
//     filterSearchRecords();
// });

// filterSearchRecords();

$(document).on('click', '.editRecordBtn', function () {
    var recordId = $(this).val();
    var editRecord = $('#editRecordModal');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/record/edit/' + recordId,
        success: function (data) {
            editRecord.find('#record_id').val(data.id);
            editRecord.find('#account_id').val(data.account_id);
            editRecord.find('#category_id').val(data.category_id);
            editRecord.find('#type').val(data.type);
            editRecord.find('#amount').val(data.amount);
            editRecord.find('#datetime').val(data.datetime);
            editRecord.find('#description').val(data.description);

            editRecord.modal('show');
        },
        error: function (error) {
            console.log('Error fetching record data for editing:', error);
        }
    });
});

$(document).on('submit', '#editRecord', function (event) {
    event.preventDefault();
    var editRecord = $('#editRecordModal');
    var formData = $(this).serialize();
    var recordId = editRecord.find('#record_id').val();

    $.ajax({
        type: 'PUT',
        url: '/record/update/' + recordId,
        data: formData,
        success: function (response) {
            console.log('Record updated successfully:', response);
            editRecord.modal('hide');
            window.location.reload();
        },
        error: function (error) {
            console.error('Error updating record:', error);
        }
    });
});

function recordDeleteModal(recordId) {
    var deleteForm = document.getElementById('deleteForm');
    var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteForm.action = '/record/delete/' + recordId;
    modal.show();
}

$(document).ready(function () {
    $('.toast').toast({ delay: 5000 }).toast('show');
});
