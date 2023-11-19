$(function () {

    var start = moment().subtract(29, 'days');
    var end = moment();
    var period = end.diff(start, 'days');

    function calender(start, end) {
        $('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));

        // fetchRecords(start, end);
    }

    function fetchExpensesData(start, end) {
        $('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
        
        $.ajax({
            url: '/statistic/expense',
            type: 'GET',
            data: {
                startDate: start.format('YYYY-MM-DD'),
                endDate: end.format('YYYY-MM-DD'),
            },
            success: function (response) {
                console.log(response);
                updateExpenseChart(response);
            }
        });
    }

    function fetchIncomesData(start, end) {
        $('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
        
        $.ajax({
            url: '/statistic/income',
            type: 'GET',
            data: {
                startDate: start.format('YYYY-MM-DD'),
                endDate: end.format('YYYY-MM-DD'),
            },
            success: function (response) {
                updateIncomeChart(response);
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
    }, fetchExpensesData,
        fetchIncomesData,
    );

    // updateExpense(start, end);
    fetchExpensesData(start, end);
    fetchIncomesData(start, end);
    calender(start, end);

    $('#prevPeriod').on('click', function () {
        start.subtract(period, 'days');
        end.subtract(period, 'days');
        $('#reportrange').data('daterangepicker').setStartDate(start);
        $('#reportrange').data('daterangepicker').setEndDate(end);
        fetchIncomesData(start, end);
        fetchExpensesData(start, end);
    });

    $('#nextPeriod').on('click', function () {
        start.add(period, 'days');
        end.add(period, 'days');
        $('#reportrange').data('daterangepicker').setStartDate(start);
        $('#reportrange').data('daterangepicker').setEndDate(end);
        fetchIncomesData(start, end);
        fetchExpensesData(start, end);
    });
});

// function fetchRecords(startDate, endDate) {
//     // Adjust this part based on your actual AJAX request
//     $.ajax({
//         type: 'GET',
//         url: '/record/', // Replace with your actual API endpoint
//         data: {
//             startDate: startDate.format('YYYY-MM-DD'),
//             endDate: endDate.format('YYYY-MM-DD')
//         },
//         success: function (response) {
//             // Update your UI with the fetched records
//             console.log('Records fetched successfully:', response);
//             updateRecordsOnPage();
//         },
//         error: function (error) {
//             console.error('Error fetching records:', error);
//         }
//     });
// }