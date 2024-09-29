<div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
    <div class="flex flex-col items-center p-2 space-y-4 md:flex-row md:space-y-0 md:space-x-4">
        {{-- <div class="flex flex-col items-stretch justify-between flex-shrink-0 w-1/2 space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3"> --}}
            <form class="flex items-center justify-start w-full m-0 md:w-1/3">
                @csrf
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input wire:model.debounce.300ms="search" type="search" id="default-search" class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Description"/>
                </div>
            </form>
            <!-- Date Range Picker -->
            <div id="date-range-picker" class="flex items-center justify-center w-full">
                <div class="relative w-full">
                  <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                       <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                      </svg>
                  </div>
                  <input wire:model="startDate" name="startDate" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Start">
                </div>
                <span class="mx-2 text-gray-500">-</span>
                <div class="relative w-full">
                  <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                       <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                      </svg>
                  </div>
                  <input wire:model="endDate" name="endDate" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="End">
              </div>
            </div>
            <div class="flex items-center justify-end w-full space-x-3 md:w-1/3">
                <!-- button right section -->
                <div class="relative w-full">
                    <button type="button" data-dropdown-toggle="sort_dropdown"
                        class="group inline-flex justify-center rounded-lg px-4 py-2.5 border text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100"
                        id="menu-button" aria-expanded="false" aria-haspopup="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-2 size-4">
                            <path fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75Zm7 10.5a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1-.75-.75ZM2 10a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd" />
                        </svg>
                        Sort
                        <svg class="flex-shrink-0 w-5 h-5 ml-1 -mr-1 text-gray-400 group-hover:text-gray-500"
                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <!-- sorting dropdown -->
                <div id="sort_dropdown"
                    class="absolute z-10 hidden p-1 mt-2 bg-white rounded-md shadow-2xl w-50 ring-1 ring-black ring-opacity-5 focus:outline-none"
                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-gray-100 {{ $sort === 'latest' ? 'bg-[#CDD6FF]' : '' }}"
                            tabindex="-1" wire:click.prevent="sortBy('latest')">
                            Most Recent
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-gray-100 {{ $sort === 'oldest' ? 'bg-[#CDD6FF]' : '' }}"
                            tabindex="-1" wire:click.prevent="sortBy('oldest')">
                            Oldest
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-gray-100 {{ $sort === 'category' ? 'bg-[#CDD6FF]' : '' }}"
                            tabindex="-1" wire:click.prevent="sortBy('category')">
                            By Category
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-gray-100 {{ $sort === 'type' ? 'bg-[#CDD6FF]' : '' }}"
                            tabindex="-1" wire:click.prevent="sortBy('type')">
                            By Type
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-gray-100 {{ $sort === 'small_amount' ? 'bg-[#CDD6FF]' : '' }}"
                            tabindex="-1" wire:click.prevent="sortBy('small_amount')">
                            Amount: Low to High
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-gray-100 {{ $sort === 'large_amount' ? 'bg-[#CDD6FF]' : '' }}"
                            tabindex="-1" wire:click.prevent="sortBy('large_amount')">
                            Amount: High to Low
                        </a>
                    </div>
                </div>
                <!-- filter dropdown -->
                <div class="relative w-full">
                    <button id="dropdownDefault" data-dropdown-toggle="filter_dropdown"
                        class="group inline-flex justify-center rounded-lg px-4 py-2.5 border text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100"
                        type="button" aria-expanded="false" aria-haspopup="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-2 size-4">
                            <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 0 1 .628.74v2.288a2.25 2.25 0 0 1-.659 1.59l-4.682 4.683a2.25 2.25 0 0 0-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 0 1 8 18.25v-5.757a2.25 2.25 0 0 0-.659-1.591L2.659 6.22A2.25 2.25 0 0 1 2 4.629V2.34a.75.75 0 0 1 .628-.74Z" clip-rule="evenodd" />
                        </svg>
                        Filter
                        <svg class="flex-shrink-0 w-5 h-5 ml-1 -mr-1 text-gray-400 group-hover:text-gray-500"
                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Filter Dropdown -->
                    <div id="filter_dropdown" class="z-50 hidden p-3 bg-white rounded-lg shadow w-52 dark:bg-gray-700 h-64 overflow-y-auto md:h-auto md:overflow-hidden">
                        <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                            Category
                        </h6>
                        <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                            @foreach ($categories as $category)
                            <li class="flex items-center">
                                <input type="checkbox" value="{{ $category->id }}" wire:model="selectedCategories"
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                <label for="{{ $category->name }}"
                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $category->name }}
                                </label>
                            </li>
                            @endforeach
                        </ul>

                        <h6 class="mt-3 mb-3 text-sm font-medium text-gray-900 dark:text-white">
                            Type
                        </h6>
                        <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                            <li class="flex items-center">
                                <input type="checkbox" value="Expense" wire:model="selectedTypes"
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                <label for="Expense"
                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    Expense
                                </label>
                            </li>
                            <li class="flex items-center">
                                <input type="checkbox" value="Income" wire:model="selectedTypes"
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                                <label for="Income"
                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    Income
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
    </div>
    <div class="max-w-full overflow-x-auto h-[580px]">
        @php
        $userSessionType = session('user_session_type', 'personal');
        @endphp
        <table class="w-full hidden sm:table text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-[#CDD6FF] dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3">Category</th>
                    @if ($userSessionType == 'personal')
                    <th scope="col" class="px-4 py-3">Virtual Account</th>
                    @endif
                    <th scope="col" class="px-4 py-3">Date</th>
                    <th scope="col" class="px-4 py-3">User</th>
                    <th scope="col" class="px-4 py-3">Type</th>
                    <th scope="col" class="px-4 py-3">Amount</th>
                    <th scope="col" class="px-4 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i=1;
                @endphp
                
                @forelse ($records as $record)
                    <tr class="border-b dark:border-gray-700">
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $record->category->name }}</th>
                        @if ($userSessionType == 'personal')
                        <td class="px-4 py-3">{{ $record->account->name }}</td>
                        @endif
                        <td class="px-4 py-3">{{ Carbon\Carbon::parse($record->datetime)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">{{ $record->user->name }}</td>
                        <td class="px-4 py-3">
                            @if ($record->type == 'Expense')
                            <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">{{ $record->type }}</span>
                            @else
                            <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">{{ $record->type }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">{{ $record->amount }}</td>
                        <td class="flex items-center justify-end px-4 py-3">
                            <button id="menu-dropdown-button" data-dropdown-toggle="action-dropdown-{{ $record->id }}" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                            <div id="action-dropdown-{{ $record->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <div class="p-0.5">
                                    <a class="block px-4 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        tabindex="-1" data-modal-toggle="view-record-modal{{$i}}"
                                        data-modal-target="view-record-modal{{$i}}">Show</a>
                                    <a class="block px-4 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        tabindex="-1" data-modal-toggle="edit-record-modal{{$i}}"
                                        data-modal-target="edit-record-modal{{$i}}">Edit</a>
                                    <hr>
                                    <a class="block px-4 py-2 text-sm text-gray-700 rounded-md hover:bg-red-600 hover:text-white dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                        tabindex="-1" data-modal-toggle="del-record-modal{{$i}}"
                                        data-modal-target="del-record-modal{{$i}}">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    

                    <!-- Delete Modal -->
                    <div id="del-record-modal{{$i}}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative w-full max-w-md max-h-full p-4">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="del-record-modal{{$i}}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <div class="p-4 text-center md:p-5">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to remove this record?</h3>
                                    <form class="inline-flex items-center " action="{{ route('record.delete', ['record' => $record->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            Remove
                                        </button>
                                    </form>
                                    <button data-modal-hide="del-record-modal{{$i}}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @include('record.edit')
                    @include('record.view')
                    
                    @php
                    $i++;
                    @endphp

                @empty
                    <tr>
                        <th class="px-4 py-3 text-xl text-center align-middle" rowspan="10" colspan="7">No financial record found. 
                            <p>
                                <button data-modal-target="create-record-modal" data-modal-toggle="create-record-modal" type="button"
                                    class="justify-center rounded-lg px-4 py-2.5 text-white text-sm font-medium bg-blue-500 hover:bg-blue-700">
                                    <i class="mr-2 far fa-plus"></i>
                                    <span>Create one</span>
                                </button>
                            </p>
                        </th>
                    </tr>
                @endforelse
                
            </tbody>
            <tfoot class="sticky bottom-0">
                <tr class="border-t border-b bg-[#CDD6FF] text-black">
                    <td class="px-4 py-3 font-bold text-right text-l" colspan="6">
                        Total Balance
                    </td>
                    <td class="px-4 py-3 font-bold text-right text-black text-l">
                        {{-- RM {{ $totalBalance }} --}}
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Mobile Table Layout -->
        <div class="block sm:hidden px-2">
            @forelse ($records as $record)
            <div class="mb-1 py-2 px-4 bg-white shadow rounded-lg dark:bg-gray-800 border">
                <div class="flex justify-between items-center mb-2">
                    <div class="font-bold text-gray-900 dark:text-white">{{ $record->category->name }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ Carbon\Carbon::parse($record->datetime)->format('d/m/Y') }}</div>
                </div>
                <div class="text-gray-700 dark:text-gray-300">
                    <div class="mb-1 flex justify-between">
                        @if ($userSessionType == 'personal')
                        <span class="font-medium justify-start">{{ $record->account->name }}</span> 
                        @endif
                        @if ($record->type == 'Expense')
                        <span class="text-red-500 justify-end">RM {{ $record->amount }}</span>
                        @else
                        <span class="text-green-500 justify-end">RM {{ $record->amount }}</span>
                        @endif
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-sm">By: {{ $record->user->name }}</span> 
                        <button class="px-2 py-1 text-sm text-gray-500 dark:text-gray-400">Actions</button>
                    </div>
                </div>
            </div>
            @empty
                <p class="text-center text-gray-500">No records available.</p>
                <button data-modal-target="create-record-modal" data-modal-toggle="create-record-modal" type="button"
                class="justify-center rounded-lg px-4 py-2.5 text-white text-sm font-medium bg-blue-500 hover:bg-blue-700">
                <i class="mr-2 far fa-plus"></i>Create one</button>
            @endforelse
        </div>
    </div>
    
    <!-- pagination section & data quantity -->
    <nav class="flex flex-col items-start p-4 space-y-3 justify-evenly md:flex-row md:items-center md:space-y-0">
        {{ $records->links() }}
    </nav>
    
    @include('record.create')
</div>

<script>
    document.addEventListener('livewire:load', function () {
        // Reinitialize dropdowns and modals after page load
        initDropdowns();
        initModals();
    });

    document.addEventListener('livewire:update', function () {
        // Reinitialize dropdowns and modals after Livewire DOM update
        initDropdowns();
        initModals();
    });

    function initDropdowns() {
        // Example for reinitializing dropdowns (assuming Flowbite or similar)
        document.querySelectorAll('[data-dropdown-toggle]').forEach(function (dropdownToggleEl) {
            const dropdown = new Dropdown(dropdownToggleEl); // Assuming you're using Flowbite
        });
    }

    function initModals() {
        // Example for reinitializing modals (assuming Flowbite or similar)
        document.querySelectorAll('[data-modal-toggle]').forEach(function (modalToggleEl) {
            const modalId = modalToggleEl.getAttribute('data-modal-target');
            const modalElement = document.getElementById(modalId);
            const modal = new Modal(modalElement); // Assuming you're using Flowbite
        });
    }
</script>