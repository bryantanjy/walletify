<head>
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}
    {{-- <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}

    {{-- <script src="{{ asset('js/daterangepicker.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/record.js') }}"></script> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/record.css') }}"> --}}
</head>

<x-app-layout>
    <div class="bg-white" style="height: calc(100vh - 64px);">
        <div class="h-screen overflow-hidden">
            <!-- mobile side bar filter -->
            <div x-data="{open: false}">
                <div class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true"
                    x-show="open" x-cloak>
                    <!-- Background backdrop, show/hide based on slide-over state.  -->
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <div class="fixed inset-0 overflow-hidden" x-show="open"
                        x-transition:enter="transform transition ease-in-out duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                        <div class="absolute inset-0 overflow-hidden">
                            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-sm pl-10">
                                <!-- Slide-over panel, show/hide based on slide-over state. -->
                                <div class="pointer-events-auto relative w-screen max-w-md">
                                    <!-- Close button, show/hide based on slide-over state. -->
                                    <div class="absolute left-0 top-0 -ml-8 flex pr-2 pt-4 sm:-ml-10 sm:pr-4">
                                        <button @click="open = false" type="button"
                                            class="relative rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                            <span class="absolute -inset-2.5"></span>
                                            <span class="sr-only">Close panel</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex h-full flex-col overflow-y-auto bg-white py-6 shadow-xl">
                                        <div class="px-4 sm:px-6">
                                            <h2 class="text-lg font-semibold leading-6 text-gray-900"
                                                id="slide-over-title">
                                                Filters</h2>
                                        </div>
                                        <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                            <form class="border-t border-gray-200" method="GET"
                                                action="{{route('account.index')}}">

                                                <div class="border-t border-gray-200 px-2 py-6">
                                                    <h3 class="-mx-2 -my-3 flow-root">
                                                        <span class="px-2 py-3 font-medium text-gray-900">Type</span>
                                                    </h3>
                                                    <!-- Filter section, show/hide based on section state. -->
                                                    <div class="pt-6" id="filter-section-mobile-2">
                                                        <div class="space-y-6">
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-0" name="type[]"
                                                                    value="General" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{ in_array('General',
                                                                    (array) request()->input('type', [])) ? 'checked' :
                                                                '' }}>
                                                                <label for="filter-mobile-type-0"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">General</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-1" name="type[]"
                                                                    value="Saving" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{ in_array('Saving
                                                                    Account', (array) request()->input('type', [])) ?
                                                                'checked'
                                                                : '' }}>
                                                                <label for="filter-mobile-type-1"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Saving
                                                                    Account</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-2" name="type[]"
                                                                    value="Credit/Debit Card" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{
                                                                    in_array('Credit/Debit Card', (array)
                                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                                <label for="filter-mobile-type-2"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Credit/Debit
                                                                    Card</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-3" name="type[]"
                                                                    value="Cash" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    vonchange="this.form.submit()" {{ in_array('Cash',
                                                                    (array) request()->input('type', [])) ? 'checked' :
                                                                '' }}>
                                                                <label for="filter-mobile-type-3"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Cash</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-4" name="type[]"
                                                                    value="Insurance" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{
                                                                    in_array('Insurance', (array)
                                                                    request()->input('type', []))
                                                                ? 'checked' : '' }}>
                                                                <label for="filter-mobile-type-4"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Insurance</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-5" name="type[]"
                                                                    value="Loan" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{ in_array('Loan',
                                                                    (array) request()->input('type', [])) ? 'checked' :
                                                                '' }}>
                                                                <label for="filter-mobile-type-5"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Loan</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-6" name="type[]"
                                                                    value="Investment" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{
                                                                    in_array('Investment', (array)
                                                                    request()->input('type', []))
                                                                ? 'checked' : '' }}>
                                                                <label for="filter-mobile-type-6"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Investment</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <main class="mx-auto max-w-screen-2xl px-4 sm:px-6 lg:px-8">
                    <div
                        class="flex flex-col items-baseline md:flex-row md:space-y-0 md:space-x-4 justify-between border-b border-gray-200 pb-6 pt-14 mb-5">
                        <div class="w-full md:w-1/2 relative">
                            <h1 class="text-4xl font-bold tracking-tight text-gray-900">Financial Records</h1>
                        </div>

                        <div
                            class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                            <button data-modal-target="create-record-modal" data-modal-toggle="create-record-modal" type="button"
                                class="justify-center rounded-lg px-4 py-2.5 text-white text-sm font-medium bg-blue-500 hover:bg-blue-700">
                                <i class="far fa-plus mr-2"></i>
                                <span>Add Record</span>
                            </button>

                            {{-- mobile filter --}}
                            {{-- <div class="flex items-center w-full md:w-auto justify-end">
                                <button @click="open = true" type="button"
                                    class="rounded-lg border -m-2 ml-2 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden"
                                    aria-controls="mobileFilter">
                                    <span class="sr-only">Filters</span>
                                    <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div> --}}
                        </div>
                    </div>

                    <!-- Table section -->
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                            <div class="w-full md:w-1/2">
                                <form class="flex items-center">
                                    <label for="simple-search" class="sr-only">Search</label>
                                    <div class="relative w-full">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
                                    </div>
                                </form>
                            </div>
                            <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                <div class="flex items-center space-x-3 w-full md:w-auto">
                                    <!-- button right section -->
                                    <div>
                                        <button type="button" data-dropdown-toggle="sort_dropdown"
                                            class="group inline-flex justify-center rounded-lg px-4 py-2.5 border text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100"
                                            id="menu-button" aria-expanded="false" aria-haspopup="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 mr-2">
                                                <path fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75Zm7 10.5a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1-.75-.75ZM2 10a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd" />
                                            </svg>
                                            Sort
                                            <svg class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- sorting dropdown -->
                                    <div id="sort_dropdown"
                                        class="hidden absolute z-10 mt-2 p-1 w-50 rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                        <div class="py-1" role="none">
                                            <a href="#"
                                                class="text-gray-500 block px-4 py-2 text-sm hover:bg-gray-100 rounded-md"
                                                
                                                role="menuitem" tabindex="-1" id="menu-item-0">
                                                By Category
                                            </a>
                                            <a href="#"
                                                class="text-gray-500 block px-4 py-2 text-sm hover:bg-gray-100 rounded-md"
                                                
                                                role="menuitem" tabindex="-1" id="menu-item-0">
                                                By Type
                                            </a>
                                            <a href="#"
                                                class="text-gray-500 block px-4 py-2 text-sm hover:bg-gray-100 rounded-md"
                                                @if(request('sort')=='newest' ) style="background-color: #CDD6FF" @endif role="menuitem"
                                                tabindex="-1" id="menu-item-1">
                                                Most Recent
                                            </a>
                                            <a href="#"
                                                class="text-gray-500 block px-4 py-2 text-sm hover:bg-gray-100 rounded-md"
                                                
                                                role="menuitem" tabindex="-1" id="menu-item-0">
                                                Oldest
                                            </a>
                                            <a href="#"
                                                class="text-gray-500 block px-4 py-2 text-sm hover:bg-gray-100 rounded-md"
                                                @if(request('sort')=='balance_low' ) style="background-color: #CDD6FF" @endif
                                                role="menuitem" tabindex="-1" id="menu-item-2">
                                                Amount: Low to High
                                            </a>
                                            <a href="#"
                                                class="text-gray-500 block px-4 py-2 text-sm hover:bg-gray-100 rounded-md"
                                                @if(request('sort')=='balance_high' ) style="background-color: #CDD6FF" @endif
                                                role="menuitem" tabindex="-1" id="menu-item-3">
                                                Amount: High to Low
                                            </a>
                                        </div>
                                    </div>
    
                                    <div class="flex items-center justify-center ml-3">
                                        <button id="dropdownDefault" data-dropdown-toggle="filter_dropdown"
                                            class="group inline-flex justify-center rounded-lg px-4 py-2.5 border text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100"
                                            type="button" aria-expanded="false" aria-haspopup="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 mr-2">
                                                <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 0 1 .628.74v2.288a2.25 2.25 0 0 1-.659 1.59l-4.682 4.683a2.25 2.25 0 0 0-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 0 1 8 18.25v-5.757a2.25 2.25 0 0 0-.659-1.591L2.659 6.22A2.25 2.25 0 0 1 2 4.629V2.34a.75.75 0 0 1 .628-.74Z" clip-rule="evenodd" />
                                            </svg>
                                            Filter
                                            <svg class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
    
                                        <!-- Filter Dropdown -->
                                        <div id="filter_dropdown" class="z-50 hidden w-52 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                                Category
                                            </h6>
                                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                                @foreach ($categories as $category)
                                                <li class="flex items-center">
                                                    <input type="checkbox" name="category[]" value="{{ $category->name }}"
                                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
    
                                                    <label for="{{ $category->name }}"
                                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $category->name }}
                                                    </label>
                                                </li>
                                                @endforeach
                                            </ul>
    
                                            <h6 class="mt-3 mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                                Type
                                            </h6>
                                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                                <li class="flex items-center">
                                                    <input type="checkbox" name="type[]" value="Expense"
                                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
    
                                                    <label for="Expense"
                                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        Expense
                                                    </label>
                                                </li>
                                                <li class="flex items-center">
                                                    <input type="checkbox" name="type[]" value="Income"
                                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
    
                                                    <label for="Income"
                                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        Income
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto h-3/6">
                            @php
                            $userSessionType = session('user_session_type', 'personal');
                            @endphp
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-[#CDD6FF] dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Category</th>
                                        @if ($userSessionType == 'personal')
                                        <th scope="col" class="px-4 py-3">Virtual Account</th>
                                        @endif
                                        <th scope="col" class="px-4 py-3">Date</th>
                                        <th scope="col" class="px-4 py-3">User</th>
                                        <th scope="col" class="px-4 py-3">Type</th>
                                        <th scope="col" class="px-4 py-3">Amount</th>
                                        <th scope="col" class="px-4 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                    @endphp
                                    @forelse ($records as $record)
                                    <tr class="border-b dark:border-gray-700">
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $record->category->name }}</th>
                                        @if ($userSessionType == 'personal')
                                        <td class="px-4 py-3">{{ $record->account->name }}</td>
                                        @endif
                                        <td class="px-4 py-3">{{ Carbon\Carbon::parse($record->datetime)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">{{ $record->user->name }}</td>
                                        <td class="px-4 py-3">{{ $record->type }}</td>
                                        <td class="px-4 py-3">{{ $record->amount }}</td>
                                        <td class="px-4 py-3 flex items-center justify-end">
                                            <button id="menu-dropdown-button" data-dropdown-toggle="menu-dropdown" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                            <div id="menu-dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="apple-imac-27-dropdown-button">
                                                    <li>
                                                        <a href="#" class="rounded-md block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="rounded-md block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                    </li>
                                                </ul>
                                                <div class="py-1">
                                                    <a href="#" class="rounded-md block py-2 px-4 text-sm text-gray-700 hover:bg-red-600 hover:text-white dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- @include('record.edit')
                                    @include('record.view') --}}

                                    <!-- Delete Modal -->
                                    <div id="del-record-modal{{$i}}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="del-record-modal{{$i}}">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="p-4 md:p-5 text-center">
                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to remove this record?</h3>
                                                    <form class="inline-flex items-center " action="{{ route('record.delete', ['record' => $record->id]) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                            Remove
                                                        </button>
                                                    </form>
                                                    <button data-modal-hide="del-record-modal{{$i}}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                    $i++;
                                    @endphp

                                    @empty
                                    <tr>
                                        <th class="px-4 py-3 text-center" colspan="7">No financial record found.</th>
                                    </tr>
                                    @endforelse
                                    
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- pagination section & data quantity -->
                        <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
                            
                        </nav>
                        @include('record.create')
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Set user session type in Blade template -->
<script>
    window.userSessionType = '{{ session('user_session_type', 'personal') }}';
</script>
