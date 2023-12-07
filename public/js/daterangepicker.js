$(function () {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function calender(start, end) {
        $('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
    }

    //  fetch record list and update when the new date is picked
    function fetchRecord(start, end) {
        $('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
        var currentPage = getCurrentPageNumber();
        fetchRecords(start, end, currentPage);
        window.lastOperation = 'datepicker';
    }

    function getCurrentPageNumber() {
        return parseInt($('.pagination .active span').text());
    }

    function fetchRecords(start, end, page) {
        $.ajax({
            url: '/record/fetchByDate',
            type: 'GET',
            data: {
                startDate: start.format('YYYY-MM-DD'),
                endDate: end.format('YYYY-MM-DD'),
                'page': page
            },
            success: function (response) {
                // updateRecordList(response);
                $('#records-container').html(response);
            },
            error: function (error) {
                console.error('Error fetching records:', error);
            }
        });
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
            fetchRecords(start, end, page); // Fetch records for the selected date range and the clicked page
        } else if (window.lastOperation === 'default') {
            fetchDefaultRecords(page);
        }
    });


    //  fetch expense data and update the graph when the new date is picked
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
                updateExpenseChart(response);
            },
            error: function (error) {
                console.error('Error fetching records:', error);
            }
        });
    }

    //  fetch income data and update the graph when the new date is picked
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
    }, fetchRecord, fetchExpensesData, fetchIncomesData,);

    fetchRecord(start, end);
    fetchExpensesData(start, end);
    fetchIncomesData(start, end);
    calender(start, end);

    $('#prevPeriod').on('click', function () {
        start.subtract(1, 'month');
        end.subtract(1, 'month');
        $('#reportrange').data('daterangepicker').setStartDate(start);
        $('#reportrange').data('daterangepicker').setEndDate(end);
        fetchRecord(start, end);
        fetchIncomesData(start, end);
        fetchExpensesData(start, end);
    });

    $('#nextPeriod').on('click', function () {
        start.add(1, 'month');
        end.add(1, 'month');
        $('#reportrange').data('daterangepicker').setStartDate(start);
        $('#reportrange').data('daterangepicker').setEndDate(end);
        fetchRecord(start, end);
        fetchIncomesData(start, end);
        fetchExpensesData(start, end);
    });
});

//  update record list
// function updateRecordList(response) {
//     if (response.records && response.records.length > 0) {
//         var recordsContainer = $('#records-container');
//         recordsContainer.empty(); // Clear existing records

//         // Create the total balance container
//         var totalBalanceContainer = $('<div class="grid px-5 bg-white rounded-md border border-bottom"></div>');
//         totalBalanceContainer.append('<div class="text-right mr-5 totalBalance">Total: <b>' + (response.totalBalance < 0 ? '-' : '') + 'RM ' + parseFloat(Math.abs(response.totalBalance)).toFixed(2) + '</b></div>');

//         // Append the total balance container to the records container
//         recordsContainer.append(totalBalanceContainer);

//         response.records.forEach(function (record) {
//             // Construct record element
//             var recordElement = $('<div class="grid grid-cols-9 px-5 bg-gray-200 items-center record-list mt-1 rounded-md hover:bg-gray-100"></div>');
//             recordElement.append('<div class="col-start-1 col-end-1 category_name"><strong>' + (record.category ? record.category.name : '') + '</strong></div>');
//             recordElement.append('<div class="col-start-2 col-end-4 datetime">' + (record.datetime ? moment(record.datetime).format('D/M/Y h:m A') : '') + '</div>');
//             recordElement.append('<div class="col-start-4 col-end-4 account_name">' + (record.account ? record.account.name : '') + '</div>');
//             recordElement.append('<div class="col-start-5 col-end-8 description">' + (record.description ? record.description : '') + '</div>');
//             recordElement.append('<div class="col-start-8 col-end-8 username">' + (record.user ? record.user.name : '') + '</div>');
//             var dropdownContainer = $('<div class="text-right dropdown-container col-start-9 col-end-9" tabindex="-1"></div>');
//             if (record.type === 'Expense') {
//                 dropdownContainer.append('<span class="amount" style="color: rgb(250, 56, 56);"><strong>-RM ' + (record.amount ? parseFloat(record.amount).toFixed(2) : '') + '</strong></span>');
//             } else {
//                 dropdownContainer.append('<span class="amount" style="color: rgb(90, 216, 90);"><strong>RM ' + (record.amount ? parseFloat(record.amount).toFixed(2) : '') + '</strong></span>');
//             }
//             dropdownContainer.append('<i class="fa-solid fa-ellipsis-vertical ml-3 menu focus-ring"></i>');
//             var dropdown = $('<div class="dropdown shadow"></div>');
//             dropdown.append('<button class="editRecordBtn" value="' + record.id + '">Edit</button>');
//             dropdown.append('<button class="deleteRecordBtn" onclick="recordDeleteModal(' + record.id + ')">Delete</button>');
//             dropdownContainer.append(dropdown);
//             recordElement.append(dropdownContainer);
//             recordsContainer.append(recordElement);
//         });
//     } else {
//         // If no records found, display a message
//         recordsContainer.append('<p class="m-3 flex justify-center">No records found.</p>');
//     }
// }