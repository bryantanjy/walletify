<head>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
</head>


<x-app-layout>
    <x-slot name="header" class="max-w-screen-xl px-4 py-3 mx-auto">
        <button class="rounded-md text-xl text-gray-800 leading-tight block"
            style="background-color: #5FA7FB;width: 130px; height:40px; font-size:16px; font-weight: bold">
            {{ __('Main Account') }}
        </button>
    </x-slot>

    <main>
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

    </main>

</x-app-layout>
