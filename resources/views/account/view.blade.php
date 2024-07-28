<head>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}
    <script type="text/javascript" src="{{ asset('js/account.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<x-app-layout>
    <div class="bg-white">
        <div class="h-screen overflow-hidden">
            <main class="mx-auto max-w-screen-2xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-row items-baseline md:space-y-0 md:space-x-4 border-b border-gray-200 pb-6 pt-14">
                    <button class="viewAccountBtn mx-5" onclick="window.location.href='{{ route('account.index') }}'">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <h4 class="text-xl font-semibold tracking-tight text-gray-900">Account details</h4>
                </div>

                <div class="mt-3 p-4 card mx-auto shadow-lg rounded-md">
                    <div class="px-4 lg:grid lg:grid-cols-3">
                        <div>
                            <label for="name">Name &nbsp;&nbsp;&nbsp;&nbsp;: </label>
                            <span>{{ $account->name }}</span>
                        </div>
                        <div>
                            <label for="type">Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </label>
                            <span>{{ $account->type }}</span>
                        </div>
                        <div>
                            <label for="balance">Balance &nbsp;: </label>
                            <span>RM {{ $balance }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex p-4 mt-5 card shadow-2xl` mx-auto">
                    <canvas id="account"></canvas>
                </div>
            </main>
        </div>
    </div>
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