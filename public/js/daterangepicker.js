$(function () {
    var start = moment().subtract(29, 'days');
    var end = moment();

    // Fetch records for the current month by default
    function fetchRecordsOnChange(start, end) {
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
        fetchRecordsOnChange(picker.startDate, picker.endDate);
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