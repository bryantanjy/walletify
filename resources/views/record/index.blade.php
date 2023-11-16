<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css">
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/modal.css') }}"> --}}
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
                        <button class="justify-center rounded text-white createRecordBtn" data-bs-toggle="modal"
                            data-bs-target="#createRecordModal">
                            <i class="far fa-plus-square mr-1"></i>
                            <span>Add</span>
                        </button>
                    </div>
                </ul>
                <div class="flex flex-col items-center mt-10">
                    <div class="filter">
                        <h3>FILTER</h3>
                        <h3>CATEGORIES</h3>
                        @foreach ($categories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-4" name="category" value="{{ $category->name }}">
                                {{ $category->name }}
                            </label>
                        @endforeach

                        <h3 class="mt-4">RECORD TYPES</h3>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-4" name="type" value="Expense">
                            Expense
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-4" name="type" value="Income">
                            Income
                        </label>
                    </div>
                </div>
            </div>
        </aside>
        <div class="flex-1 p-4 sm:ml-64" style="width: 80%; margin-left:20%; margin-top: 65px;">
            {{-- <div class="feature-bar flex">
                <div class="relative search-icon">
                    <i class="fa-solid fa-magnifying-glass icon"></i>
                    <input type="text" class="input-field rounded-md border-none search" id="search"
                        placeholder="Search">
                </div> --}}
            {{-- <div class="flex items-center datepicker">
                    <i class="fa fa-caret-left ml-2 cursor-pointer" id="prevMonth"></i>
                    <div id="reportrange"
                        class="flex mx-auto rounded-md border border-white shadow items-center pull-right relative">
                        <span></span><i class="fa fa-chevron-down absolute top-0 right-0 mt-2 mr-2"></i>
                    </div>
                    <i class="fa fa-caret-right mr-2 cursor-pointer" id="nextMonth"></i>
                </div> --}}
            {{-- <div>
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
                </div> --}}
        </div>
        @if ($records && count($records) > 0)
            <div class="mt-12 px-2 records mr-8">
                {{-- <div class="grid grid-cols-2 px-5 bg-gray-200 rounded-t-md border border-bottom">
                        <div><label for="selectAll"><input type="checkbox" class="mr-2" name="select_all"
                                    id="select_all">&nbsp; Select All</label></div>
                        <div class="text-right mr-5">Total: <b>{{ $totalBalance < 0 ? '-' : '' }}RM
                                {{ number_format(abs($totalBalance), 2) }}</b></div>
                    </div> --}}
                {{-- @foreach ($records as $record)
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
                                        data-account-id="{{ $record->account_id }}" data-type="{{ $record->type }}"
                                        data-category-id="{{ $record->category_id }}"
                                        data-amount="{{ $record->amount }}" data-date="{{ $record->date }}"
                                        data-time="{{ $record->time }}"
                                        data-description="{{ $record->description }}">Edit</button>
                                    <button class="deleteRecordBtn"
                                        onclick="recordDeleteModal({{ $record->id }})">Delete</button>
                                </div>
                            </div>
                        </div>
                    @endforeach --}}
                <div class="bg-gray-100 p-3 rounded-md mt-6">
                    <div style="font-weight: bold; text-align:right; margin-right:50px; font-size:18px;">
                        <label for="total_balance">Total Balance: </label>
                        <span>RM {{ $totalBalance }}</span>
                    </div>

                    <table class="hover stripe order-column row-border" id="record-table">
                        <thead>
                            <th>Type</th>
                            <th>Date & Time</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>

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
        <div class="modal-content relative p-4 rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex justify-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <input type="hidden" id="recordId" value="">
            <div class="modal-body flex flex-col items-center">
                Are you sure you want to delete this record?
            </div>
            <div class="flex justify-center items-center space-x-4">
                {{-- @if (isset($record)) --}}
                    <form id="deleteForm" method="POST"
                        >
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width: 120px"
                            class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 mt-4">Yes</button>
                    </form>
                {{-- @endif --}}
                <button type="button" style="width: 120px"
                    class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-900 focus:z-10"
                    data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<style>
    .dataTables_wrapper .dataTables_length select {
        width: 60px;
    }

    .dataTables_wrapper .dataTables_filter {
        float: left;
        text-align: left;
        margin-bottom: 20
    }

    .editRecord:hover i {
        color: limegreen;
    }

    .deleteRecord:hover i {
        color: red;
    }
</style>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    // function filterSearchRecords() {
    //     var searchInput = $('#search').val().toLowerCase();

    //     $('.record-list').each(function() {
    //         var recordDescription = $(this).find('.col-start-5').text().toLowerCase();
    //         var recordElement = $(this);

    //         if (recordDescription.includes(searchInput)) {
    //             recordElement.show();
    //         } else {
    //             recordElement.hide();
    //         }
    //     });
    // }

    // $('#search').on('input', function() {
    //     filterSearchRecords();
    // });

    // filterSearchRecords();

    // function filterRecords() {
    //     var selectedCategories = [];
    //     var selectedRecordTypes = [];

    //     // Get selected categories
    //     $('.category-filter:checked').each(function() {
    //         selectedCategories.push($(this).val());
    //     });

    //     // Get selected record types
    //     $('.record-type-filter:checked').each(function() {
    //         selectedRecordTypes.push($(this).val());
    //     });

    //     // Iterate through records and hide/show based on filters
    //     $('.record-list').each(function() {
    //         var recordElement = $(this);
    //         var recordCategory = recordElement.data('category-id');
    //         var recordType = recordElement.data('record-type');

    //         var categoryMatch = selectedCategories.length === 0 || selectedCategories.includes(recordCategory);
    //         var typeMatch = selectedRecordTypes.length === 0 || selectedRecordTypes.includes(recordType);

    //         if (categoryMatch && typeMatch) {
    //             recordElement.show();
    //         } else {
    //             recordElement.hide();
    //         }
    //     });
    // }
</script>
<script>
    $(document).ready(function() {
        var table = $('#record-table').DataTable({
            iDisplayLength: 18,
            dom: '<"left"f>rt<"bottom"ip><"right">',
            processing: true,
            serverSide: true,
            ajax: '{!! route('record.recordList') !!}',
            columns: [{
                    data: 'type',
                },
                {
                    data: 'datetime',
                },
                {
                    data: 'category',
                },
                {
                    data: 'description',
                    orderable: false,
                },
                {
                    data: 'user',
                },
                {
                    data: 'amount',
                    render: DataTable.render.number(null, null, 2, 'RM '),
                    className: 'dt-body-right',
                },
                {
                    data: 'action',
                    className: 'dt-body-center',
                    searchable: false,
                    orderable: false,
                    
                }
            ],
            columnDefs: [{
                targets: 1, // Replace 'n' with the actual column index of 'datetime'
                render: function(data, type, row) {
                    // Format the datetime using Carbon and apply justify-between class
                    return moment(data).format('DD/MM/YYYY[\&nbsp;][\&nbsp;]hh:mm A');
                },
            }, ],
            order: [1, 'desc'],
            createdRow: function(row, data, dataIndex) {
                // Access the 'type' column value
                var type = data.type;

                // Get the cell element for the 'amount' column
                var amountCell = $('td', row).eq(
                    5); // Assuming 'amount' is the 6th column (index 5)

                if (type === 'Expense') {
                    amountCell.css('color', 'red');
                } else {
                    amountCell.css('color', 'limegreen');
                }
            }
        });


        $('input:checkbox').on('change', function() {
            //build a regex filter string with an or(|) condition
            var types = $('input:checkbox[name="type"]:checked').map(function() {
                return '^' + this.value + '$';
            }).get().join('|');

            //filter in column 1, with an regex, no smart filtering, not case sensitive
            table.column(0).search(types, true, false, false).draw(false);

            //build a filter string with an or(|) condition
            var categories = $('input:checkbox[name="category"]:checked').map(function() {
                return this.value;
            }).get().join('|');

            //now filter in column 2, with no regex, no smart filtering, not case sensitive
            table.column(2).search(categories, true, false, false).draw(false);

        });

        $(document).on('click', '.editRecord', function() {
            var recordId = $(this).data('id');
            var editModal = $('#editRecordModal');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: '/record/edit/' + recordId,
                success: function(data) {
                    $('#id').val(data.id);
                    $('#account_id').val(data.account_id);
                    $('#category_id').val(data.category_id);
                    $('#amount').val(data.amount);
                    $('#datetime').val(data.datetime);
                    $('#description').val(data.description);

                    editModal.modal('show');
                },
                error: function(error) {
                    console.log('Error fetching record data for editing:', error);
                }
            });
        });

        $('.deleteRecord').on('click', function() {
    var recordId = $(this).data('id');
    $('#recordId').val(recordId);
    $('#deleteForm').attr('action', '/record/delete/' + recordId);
});
    });
</script>
