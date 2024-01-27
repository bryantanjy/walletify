<head>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<x-app-layout>
    <x-slot name="header" class="max-w-screen-xl px-4 py-3 mx-auto">

        <form method="POST" action="{{ route('switch-session') }}">
            @csrf
            <div class="flex">
                <button type="submit"
                    class="rounded-md text-xl text-gray-800 leading-tight block mr-5"
                    style="background-color: #5FA7FB;width: 130px; height:40px; font-size:16px; font-weight: bold">
                    {{ __('Main Account') }}
                </button>

                {{-- group button will show here --}}
                @if (!empty($groups))
                    @foreach ($groups as $group)
                        <button type="submit" name="group_id"
                            class="rounded-md text-xl text-gray-800 leading-tight block mr-5 group-button"
                            style="background-color: #8e34ca;width: 130px; height:40px; font-size:16px; font-weight: bold"
                            value="{{ $group->id }}">{{ __($group->name) }}
                        </button>
                    @endforeach
                @endif
            </div>
        </form>

    </x-slot>

    <main>
        <div class="flex justify-evenly mx-5 mt-24">
            {{-- Expense structure part --}}
            <div class="bg-white rounded-lg py-4 px-5" style="width: 550px; height: 450px">
                <h4 style="font-size: 20px"><strong>Expense Structure</strong></h4>
                <div style="width: 90%; margin:-50 auto -25 auto;">
                    <canvas id="expenseStructure"></canvas>
                </div>
                <div class="flex justify-between">
                    <div>
                        <span class="text-gray-400">Current Month Expenses</span><br>
                        <span id="total-expenses-placeholder"><strong></strong></span>
                    </div>
                </div>
            </div>

            {{-- Recent record part --}}
            <div class="bg-white rounded-lg py-4 px-5" style="width: 550px; height: 450px">
                <h4 style="font-size: 20px"><strong>Recent Records</strong></h4>
                <div id="recentRecord">
                    <ul class="list-group list-group-flush pt-2" style="max-height: 100%;overflow-y:auto">
                        @foreach ($recentRecords as $item)
                            <li class="list-group-item flex justify-between">
                                <span class="flex items-center"><b>{{ $item->category->name }}</b></span>
                                <div class="text-right">
                                    @if ($item->type === 'Expense')
                                        <span style="color: rgb(250, 56, 56);"><b>RM {{ $item->amount }}</b></span>
                                    @else
                                        <span style="color: rgb(90, 216, 90);"><b>RM {{ $item->amount }}</b></span>
                                    @endif
                                    <br>
                                    <span
                                        style="font-size: 12px">{{ Carbon\Carbon::parse($item->datetime)->format('d/m/Y, h:i A') }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- money flow part --}}
            <div class="bg-white rounded-lg py-4 px-5" style="width: 550px; height: 450px">
                <h4 style="font-size: 20px; margin-bottom: 30px"><strong>Money Flow</strong></h4>
                <div id="moneyFlow">

                    @php
                        $totalIncome = 0;
                        $totalExpense = 0;
                        foreach ($records as $record) {
                            if ($record->type === 'Income') {
                                $totalIncome += $record->amount;
                            } elseif ($record->type === 'Expense') {
                                $totalExpense += $record->amount;
                            }
                        }
                        $totalBalance = $totalIncome - $totalExpense;
                    @endphp

                    <div class="mb-3">
                        <span class="text-gray-400" style="font-size: 20px">Current Month Balance</span><br>
                        <span style="font-size: 20px"><b>RM{{ $totalBalance }}</b></span>
                    </div>

                    <label for="totalIncome" class="flex justify-between">
                        <div class="mb-1 text-base font-medium">Income</div>
                        <div><b>RM {{ number_format($totalIncome, 2) }}</b></div>
                    </label>
                    <div class="w-full rounded-full h-4 mb-4 bg-gray-200">
                        <div class="bg-green-500 h-4 rounded-full"
                            style="width: {{ $totalIncome > 0 ? ($totalIncome / ($totalIncome + $totalExpense)) * 100 : 0 }}%">
                        </div>
                    </div>

                    <label for="totalExpense" class="flex justify-between">
                        <div class="mb-1 text-base font-medium">Expense</div>
                        <div><b>RM {{ number_format($totalExpense, 2) }}</b></div>
                    </label>
                    <div class="w-full rounded-full h-4 mb-4 bg-gray-200">
                        <div class="bg-red-500 h-4 rounded-full"
                            style="width: {{ $totalExpense > 0 ? ($totalExpense / ($totalIncome + $totalExpense)) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</x-app-layout>
<script>
    // doughnut chart component
    var labels = [];
    var data = [];

    @foreach ($monthExpenses as $expense)
        labels.push('{{ $expense->category->name }}');
        data.push({{ $expense->total_amount }});
    @endforeach

    var ctx = document.getElementById('expenseStructure').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                hoverOffset: 8,
                borderWidth: 1,
            }],
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                },

            },
        }
    });

    var totalExpenses = data.reduce((sum, amount) => sum + parseFloat(amount), 0);
    document.getElementById('total-expenses-placeholder').innerHTML = '<b>RM ' + totalExpenses.toFixed(2) +
        '</b>';

    // trigger toast @ notification
    $(document).ready(function() {
        $('.toast').toast({
            delay: 5000
        }).toast('show');
    });
</script>
