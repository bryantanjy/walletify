<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/modal.css') }}">
    <script src="{{ asset('js/modal.js') }}"></script>
</head>
<x-app-layout>
    <main>
        <aside class="fixed top-16 left-0 z-40 transition-transform -translate-x-full sm:translate-x-0"
            aria-label="Sidebar" style="border-right: 2px solid white; width: 20%; height:100%;">
            <div class="h-full px-3 py-4 overflow-y-auto" style="background-color: #92C3E3">
                <ul class="space-y-2 font-medium">
                    <li>
                        <div class="flex items-center p-2 text-gray-900 rounded-lg dark:text-black mx-auto">
                            <span href="{{ route('record.index') }}" class="mx-auto"
                                style="font-size:24px; font-weight:bolder">Record</span>
                        </div>
                    </li>
                    <div class="flex justify-center">
                        <button class="justify-center rounded text-white createRecordBtn"
                            style="background: #4D96EB; width: 125px; height: 26px" data-toggle="modal"
                            data-target="#createRecordModal">
                            <i class="far fa-plus-square mr-1" style="color: #ffffff;"></i>
                            <span>Add</span>
                        </button>
                        {{-- <a href="{{ route('record.create') }}">Create Record</a> --}}

                    </div>
                </ul>
                <div class="flex flex-col items-center mt-10">
                    <div>
                        <h2 style="font-weight: bold">FILTER</h2>
                        <h4 style="font-weight: bold">CATEGORIES</h4>
                        @foreach ($categories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-4" name="category[]"
                                    value="{{ $category->category_id }}">
                                {{ $category->category_name }}
                            </label>
                        @endforeach

                        <p class="mt-4" style="font-weight: bold">RECORD TYPES</p>
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
            <div class="flex items-center mx-auto" style="width:300px">
                <i class="fa fa-caret-left ml-2 mt-2 cursor-pointer" id="prevMonth"></i>
                <div id="reportrange"
                    class="flex mx-auto mt-2 rounded-md border border-white shadow items-center pull-right relative"
                    style="width: 215px; height: 30px; font-size: 14px; background: #fff; cursor: pointer; padding: 5px 10px;">
                    <span></span><i class="fa fa-chevron-down absolute top-0 right-0 mt-2 mr-2"
                        style="font-size: 12px;"></i>
                </div>
                <i class="fa fa-caret-right mr-2 mt-2 cursor-pointer" id="nextMonth"></i>
            </div>
            @if ($records)
                <div class="mt-8 px-2 ml-14 " style="width:90%">
                    <div class="grid grid-cols-2 px-5 bg-gray-200 rounded-t-md">
                        <div><label for="selectAll"><input type="checkbox" class="mr-2" name="select_all" id="select_all">Select All</label></div>
                        <div class="text-right mr-5">Total: <b>RM9999.00</b></div>
                    </div>
                    @foreach ($records as $record)
                        <div class="grid grid-cols-6 px-5 border border-black bg-gray-200 items-center" style="height: 45px">
                            <div class="flex items-center"><input type="checkbox" name="row" id="row"></div> 
                            <div>{{ $record->category->category_name }}</div>
                            <div>{{ $record->date }} {{ $record->time }}</div>
                            <div>{{ $record->record_description }}</div>
                            <div>{{ $record->user->name }}</div>
                            <div class="text-right">RM {{ $record->amount }}
                                <i class="fa-solid fa-ellipsis-vertical ml-3"></i></div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="m-3 flex justify-center" style="font-size: 20px">No records found.</p>
            @endif
        </div>
        @include('record.create')
    </main>
</x-app-layout>
