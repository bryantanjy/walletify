<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/modal.css') }}">
    <script src="{{ asset('js/modal.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/record.css') }}">
</head>
<x-app-layout>
    <main class="flex">
        <aside class="fixed left-0 z-40 transition-transform translate-x-full sm:translate-x-0" aria-label="Sidebar"
            style="margin-top: 65px;">
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
                                <input type="checkbox" class="mr-4 category-filter" name="category[]"
                                    value="{{ $category->category_id }}">
                                {{ $category->name }}
                            </label>
                        @endforeach

                        <h3 class="mt-4">RECORD TYPES</h3>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-4 record-type-filter" name="expense" value="Expense">
                            Expense
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-4 record-type-filter" name="income" value="Income">
                            Income
                        </label>
                    </div>
                </div>
            </div>
        </aside>
        <div class="flex-1 p-4 sm:ml-64" style="width: 80%; margin-left:20%; margin-top: 65px;">
            <div class="feature-bar flex">
                <div class="relative search-icon">
                    <i class="fa-solid fa-magnifying-glass icon"></i>
                    <input type="text" class="input-field rounded-md border-none search" id="search"
                        placeholder="Search">
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
                    <form action="{{ route('record.index') }}" method="GET">
                        @csrf
                        <label for="sorting">
                            Sort:
                            <select name="sort" id="sort" class="rounded-md border-none shadow sort"
                                onchange="this.form.submit()">
                                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                    Latest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest
                                </option>
                            </select>
                        </label>
                    </form>
                </div>
            </div>
            @if ($records && count($records) > 0)
                <div class="mt-8 px-2 ml-14 records mb-9">
                    <div class="grid grid-cols-2 px-5 bg-gray-200 rounded-t-md border border-bottom">
                        <div><label for="selectAll"><input type="checkbox" class="mr-2" name="select_all"
                                    id="select_all">&nbsp; Select All</label></div>
                        <div class="text-right mr-5">Total: <b>{{ $totalBalance < 0 ? '-' : '' }}RM
                                {{ number_format(abs($totalBalance), 2) }}</b></div>
                    </div>
                    @foreach ($records as $record)
                        <div class="grid grid-cols-9 px-5 bg-gray-200 items-center record-list mt-1 rounded-md">
                            <div class="flex items-center col-start-1 col-end-1"><input type="checkbox" name="row"
                                    id="row"></div>
                            <div class="col-start-2 col-end-2">{{ $record->category->name }}</div>
                            <div class="col-start-3 col-end-5 flex justify-evenly">
                                {{ Carbon\Carbon::parse($record->date)->format('d/m/Y') }} &nbsp;
                                {{ Carbon\Carbon::parse($record->time)->format('h:i A') }}</div>
                            <div class="col-start-5 col-end-7">{{ $record->description }}</div>
                            <div class="col-start-8 col-end-8">{{ $record->user->name }}</div>
                            <div class="text-right dropdown-container col-start-9 col-end-9" tabindex="-1">
                                @if ($record->type === 'Expense')
                                    <span style="color: rgb(250, 56, 56); font-weight:bold;">-RM
                                        {{ $record->amount }}</span>
                                @else
                                    <span style="color: rgb(90, 216, 90); font-weight:bold;">RM
                                        {{ $record->amount }}</span>
                                @endif
                                <i class="fa-solid fa-ellipsis-vertical ml-3 menu"></i>
                                <div class="dropdown shadow">
                                    <button class="editRecordBtn" data-id="{{ $record->id }}"
                                        data-account-id="{{ $record->account_id }}"
                                        data-type="{{ $record->type }}"
                                        data-category-id="{{ $record->category_id }}"
                                        data-amount="{{ $record->amount }}" data-date="{{ $record->date }}"
                                        data-time="{{ $record->time }}"
                                        data-description="{{ $record->description }}">Edit</button>
                                    {{-- <a href="{{ route('record.edit', ['record' => $record->record_id]) }}">Edit</a> --}}
                                    <button class="deleteRecordBtn"
                                        onclick="recordDeleteModal({{ $record->id }})">Delete</button>
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

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content-s relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
            <div class="modal-header flex justify-end">
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body flex flex-col items-center">
                Are you sure you want to delete this record?
            </div>
            <div class="flex justify-center items-center space-x-4">
                @if (isset($record))
                    <form id="deleteForm" method="POST"
                        action="{{ route('record.delete', ['record' => $record->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width: 120px"
                            class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 mt-4">Yes</button>
                    </form>
                @endif
                <button type="button" style="width: 120px"
                    class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-900 focus:z-10"
                    data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function filterSearchRecords() {
        var searchInput = $('#search').val().toLowerCase();

        $('.record-list').each(function() {
            var recordDescription = $(this).find('.col-start-5').text().toLowerCase();
            var recordElement = $(this);

            if (recordDescription.includes(searchInput)) {
                recordElement.show();
            } else {
                recordElement.hide();
            }
        });
    }

    $('#search').on('input', function() {
        filterSearchRecords();
    });

    filterSearchRecords();

    function filterRecords() {
        var selectedCategories = [];
        var selectedRecordTypes = [];

        // Get selected categories
        $('.category-filter:checked').each(function() {
            selectedCategories.push($(this).val());
        });

        // Get selected record types
        $('.record-type-filter:checked').each(function() {
            selectedRecordTypes.push($(this).val());
        });

        // Iterate through records and hide/show based on filters
        $('.record-list').each(function() {
            var recordElement = $(this);
            var recordCategory = recordElement.data('category-id');
            var recordType = recordElement.data('record-type');

            var categoryMatch = selectedCategories.length === 0 || selectedCategories.includes(recordCategory);
            var typeMatch = selectedRecordTypes.length === 0 || selectedRecordTypes.includes(recordType);

            if (categoryMatch && typeMatch) {
                recordElement.show();
            } else {
                recordElement.hide();
            }
        });
    }

    // Attach event listeners to category and record type checkboxes
    $('.category-filter, .record-type-filter').on('change', function() {
        filterRecords();
    });

    // Initial filtering
    filterRecords();
</script>
