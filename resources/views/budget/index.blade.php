<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/filter_multi_select.css') }}" />
    <script src="{{ asset('js/filter-multi-select-bundle.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/modal.css') }}">
    <script src="{{ asset('js/modal.js') }}"></script>
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
                                style="font-size:24px;"><b>Budget</b></span>
                        </div>
                    </li>
                    <div class="flex justify-center">
                        <button class="justify-center rounded text-white createBudgetBtn"
                            style="background: #4D96EB; width: 155px; height: 30px" data-toggle="modal"
                            data-target="#budgetTemplateSelectionModal">
                            <i class="far fa-plus-square mr-1" style="color: #ffffff;"></i>
                            <span>Create Budget</span>
                        </button>
                    </div>
                </ul>
            </div>
        </aside>
        <div class="flex p-4 sm:ml-64 items-center justify-center"
            style="width: 80%; margin-left:20%; margin-top: 120px;">
            <div class="container bg-white" style="width: 60%; height:auto; border-radius:15px; padding:50px 80px;">
                <div class="flex justify-between mb-5">
                    <p class="text-gray-400">Current month</p>
                    <p>Allocation amount: RM 3000.00</p>
                </div>
                <div class="text-base font-medium dark:text-black flex justify-between">
                    <label for="part-name">Needs</label>
                    <div>RM1200 / RM 1500</div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                    <div class="bg-green-400 h-4 rounded-full" style="width: 80%"></div>
                </div>
                <div class="text-base font-medium dark:text-black flex justify-between">
                    <label for="part-name">Wants</label>
                    <div>RM 70 / RM 500</div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                    <div class="bg-red-500 h-4 rounded-full" style="width: 100%"></div>
                </div>
                <div class="text-base font-medium dark:text-black flex justify-between">
                    <label for="part-name">Savings</label>
                    <div>RM 70 / RM 500</div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                    <div class="bg-green-400 h-4 rounded-full" style="width: 15%"></div>
                </div>
                {{-- button --}}
                <div class="float-right mt-3">
                    <button type="button" class="bg-blue-500 w-20 rounded">Edit</button>
                    <button type="button" class="bg-red-500 w-20 rounded ml-2">Delete</button>
                </div>
            </div>

        </div>
    </main>
    @include('budget.create')
</x-app-layout>
