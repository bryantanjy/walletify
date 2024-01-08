// search function
$(document).ready(function () {
    window.lastOperation = 'datepicker';
    window.filterParams = {};
    window.userSessionType = 'personal';

    function delay(callback, ms) {
        var timer = 0;
        return function () {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    // when user enter the word, it will retrieve the word; make delay to 1 seconds
    $('#search').on('keyup', delay(function () {
        var query = $(this).val();
        fetchSearchResults(query);
        window.lastOperation = 'search';
    }, 1000));

    window.fetchSearchResults = function (query) {
        $.ajax({
            url: '/record/search',
            type: 'GET',
            data: {
                'search': query,
                'userSessionType': window.userSessionType,
            },
            success: function (data) {
                $('#records-container').html(data);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    $('input[type=checkbox]').on('change', function () {
        var categories = [];
        $('input[name="categories[]"]:checked').each(function () {
            categories.push($(this).val());
        });
        var types = [];
        $('input[name="type[]"]:checked').each(function () {
            types.push($(this).val());
        });
        filterParams = { // Store the filter parameters
            'categories': categories,
            'types': types,
        };
        fetchFilterResults(filterParams);
    });

    window.fetchFilterResults = function (filterParams) {
        filterParams['userSessionType'] = window.userSessionType;
        $.ajax({
            url: '/record/filter',
            type: 'GET',
            data: {
                'categories': filterParams.categories,
                'types': filterParams.types,
            },
            success: function (data) {
                $('#records-container').html(data);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
});

$(document).on('click', '.createRecordBtn', function () {
    var modalElement = $('#createRecordModal');
    if (modalElement.length) { // Check if the modal element exists
        modalElement.modal('show');
    } else {
        console.error('Modal element not found');
    }
});

$(document).on('click', '.viewRecordBtn', function () {
    var recordId = $(this).val();
    var showRecord = $('#showModal');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/record/show/' + recordId,
        success: function (data) {
            // showRecord.find('#account_name').text(data.account.name);
            showRecord.find('#category_name').text(data.category.name);
            showRecord.find('#record_type').text(data.type);
            showRecord.find('#amount').text(data.amount);
            var formattedDate = moment(data.datetime).format('DD/MM/YYYY, h:m A');
            showRecord.find('#datetime').text(formattedDate);
            showRecord.find('#description').text(data.description);
            // Conditionally display the account name if it exists
            if (data.account) {
                showRecord.find('#account_name').text(data.account.name);
            } else {
                showRecord.find('#account_name').text('N/A');
            }

            showRecord.modal('show');
        },
        error: function (error) {
            console.log('Error fetching record data for showing:', error);
        }
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
            var formattedDate = new Date(data.datetime).toISOString().slice(0, 16);
            editRecord.find('#datetime').val(formattedDate);
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
    var recordId = $('#editRecordModal').find('#record_id').val();
    var formData = new FormData(this);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/record/update/' + recordId,
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log('Record updated successfully:', response);
            $('#editRecordModal').modal('hide');
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
