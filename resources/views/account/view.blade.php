<head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script type="text/javascript" src="{{ asset('js/account.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<x-app-layout>
    <main>
        <div class="p-4 sm:ml-64 card mx-auto" style="width: 60%; margin-top: 100px;">
            <div class="flex">
                <button class="viewAccountBtn mr-4" onclick="window.location.href='{{ route('account.index') }}'">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h4>Account details</h4>
            </div>

            <x-section-border />

            <div class="px-4">
                <div class="row mb-2">
                    <div class="col-2">
                        <label for="name">Name:</label>
                    </div>
                    <div class="col-4">
                        <span>{{ $account->name }}</span>
                    </div>

                    <div class="col-2">
                        <label for="balance">Balance:</label>
                    </div>
                    <div class="col-4">
                        <span>RM {{ $balance }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <label for="type">Type:</label>
                    </div>
                    <div class="col-4">
                        <span>{{ $account->type }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex p-4 sm:ml-64 card mx-auto" style="width: 60%; margin-top: 20px;">
            <canvas id="account"></canvas>
        </div>
    </main>
</x-app-layout>

<script>
    var ctx = document.getElementById('account').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($dates),
            datasets: [{
                label: 'Total Balance',
                data: @json($totalBalance),
                borderColor: 'rgb(102, 178, 255)',
                fill: false
            }]
        },
        options: {
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
            },
            plugins: {
                zoom: {
                    pan: {
                        enabled: true,
                        mode: 'xy'
                    },
                    zoom: {
                        enabled: true,
                        mode: 'xy'
                    }
                }
            }
        }
    });
</script>
