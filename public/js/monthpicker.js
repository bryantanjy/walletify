$(document).ready(function () {

    var selectedMonth = moment();

    function updateMonthDisplay(selectedMonth) {
        var formattedMonth = selectedMonth.format('MMM YYYY');
        $('#monthrange span').html(formattedMonth);
        $('#month').html(formattedMonth);

        $.ajax({
            url: '/statistic',
            type: 'GET',
            data: {
                month: selectedMonth.format('YYYY-MM')
            },
            success: function (response) {
                $('#netAmount').html(response.netAmount.toFixed(2));
                $('#totalIncome').html('<strong>RM ' + response.totalIncome.toFixed(2) + '</strong>');
                $('#totalExpense').html('<strong>RM ' + response.totalExpense.toFixed(2) + '</strong>');
                for (var category in response.data) {
                    var categoryId = category.replace(/[^a-zA-Z0-9\s]/g, '').replace(/\s+/g, '-');
                    var income = parseFloat(response.data[category].income).toFixed(2);
                    var expense = parseFloat(response.data[category].expense).toFixed(2);

                    // Using plain JavaScript to set HTML content
                    document.getElementById(categoryId + '-income').innerHTML = 'RM ' + income;
                    document.getElementById(categoryId + '-expense').innerHTML = 'RM ' + expense;
                }
            }
        });
    }

    $('#monthrange').daterangepicker({
        singleDatePicker: true,
        "startDate": selectedMonth,
        "opens": "left",
        "autoApply": true,
        "autoUpdateInput": true,
        "locale": {
            "format": "MMM YYYY",
        },
        ranges: {
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
    }, function (start) {
        selectedMonth = start;
        updateMonthDisplay(selectedMonth);
    });

    updateMonthDisplay(selectedMonth);

    $('#prevMonth').on('click', function () {
        selectedMonth.subtract(1, 'month');
        $('#monthrange').data('daterangepicker').setStartDate(selectedMonth);
        $('#monthrange').data('daterangepicker').setEndDate(selectedMonth);
        updateMonthDisplay(selectedMonth);
    });

    $('#nextMonth').on('click', function () {
        selectedMonth.add(1, 'month');
        $('#monthrange').data('daterangepicker').setStartDate(selectedMonth);
        $('#monthrange').data('daterangepicker').setEndDate(selectedMonth);
        updateMonthDisplay(selectedMonth);
    });
});
