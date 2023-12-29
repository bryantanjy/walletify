$(function () {
    var start = moment().subtract(29, 'days');
    var end = moment();

    // Fetch records for the current month by default
    function fetchRecordsOnChange(start, end, page) {
        var userSessionType = 'personal'; // Default to 'personal' if not set
        // Check if the user session type is set in the Blade template
        if (typeof window.userSessionType !== 'undefined') {
            userSessionType = window.userSessionType;
        }
        $('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));

        $.ajax({
            url: '/record/fetchByDate',
            type: 'GET',
            data: {
                startDate: start.format('YYYY-MM-DD'),
                endDate: end.format('YYYY-MM-DD'),
                'page': page,
                'userSessionType': userSessionType,
            },
            success: function (response) {
                $('#records-container').html(response);
            },
            error: function (error) {
                console.error('Error fetching records:', error);
            }
        });
    }

    function getCurrentPageNumber() {
        return parseInt($('.pagination .active span').text()) || 1; // Handle case when no page is active
    }

    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        if (window.lastOperation === 'search') { // Check if the last operation was a search
            var query = $('#search').val();
            window.fetchSearchResults(query, page);
        } else if (window.lastOperation === 'filter') { // Check if the last operation was a filter
            window.filterParams.page = page; // Update the page number in the filter parameters
            window.fetchFilterResults(window.filterParams); // Pass the filter parameters to the function
        } else if (window.lastOperation === 'datepicker') { // Check if the last operation was a datepicker
            var start = moment($('#reportrange span').html().split(' - ')[0], 'D MMM YYYY');
            var end = moment($('#reportrange span').html().split(' - ')[1], 'D MMM YYYY');

            // Update the last operation before fetching records
            window.lastOperation = 'datepicker';
            fetchRecordsOnChange(picker.startDate, picker.endDate, page); // Fetch records for the selected date range and the clicked page
        }
    });


    $('#reportrange').daterangepicker({
        "autoApply": true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "startDate": start,
        "endDate": end,
        "opens": "left"
    }, fetchRecordsOnChange(start, end));

    // Event listener for the date range picker change
    $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
        var page = getCurrentPageNumber();
        fetchRecordsOnChange(picker.startDate, picker.endDate, page);
        calender(picker.startDate, picker.endDate);
    });

    $('#prevPeriod').on('click', function () {
        start.subtract(1, 'month');
        end.subtract(1, 'month');
        $('#reportrange').data('daterangepicker').setStartDate(start);
        $('#reportrange').data('daterangepicker').setEndDate(end);
        fetchRecordsOnChange(start, end);
    });

    $('#nextPeriod').on('click', function () {
        start.add(1, 'month');
        end.add(1, 'month');
        $('#reportrange').data('daterangepicker').setStartDate(start);
        $('#reportrange').data('daterangepicker').setEndDate(end);
        fetchRecordsOnChange(start, end);
    });
});