<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/modal.css') }}">
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
                    </div>
                </ul>
                <div class="flex flex-col items-center mt-4">
                    <div>
                        <h2 style="font-weight: bold">FILTER</h2>
                        <h4 style="font-weight: bold">CATEGORIES</h4>
                        @foreach ($categories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-4" name="category[]" value="{{ $category->category_id }}">
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
        <div class="float-right p-4 sm:ml-64 " style="width: 80%;">
            @if ($records)

                <table class="mt-1 p-4 ml-14" style="width:800px">
                    <tr class="flex justify-content-between">
                        <td><input type="checkbox" name="select_all" id="select_all">Select All</td>
                        <td>RM9999.00</td>
                    </tr>
                    @foreach ($records as $record)
                        <tr>
                            <td><input type="checkbox" name="row" id="row"></td>
                            <td>{{ $record->category_id->category_name }}</td>
                            <td>{{ $record->date, $record->time }}</td>
                            <td>{{ $record->record_description }}</td>
                            <td>{{ $record->account_id->user()->name }}</td>
                            <td>{{ $record->amount }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="m-3 flex justify-center" style="font-size: 20px">No records found.</p>
            @endif
        </div>
        @include('record.create')
    </main>
</x-app-layout>
