// search function
$(document).ready(function() {
    function delay(callback, ms) {
        var timer = 0;
        return function() {
          var context = this, args = arguments;
          clearTimeout(timer);
          timer = setTimeout(function () {
            callback.apply(context, args);
          }, ms || 0);
        };
      }
    
    // when user enter the word, it will retrieve the word; make delay to 1 seconds
    $('#search').on('keyup', delay(function() {
        var query = $(this).val();
        fetchSearchResults(query, 1);
    }, 1000));

    function fetchSearchResults(query, page) {
        $.ajax({
            url: '/record/search',
            type: 'GET',
            data: {
                'search': query,
                'page': page
            },
            success: function(data) {
                $('#records-container').html(data);
            }
        });
    }
    
    //  fetch record list and update when the new date is picked
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault(); 
        var page = $(this).attr('href').split('page=')[1];
        var query = $('#search').val();
        fetchSearchResults(query, page);
    });
});



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
