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
        var currentPage = getCurrentPageNumber();
        fetchSearchResults(query, currentPage);
        window.lastOperation = 'search';
    }, 1000));

    window.fetchSearchResults = function (query, page) {
        $.ajax({
            url: '/record/search',
            type: 'GET',
            data: {
                'search': query,
                'page': page,
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

    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        if (window.lastOperation === 'search') { // Check if the last operation was a search
            var query = $('#search').val();
            fetchSearchResults(query, page);
        } else if (window.lastOperation === 'filter') { // Check if the last operation was a filter
            filterParams.page = page; // Update the page number in the filter parameters
            fetchFilterResults(filterParams); // Pass the filter parameters to the function
        } else if (window.lastOperation === 'datepicker') { // Check if the last operation was a datepicker
            var start = moment($('#reportrange span').html().split(' - ')[0], 'D MMM YYYY');
            var end = moment($('#reportrange span').html().split(' - ')[1], 'D MMM YYYY');
            fetchRecords(start, end, page); // Fetch records for the selected date range and the clicked page
        }
    });

    $('input[type=checkbox]').on('change', function () {
        var categories = [];
        $('input[name="categories[]"]:checked').each(function () {
            categories.push($(this).val());
        });
        var types = [];
        $('input[name="type[]"]:checked').each(function () {
            types.push($(this).val());
        });
        var currentPage = getCurrentPageNumber(); // Add this function to get the current page
        filterParams = { // Store the filter parameters
            'categories': categories,
            'types': types,
            'sort': $('#sort').val(),
            'page': currentPage
        };
        fetchFilterResults(filterParams);
        window.lastOperation = 'filter'; // Set lastOperation to 'filter' here
    });

    window.fetchFilterResults = function (filterParams) {
        filterParams['userSessionType'] = window.userSessionType;
        $.ajax({
            url: '/record/filter',
            type: 'GET',
            data: {
                'categories': filterParams.categories,
                'types': filterParams.types,
                'sort': filterParams.sort,
                'page': filterParams.page
            },
            success: function (data) {
                $('#records-container').html(data);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    $('#reset').on('click', function (event) {
        event.preventDefault();
        // Uncheck all checkboxes
        $('input[type=checkbox]').prop('checked', false);

        // Fetch the default records
        var currentPage = getCurrentPageNumber();
        fetchDefaultRecords(currentPage);

        // Set lastOperation to 'default'
        window.lastOperation = 'default';
    });

    function getCurrentPageNumber() {
        return parseInt($('.pagination .active span').text());
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
            showRecord.find('#account_name').text(data.account.name);
            showRecord.find('#category_name').text(data.category.name);
            showRecord.find('#record_type').text(data.type);
            showRecord.find('#amount').text(data.amount);
            var formattedDate = moment(data.datetime).format('DD/MM/YYYY, h:m A');
            showRecord.find('#datetime').text(formattedDate);
            showRecord.find('#description').text(data.description);

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
            window.location.replace('/record');
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
