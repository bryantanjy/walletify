<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/income.js') }}"></script>
</head>
<x-app-layout>
    <main class="flex">
        <aside class="fixed left-0 z-40 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar"
            style="border-right: 2px solid white; width: 20%; height:100vh; margin-top: 65px;">
            <div class="h-full px-3 py-4 overflow-y-auto" style="background-color: #92C3E3">
                <ul class="space-y-2 font-medium">
                    <li>
                        <div class="flex items-center p-2 text-gray-900 rounded-lg dark:text-black mx-auto">
                            <span href="{{ route('budget.index') }}" class="mx-auto"
                                style="font-size:24px;"><b>Statistics</b></span>
                        </div>
                    </li>
                    <div class="flex justify-center mt-5" style="text-align: center">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <x-nav-link class="nav-link mb-3" href="{{ route('statistic.index') }}"
                                    :active="request()->routeIs('statistic.index')"
                                    style="font-size: 18px; font-weight: bold;">{{ __('Total Expense & Income') }}</x-nav-link>
                            </li>
                            <li class="nav-item">
                                <x-nav-link class="nav-link mb-3" href="{{ route('statistic.expense') }}"
                                    :active="request()->routeIs('statistic.expense')"
                                    style="font-size: 18px; font-weight: bold;">{{ __('Expense') }}</x-nav-link>
                            </li>
                            <li class="nav-item">
                                <x-nav-link class="nav-link mb-3" href="{{ route('statistic.income') }}"
                                    :active="request()->routeIs('statistic.income')"
                                    style="font-size: 18px; font-weight: bold;">{{ __('Income') }}</x-nav-link>
                            </li>
                        </ul>
                    </div>
                </ul>
            </div>
        </aside>
        <div class="p-4 sm:ml-64 items-center justify-center" style="width: 80%; margin-left:20%; margin-top: 70px;">
            <div class="feature-bar mx-auto">
                <div></div>
                <div class="flex items-center datepicker">
                    <i class="fa fa-caret-left ml-2 cursor-pointer" id="prevPeriod"></i>
                    <div id="reportrange" class="flex mx-auto rounded-md border-0 items-center">
                        <span></span>
                    </div>
                    <i class="fa fa-caret-right mr-2 cursor-pointer" id="nextPeriod"></i>
                </div>
                <div></div>
            </div>
            <div class="bg-white rounded-lg px-5 py-4 mt-3 container">
                <h2 class="text-center" style="font-size: 20px">{{ __('Income') }}</h2>

                <canvas id="incomeChart"></canvas>
            </div>
        </div>
    </main>
</x-app-layout>
<script>
    var ctx = document.getElementById('incomeChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Current Period',
                data: [],
                borderColor: 'rgb(75, 192, 192)',
                fill: false
            }, {
                label: 'Previous Period',
                data: [],
                borderColor: 'rgb(255, 99, 132)',
                fill: false
            }]
        },
        options: {
            tooltips: {
                callbacks: {
                    title: function(tooltipItems, data) {
                        var tooltipItem = tooltipItems[0];
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var dataIndex = tooltipItem.index;
                        return dataset.labels[dataIndex]; // Return the actual label for the data point
                    }
                }
            },
            tension: 0.3,
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        unit: 'day',
                        tooltipFormat: 'll'
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    function updateIncomeChart(data) {
        chart.data.labels = Object.keys(data.currentPeriod);
        chart.data.datasets[0].data = Object.values(data.currentPeriod);
        chart.data.datasets[1].data = Object.values(data.previousPeriod);
        chart.update();
    }
</script>
<style>
    .table {
        --bs-table-bg: none;
    }

    #reportrange {
        width: 240px;
        background: #fff;
        cursor: pointer;
        padding: 5px 10px;
    }

    .datepicker {
        width: 300px;
        margin-bottom: 10px;
    }

    .feature-bar {
        display: flex;
        justify-content: space-between;
        margin-left: 60px;
        margin-right: 60px;
    }
</style>
