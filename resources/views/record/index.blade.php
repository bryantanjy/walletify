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
                    <div class="grid grid-cols-2 px-5 bg-gray-200 rounded-t-md border border-bottom">
                        <div><label for="selectAll"><input type="checkbox" class="mr-2" name="select_all"
                                    id="select_all">Select All</label></div>
                        <div class="text-right mr-5">Total: <b>RM9999.00</b></div>
                    </div>
                    @foreach ($records as $record)
                        <div class="grid grid-cols-9 px-5 bg-gray-200 items-center record-list mt-1 rounded-md">
                            <div class="flex items-center col-start-1 col-end-1" ><input type="checkbox" name="row" id="row"></div>
                            <div class="col-start-2 col-end-2">{{ $record->category->category_name }}</div>
                            <div class="col-start-3 col-end-5">{{ Carbon\Carbon::parse($record->date)->format('d/m/Y') }} {{ Carbon\Carbon::parse($record->time)->format('g:i A') }}</div>
                            <div class="col-start-5 col-end-7">{{ $record->record_description }}</div>
                            <div class="col-start-8 col-end-8">{{ $record->user->name }}</div>
                            <div class="text-right dropdown-container col-start-9 col-end-9" tabindex="-1">
                                RM {{ $record->amount }}
                                <i class="fa-solid fa-ellipsis-vertical ml-3 menu"></i>
                                <div class="dropdown shadow">
                                    <button class="editRecordBtn" 
                                        data-record-id="{{$record->record_id}}"
                                        data-account-id="{{$record->account_id}}"
                                        data-record-type="{{$record->record_type}}"
                                        data-category-id="{{$record->category_id}}"
                                        data-amount="{{$record->amount}}"
                                        data-date="{{$record->date}}"
                                        data-time="{{$record->time}}"
                                        data-record-description="{{$record->record_description}}">Edit</button>
                                    {{-- <a href="{{ route('record.edit', ['record' => $record->record_id]) }}">Edit</a> --}}
                                    <button class="deleteRecordBtn"
                                        onclick="recordDeleteModal({{ $record->record_id }})">Delete</button>
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
                        action="{{ route('record.delete', ['record' => $record->record_id]) }}">
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
