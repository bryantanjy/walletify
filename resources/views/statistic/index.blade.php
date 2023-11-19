<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="{{ asset('js/monthpicker.js') }}"></script>
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
                <div class="flex items-center monthpicker">
                    <i class="fa fa-caret-left ml-2 cursor-pointer" id="prevMonth"></i>
                    <div id="monthrange" class="flex mx-auto rounded-md border-0 items-center">
                        <span></span>
                    </div>
                    <i class="fa fa-caret-right mr-2 cursor-pointer" id="nextMonth"></i>
                </div>
                <div></div>
            </div>
            <div class="bg-white rounded-lg px-5 py-4 mt-3 container">
                <h2 class="text-center" style="font-size: 20px">{{ __('Total Expense & Income') }}</h2>
                <div class="py-2">
                    <p class="text-gray-500" style="font-size: 20px" id="month">Current month</p>
                    <span style="font-size: 20px">Balance: RM</span>
                    <span style="font-size: 20px" id="netAmount">{{ number_format($netAmount, 2) }}</span>
                </div>
                <table class="table">
                    <thead>
                        <tr class="grid grid-cols-3 flex justify-evenly">
                            <th class="col-start-1 col-end-1">Category</th>
                            <th class="col-start-2 col-end-2 text-center">Total Income</th>
                            <th class="col-start-3 col-end-3 text-center">Total Expense</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="grid grid-cols-3 bg-gray-300">
                            <td><strong>Total</strong></td>
                            <td class="text-center" id="totalIncome"><strong>RM {{ number_format($totalIncome, 2) }}</strong></td>
                            <td class="text-center" id="totalExpense"><strong>RM {{ number_format($totalExpense, 2) }}</strong></td>
                        </tr>
                        @foreach ($data as $category => $amounts)
                        @php
                        $escapedCategory = preg_replace('/[^a-zA-Z0-9\s]/', '', $category);
                        $categoryId = str_replace(' ', '-', $escapedCategory);
                    @endphp
                    <tr class="grid grid-cols-3">
                        <td>{{ $category }}</td>
                        <td class="text-center text-success" id="{{ $categoryId }}-income">RM {{ number_format($amounts['income'], 2) }}</td>
                        <td class="text-center text-danger" id="{{ $categoryId }}-expense">RM {{ number_format($amounts['expense'], 2) }}</td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</x-app-layout>
<style>
    .table {
        --bs-table-bg: none;
    }

    #monthrange {
        width: 240px;
        background: #fff;
        cursor: pointer;
        padding: 5px 10px;
    }

    .monthpicker {
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
