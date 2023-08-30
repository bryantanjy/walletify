<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/modal.css') }}">
    <script src="{{ asset('js/modal.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/record.css') }}">
    
</head>
<x-app-layout>
    <main>
        <aside class="fixed top-16 left-0 z-40 transition-transform -translate-x-full sm:translate-x-0"
            aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                    <li>
                        <div class="flex items-center p-2 text-gray-900 rounded-lg dark:text-black mx-auto">
                            <span class="mx-auto title">Record</span>
                        </div>
                    </li>
                    <div class="flex justify-center">
                        <button class="justify-center rounded text-white createRecordBtn" data-toggle="modal"
                            data-target="#createRecordModal">
                            <i class="far fa-plus-square mr-1"></i>
                            <span>Add</span>
                        </button>
                        {{-- <a href="{{ route('record.create') }}">Create Record</a> --}}

                    </div>
                </ul>
                <div class="flex flex-col items-center mt-10">
                    <div class="filter">
                        <h3>FILTER</h3>
                        <h3>CATEGORIES</h3>
                        @foreach ($categories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-4" name="category[]"
                                    value="{{ $category->category_id }}">
                                {{ $category->category_name }}
                            </label>
                        @endforeach

                        <h3 class="mt-4">RECORD TYPES</h3>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-4" name="expense" id="expense">
                            Expense
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-4" name="income" id="income">
                            Income
                        </label>
                    </div>
                </div>
            </div>
        </aside>
        <div class="float-right p-4 sm:ml-64" style="width: 80%;">
            <div class="feature-bar flex">
                <div class="relative search-icon">
                    <i class="fa-solid fa-magnifying-glass icon"></i>
                    <input type="text" class="input-field rounded-md border-none" placeholder="Search">
                </div>
                <div class="flex items-center datepicker">
                    <i class="fa fa-caret-left ml-2 cursor-pointer" id="prevMonth"></i>
                    <div id="reportrange"
                        class="flex mx-auto rounded-md border border-white shadow items-center pull-right relative">
                        <span></span><i class="fa fa-chevron-down absolute top-0 right-0 mt-2 mr-2"></i>
                    </div>
                    <i class="fa fa-caret-right mr-2 cursor-pointer" id="nextMonth"></i>
                </div>
                <div>
                    <label for="sorting">
                        Sort:
                        <select name="sort" id="sort" class="rounded-md border-none shadow">
                            <option value="">Latest</option>
                            <option value="">Oldest</option>
                        </select>
                    </label>
                </div>
            </div>

            @if ($records)
                <div class="mt-8 px-2 ml-14 records">
                    <div class="grid grid-cols-2 px-5 bg-gray-200 rounded-t-md">
                        <div><label for="selectAll"><input type="checkbox" class="mr-2" name="select_all"
                                    id="select_all">Select All</label></div>
                        <div class="text-right mr-5">Total: <b>RM9999.00</b></div>
                    </div>
                    @foreach ($records as $record)
                        <div class="grid grid-cols-6 px-5 border border-black bg-gray-200 items-center record-list">
                            <div class="flex items-center"><input type="checkbox" name="row" id="row"></div>
                            <div>{{ $record->category->category_name }}</div>
                            <div>{{ $record->date }} {{ $record->time }}</div>
                            <div>{{ $record->record_description }}</div>
                            <div>{{ $record->user->name }}</div>
                            <div class="text-right dropdown-container" tabindex="-1">RM {{ $record->amount }}
                                <i class="fa-solid fa-ellipsis-vertical ml-3 menu"></i>
                                <div class="dropdown shadow">
                                    <button class="editRecordBtn" value="{{ $record->record_id }}"><div>Edit</div></button>
                                    <button href=""><div>Delete</div></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="m-3 flex justify-center">No records found.</p>
            @endif
        </div>
        @include('record.create')
        @include('record.edit')
    </main>
</x-app-layout>
