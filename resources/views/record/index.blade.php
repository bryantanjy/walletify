<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/record.js') }}"></script>
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
            @if (session('success'))
                <div class="position-fixed top-20 end-0 p-3" style="z-index: 100">
                    <div class="toast align-items-center bg-green-100 border-0" role="alert" aria-live="assertive"
                        aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fa-regular fa-circle-check" style="color: #48f745;"></i>
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>
                </div>
            @elseif (session('error'))
                <div class="position-fixed top-20 end-0 p-3" style="z-index: 100">
                    <div class="toast align-items-center bg-red-100 border-0" role="alert" aria-live="assertive"
                        aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fa-regular fa-triangle-exclamation" style="color: #dc0404;"></i>
                                {{ session('error') }}
                            </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="feature-bar flex">
                <div class="relative search-icon">
                    <i class="fa-solid fa-magnifying-glass icon"></i>
                    <input type="text" class="input-field rounded-md border-none search" id="search"
                        placeholder="Search">
                </div>
                <div class="flex items-center datepicker">
                    <i class="fa fa-caret-left ml-2 cursor-pointer" id="prevPeriod"></i>
                    <div id="reportrange" class="flex mx-auto rounded-md border-0 justify-between items-center">
                        <span></span><i class="fa-solid fa-caret-down"></i>
                    </div>
                    <i class="fa fa-caret-right mr-2 cursor-pointer" id="nextPeriod"></i>
                </div>
                <div>
                    <form action="{{ route('record.index') }}" method="GET">
                        @csrf
                        <label for="sorting">
                            Sort:
                            <select name="sort" id="sort" class="rounded-md border-0 sort"
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
                <div class="records" id="records-container">
                    <div class="grid px-5 bg-white rounded-md border border-bottom">
                        <div class="text-right mr-5 totalBalance">Total: <b>{{ $totalBalance < 0 ? '-' : '' }}RM
                                {{ number_format(abs($totalBalance), 2) }}</b></div>
                    </div>
                    @foreach ($records as $record)
                        <div class="grid grid-cols-9 px-5 bg-gray-200 items-center record-list mt-1 rounded-md hover:bg-gray-100">
                            <div class="col-start-1 col-end-1 category_name"><strong>{{ $record->category->name }}</strong></div>
                            <div class="col-start-2 col-end-4 datetime">
                                {{ Carbon\Carbon::parse($record->datetime)->format('d/m/Y h:i A') }}</div>
                            <div class="col-start-4 col-end-4 account_name">{{ $record->account->name }}</div>
                            <div class="col-start-5 col-end-8 description">{{ $record->description }}</div>
                            <div class="col-start-8 col-end-8 username">{{ $record->user->name }}</div>
                            <div class="text-right dropdown-container col-start-9 col-end-9" tabindex="-1">
                                @if ($record->type === 'Expense')
                                    <span class="amount" style="color: rgb(250, 56, 56);"><strong>-RM
                                            {{ $record->amount }}</strong></span>
                                @else
                                    <span class="amount" style="color: rgb(90, 216, 90);"><strong>RM
                                            {{ $record->amount }}</strong></span>
                                @endif
                                <i class="fa-solid fa-ellipsis-vertical ml-3 menu focus-ring"></i>
                                <div class="dropdown shadow">
                                    <button class="editRecordBtn" value="{{ $record->id }}">Edit</button>
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
                    data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
