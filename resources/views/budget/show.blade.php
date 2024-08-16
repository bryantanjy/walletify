<head>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<x-app-layout>
    <main>
        <div class="p-4 sm:ml-64 card mx-auto" style="width: 60%; margin-top: 100px;">
            <div class="flex">
                <button class="viewAccountBtn mr-4" onclick="window.location.href='{{ route('budget.index') }}'">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <h4>Budget details</h4>
            </div>

            <x-section-border />

            <div class="px-4">
                <div class="mb-2">
                    <div class="col">
                        <label for="name">Type:</label>
                        <span><b>{{ $budget->type }}</b></span>
                    </div>
                </div>
                <div class="row mb-2">
                    @foreach ($budget->partAllocations as $part)
                        <div class="col">
                            <label for="partName">{{ $part->name }}:</label>
                            <span><b>RM {{ $part->totalUsed }}</b> / <b>RM {{ $part->amount }}</b></span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex p-4 sm:ml-64 card mx-auto" style="width: 60%; margin-top: 20px;">
            <canvas id="budget"></canvas>
        </div>
    </main>
</x-app-layout>

<script>
    var ctx = document.getElementById('budget').getContext('2d');
    var chartData = @json($chartData);

    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($dates),
            datasets: chartData.map(item => ({
                label: item.label,
                data: item.data,
                borderColor: '#' + (Math.random().toString(16) + '000000').slice(2, 8),
                fill: false
            }))
        },
        options: {
            tension: 0.15,
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
        }
    });
</script>
