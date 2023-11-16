<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/filter_multi_select.css') }}" />
    <script src="{{ asset('js/filter-multi-select-bundle.min.js') }}"></script>
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
                            style="background: #4D96EB; width: 155px; height: 30px" data-bs-toggle="modal"
                            data-bs-target="#selection">
                            <i class="far fa-plus-square mr-1" style="color: #ffffff;"></i>
                            <span>Create Budget</span>
                        </button>
                    </div>
                </ul>
            </div>
        </aside>
        <div class="p-4 sm:ml-64 items-center justify-center" style="width: 80%; margin-left:20%; margin-top: 100px;">
            @if ($budgets  && count($budgets) > 0)
                @foreach ($budgets as $budget)
                    <div class="bg-white mt-5 ml-10"
                        style="width: 60%; height:auto; border-radius:15px; padding:60px 80px;">
                        <div class="flex justify-between mb-8">
                            <p class="text-gray-500">Current month</p>
                            
                            <p>Allocation amount: RM {{ $totalAllocationAmount }}</p>
                        </div>

                        {{-- Display part allocations --}}
                        @foreach ($budget->partAllocations as $partAllocation)
                            <div class="text-base font-medium dark:text-black flex justify-between">
                                <label for="part-name">{{ $partAllocation->name }}
                                    <button
                                        data-tooltip-target="tooltip-default-{{ $loop->parent->index }}-{{ $loop->index }}"
                                        type="button" class="focus:ring-4 focus:outline-none focus:ring-gray-300 ">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </button>
                                    <div id="tooltip-default-{{ $loop->parent->index }}-{{ $loop->index }}"
                                        role="tooltip"
                                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        <label for="category">Category:</label>
                                        @foreach ($partAllocation->categories as $category)
                                            <div>{{ $category->name }}</div>
                                        @endforeach
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </label>
                                <div>
                                    RM {{ $partAllocation->currentBudget }} / RM {{ $partAllocation->amount }} ({{ round($partAllocation->percentage, 0) }}%)
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                                <div class="bg-{{ $partAllocation->percentageWidth >= 80 ? 'red' : 'green' }}-400 h-4 rounded-full"
                                    style="width: {{ $partAllocation->percentageWidth }}%">
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="float-right mt-3">
                            @if ($budget->type == 'Default Template')
                                <button type="button" class="bg-blue-500 w-20 rounded editDefaultBudgetBtn"
                                    data-bs-toggle="modal" data-bs-target="#editDefaultBudgetModal"
                                    value="{{ $budget->id }}">Edit</button>
                            @else
                                <button type="button" class="bg-blue-500 w-20 rounded editUserBudgetBtn"
                                    data-bs-toggle="modal" data-bs-target="#editUserBudgetModal"
                                    value="{{ $budget->id }}">Edit</button>
                            @endif
                            <button type="button" class="bg-red-500 w-20 rounded ml-2 deleteBudgetBtn"
                                onclick="budgetDeleteModal({{ $budget->id }})">Delete</button>
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
    @include('budget.editUserTemplate')
    @include('budget.editDefaultTemplate')
</x-app-layout>

{{-- budget template selection modal --}}
<div id="selection" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="selectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg relative p-4 " role="document">
        {{-- Modal Content --}}
        <div class="modal-content rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex justify-between items-center pb-3 rounded-t">
                <h2 style="font-size:20px; margin-left:150px; margin-right:auto">Choose one from the selection below</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body flex justify-evenly">
                <button class="bg-blue-500 rounded-md hover:bg-blue-600" data-bs-toggle="modal" data-bs-target="#createBudgetTemplateModal" style="width: 200px; height: 240px">Create a new
                    template?</button>
                <button class="bg-green-500 rounded-md hover:bg-green-600" data-bs-toggle="modal" data-bs-target="#defaultBudgetTemplateModal" style="width: 200px; height: 240px">Apply the
                    default template</button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content relative p-4 text-center rounded-lg" style="background-color: #E1F1FA">
            <div class="modal-header flex justify-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body flex flex-col items-center">
                Are you sure you want to delete this budget?
            </div>
            <div class="flex justify-center items-center space-x-4">
                @if (isset($budget))
                    <form id="deleteForm" method="POST"
                        action="{{ route('budget.delete', ['budget' => $budget->id]) }}">
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

<style>
    .bg-red-400 {
        background-color: #F44336;
        /* Red color */
    }

    .bg-green-400 {
        background-color: #76FF03;
        /* Green color */
    }
</style>
