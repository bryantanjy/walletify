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
            @if ($budgets && count($budgets) > 0)
                @foreach ($budgets as $budget)
                    <div class="container bg-white"
                        style="width: 60%; height:auto; border-radius:15px; padding:50px 80px;">
                        <div class="flex justify-between mb-5">
                            <p class="text-gray-400">Current month</p>
                            <p>Allocation amount: RM {{-- sum of allocation amount belongs to one budget--}}</p>
                        </div>
                        @foreach ($budget->budgetTemplateParts as $part)
                            <div class="text-base font-medium dark:text-black flex justify-between">
                                <label for="part-name">{{-- part name --}}</label>
                                <div>
                                    RM {{-- sum of amount in the record where the category match the part allocation category table's category id for each part (if the record type have income then minus with record type expense) --}} / RM {{-- allocation amount of this part --}}
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                                <div class="bg-green-400 h-4 rounded-full" style="width: 80%"></div>
                            </div>
                        @endforeach
                        {{-- button --}}
                        <div class="float-right mt-3">
                            <button type="button" class="bg-blue-500 w-20 rounded">Edit</button>
                            <button type="button" class="bg-red-500 w-20 rounded ml-2">Delete</button>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="m-3 flex justify-center">No budget found.</p>
            @endif
        </div>
    </main>
    @include('budget.createUserTemplate')
    @include('budget.createDefaultTemplate')

</x-app-layout>

{{-- budget template selection modal --}}
<div id="budgetTemplateSelectionModal" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="budgetTemplateSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog relative p-4 w-full  h-full md:h-auto" role="document">
        {{-- Modal Content --}}
        <div class="modal-content-m relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
            <div class="modal-header flex justify-between items-center pb-3 rounded-t">
                <h2 style="font-size:20px; margin-left:auto; margin-right:auto">Choose one from the selection below</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body flex justify-evenly my-10">
                <button class="bg-blue-500 rounded-md createTemplate" style="width: 250px; height: 240px"
                    data-template-type="user_defined">Create a new
                    template?</button>
                <button class="bg-green-500 rounded-md defaultTemplate" style="width: 250px; height: 240px"
                    data-template-type="default">Apply the
                    default template</button>
            </div>
        </div>
    </div>
</div>
