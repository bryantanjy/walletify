$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function calender(start, end) {
        $('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, calender);

    calender(start, end);

    $('#prevMonth').on('click', function() {
        start.subtract(1, 'month');
        end.subtract(1, 'month');
        $('#reportrange').data('daterangepicker').setStartDate(start);
        $('#reportrange').data('daterangepicker').setEndDate(end);
        calender(start, end);
    });

    $('#nextMonth').on('click', function() {
        start.add(1, 'month');
        end.add(1, 'month');
        $('#reportrange').data('daterangepicker').setStartDate(start);
        $('#reportrange').data('daterangepicker').setEndDate(end);
        calender(start, end);
    });
    

});