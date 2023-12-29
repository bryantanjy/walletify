// expense.js
$(function () {
    var start = moment().subtract(29, 'days');
    var end = moment();

    // Fetch expense data and update the graph when the new date is picked
    function fetchExpenseData(start, end) {
        $('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
        $.ajax({
            url: '/statistic/expense',
            type: 'GET',
            data: {
                startDate: start.format('YYYY-MM-DD'),
                endDate: end.format('YYYY-MM-DD'),
            },
            success: function (response) {
                updateExpenseChart(response);
            },
            error: function (error) {
                console.error('Error fetching expense records:', error);
            }
        });
    }

    // Event listener for the date range picker change
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
    }, function (start, end) {
        fetchExpenseData(start, end);
    }, function (start, end) {
        fetchExpenseData(start, end);
    });

    fetchExpenseData(start, end);

    $('#prevPeriod').on('click', function () {
        start.subtract(1, 'month');
        end.subtract(1, 'month');
        $('#reportrange').data('daterangepicker').setStartDate(start);
        $('#reportrange').data('daterangepicker').setEndDate(end);
        fetchExpenseData(start, end);
    });

    $('#nextPeriod').on('click', function () {
        start.add(1, 'month');
        end.add(1, 'month');
        $('#reportrange').data('daterangepicker').setStartDate(start);
        $('#reportrange').data('daterangepicker').setEndDate(end);
        fetchExpenseData(start, end);
    });
});