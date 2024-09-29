<x-app-layout>
    <div class="bg-white" style="height: calc(100vh - 64px);">
        <div class="h-screen overflow-hidden">
            <!-- mobile side bar filter -->
            <div x-data="{open: false}">
                <div class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true"
                    x-show="open" x-cloak>
                    <!-- Background backdrop, show/hide based on slide-over state.  -->
                    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                    <div class="fixed inset-0 overflow-hidden" x-show="open"
                        x-transition:enter="transform transition ease-in-out duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                        <div class="absolute inset-0 overflow-hidden">
                            <div class="fixed inset-y-0 right-0 flex max-w-sm pl-10 pointer-events-none">
                                <!-- Slide-over panel, show/hide based on slide-over state. -->
                                <div class="relative w-screen max-w-md pointer-events-auto">
                                    <!-- Close button, show/hide based on slide-over state. -->
                                    <div class="absolute top-0 left-0 flex pt-4 pr-2 -ml-8 sm:-ml-10 sm:pr-4">
                                        <button @click="open = false" type="button"
                                            class="relative text-gray-300 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                            <span class="absolute -inset-2.5"></span>
                                            <span class="sr-only">Close panel</span>
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex flex-col h-full py-6 overflow-y-auto bg-white shadow-xl">
                                        <div class="px-4 sm:px-6">
                                            <h2 class="text-lg font-semibold leading-6 text-gray-900"
                                                id="slide-over-title">
                                                Filters</h2>
                                        </div>
                                        <div class="relative flex-1 px-4 mt-6 sm:px-6">
                                            <form class="border-t border-gray-200" method="GET"
                                                action="{{route('account.index')}}">

                                                <div class="px-2 py-6 border-t border-gray-200">
                                                    <h3 class="flow-root -mx-2 -my-3">
                                                        <span class="px-2 py-3 font-medium text-gray-900">Type</span>
                                                    </h3>
                                                    <!-- Filter section, show/hide based on section state. -->
                                                    <div class="pt-6" id="filter-section-mobile-2">
                                                        <div class="space-y-6">
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-0" name="type[]"
                                                                    value="General" type="checkbox"
                                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{ in_array('General',
                                                                    (array) request()->input('type', [])) ? 'checked' :
                                                                '' }}>
                                                                <label for="filter-mobile-type-0"
                                                                    class="flex-1 min-w-0 ml-3 text-gray-500">General</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-1" name="type[]"
                                                                    value="Saving" type="checkbox"
                                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{ in_array('Saving
                                                                    Account', (array) request()->input('type', [])) ?
                                                                'checked'
                                                                : '' }}>
                                                                <label for="filter-mobile-type-1"
                                                                    class="flex-1 min-w-0 ml-3 text-gray-500">Saving
                                                                    Account</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-2" name="type[]"
                                                                    value="Credit/Debit Card" type="checkbox"
                                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{
                                                                    in_array('Credit/Debit Card', (array)
                                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                                <label for="filter-mobile-type-2"
                                                                    class="flex-1 min-w-0 ml-3 text-gray-500">Credit/Debit
                                                                    Card</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-3" name="type[]"
                                                                    value="Cash" type="checkbox"
                                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                                    vonchange="this.form.submit()" {{ in_array('Cash',
                                                                    (array) request()->input('type', [])) ? 'checked' :
                                                                '' }}>
                                                                <label for="filter-mobile-type-3"
                                                                    class="flex-1 min-w-0 ml-3 text-gray-500">Cash</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-4" name="type[]"
                                                                    value="Insurance" type="checkbox"
                                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{
                                                                    in_array('Insurance', (array)
                                                                    request()->input('type', []))
                                                                ? 'checked' : '' }}>
                                                                <label for="filter-mobile-type-4"
                                                                    class="flex-1 min-w-0 ml-3 text-gray-500">Insurance</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-5" name="type[]"
                                                                    value="Loan" type="checkbox"
                                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{ in_array('Loan',
                                                                    (array) request()->input('type', [])) ? 'checked' :
                                                                '' }}>
                                                                <label for="filter-mobile-type-5"
                                                                    class="flex-1 min-w-0 ml-3 text-gray-500">Loan</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-6" name="type[]"
                                                                    value="Investment" type="checkbox"
                                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{
                                                                    in_array('Investment', (array)
                                                                    request()->input('type', []))
                                                                ? 'checked' : '' }}>
                                                                <label for="filter-mobile-type-6"
                                                                    class="flex-1 min-w-0 ml-3 text-gray-500">Investment</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <main class="px-4 mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
                    <div
                        class="flex flex-col items-baseline justify-between pb-6 border-b border-gray-200 md:flex-row md:space-y-0 md:space-x-4 pt-14">
                        <div class="relative w-full md:w-1/2">
                            <h1 class="text-4xl font-bold tracking-tight text-gray-900">Virtual Accounts</h1>
                        </div>

                        <div
                            class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                            <button data-modal-target="create-account-modal" data-modal-toggle="create-account-modal"
                                type="button"
                                class="justify-center rounded-lg px-4 py-2.5 text-white text-sm font-medium bg-blue-500 hover:bg-blue-700"
                                x-on:open-modal.window>
                                <i class="far fa-plus" style="color: #ffffff;"></i>
                                <span>Create Account</span>
                            </button>
                            <div class="flex items-center justify-end w-full space-x-3 md:w-auto">
                                <div>
                                    <button type="button" data-dropdown-toggle="dropdown"
                                        class="group inline-flex justify-center rounded-lg px-4 py-2.5 border text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100"
                                        id="menu-button" aria-expanded="false" aria-haspopup="true">
                                        Sort
                                        <svg class="flex-shrink-0 w-5 h-5 ml-1 -mr-1 text-gray-400 group-hover:text-gray-500"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div id="dropdown"
                                    class="absolute z-10 hidden p-1 mt-2 bg-white rounded-md shadow-2xl w-50 ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                    <div class="py-1" role="none">
                                        <a href="{{ route('account.index', array_merge(request()->query(), ['sort' => 'default'])) }}"
                                            class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-gray-100"
                                            @if(request('sort', 'default' )=='default' )
                                            style="background-color: #CDD6FF" @endif role="menuitem" tabindex="-1"
                                            id="menu-item-0">
                                            Default
                                        </a>
                                        <a href="{{ route('account.index', array_merge(request()->query(), ['sort' => 'newest'])) }}"
                                            class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-gray-100"
                                            @if(request('sort')=='newest' ) style="background-color: #CDD6FF" @endif
                                            role="menuitem" tabindex="-1" id="menu-item-1">
                                            Newest
                                        </a>
                                        <a href="{{ route('account.index', array_merge(request()->query(), ['sort' => 'balance_low'])) }}"
                                            class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-gray-100"
                                            @if(request('sort')=='balance_low' ) style="background-color: #CDD6FF"
                                            @endif role="menuitem" tabindex="-1" id="menu-item-2">
                                            Balance: Low to High
                                        </a>
                                        <a href="{{ route('account.index', array_merge(request()->query(), ['sort' => 'balance_high'])) }}"
                                            class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-gray-100"
                                            @if(request('sort')=='balance_high' ) style="background-color: #CDD6FF"
                                            @endif role="menuitem" tabindex="-1" id="menu-item-3">
                                            Balance: High to Low
                                        </a>
                                    </div>
                                </div>
                                <button @click="open = true" type="button"
                                    class="p-2 ml-2 -m-2 text-gray-400 border rounded-lg hover:text-gray-500 sm:ml-6 lg:hidden"
                                    aria-controls="mobileFilter">
                                    <span class="sr-only">Filters</span>
                                    <svg class="w-5 h-5" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <section class="pt-6 pb-24">
                        <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                            <!-- Filters -->
                            <form class="hidden lg:block" method="GET" action="{{route('account.index')}}">
                                <div class="py-6 border-b border-gray-200">
                                    <h3 class="flow-root -my-3"><span class="font-medium text-gray-900">Type</span></h3>
                                    <!-- Filter section, show/hide based on section state. -->
                                    <div class="pt-6" id="filter-section-0">
                                        <div class="space-y-4">
                                            <div class="flex items-center">
                                                <input id="filter-type-0" name="type[]" value="General" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded cursor-pointer focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('General', (array)
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-0"
                                                    class="ml-3 text-sm text-gray-600">General</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-type-1" name="type[]" value="Saving Account"
                                                    type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded cursor-pointer focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('Saving Account', (array)
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-1" class="ml-3 text-sm text-gray-600">Saving
                                                    Account</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-type-2" name="type[]" value="Credit/Debit Card"
                                                    type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded cursor-pointer focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('Credit/Debit Card',
                                                    (array) request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-2"
                                                    class="ml-3 text-sm text-gray-600">Credit/Debit Card</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-type-3" name="type[]" value="Cash" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded cursor-pointer focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('Cash', (array)
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-3"
                                                    class="ml-3 text-sm text-gray-600">Cash</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-type-4" name="type[]" value="Insurance"
                                                    type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded cursor-pointer focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('Insurance', (array)
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-4"
                                                    class="ml-3 text-sm text-gray-600">Insurance</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-type-5" name="type[]" value="Loan" type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded cursor-pointer focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('Loan', (array)
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-5"
                                                    class="ml-3 text-sm text-gray-600">Loan</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-type-6" name="type[]" value="Investment"
                                                    type="checkbox"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded cursor-pointer focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('Investment', (array)
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-6"
                                                    class="ml-3 text-sm text-gray-600">Investment</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Product grid -->
                            <div class="lg:col-span-3">
                                <div class="p-4">
                                    @php
                                      $i = 1;  
                                    @endphp
                                    @forelse ($accounts as $account)
                                    <div class="mb-3 bg-white rounded-md shadow-lg">
                                        <div id="account-container"
                                            class="grid items-center grid-cols-7 gap-2 px-8 border rounded-md hover:bg-blue-100"
                                            style="height: 50px">
                                            <div class="col-span-2" id="account_name">
                                                <span class="text-xs text-gray-400">Name:</span><br>
                                                <div class="text-xs truncate md:indent-2 md:text-sm"
                                                    title="{{ $account->name }}">{{ $account->name }}</div>
                                            </div>
                                            <div class="col-span-2 text-sm font-light" id="account_type">
                                                <span class="text-xs text-gray-400">Type:</span><br>
                                                <div class="text-xs truncate md:indent-2 md:text-sm"
                                                    title="{{ $account->type }}">{{ $account->type }}</div>
                                            </div>
                                            <div class="col-span-2">
                                                <span class="text-xs text-gray-400">Balance:</span><br>
                                                <div class="text-xs truncate md:indent-2 md:text-sm"
                                                    title="RM {{ $balances[$account->id] }}">RM {{
                                                    $balances[$account->id] }}</div>
                                            </div>
                                            <div class="justify-end hidden md:block">
                                                <button class="mr-4" title="View"
                                                    onclick="window.location.href='{{ route('account.show', ['account' => $account->id]) }}'">
                                                    <i class="fas fa-eye hover:text-blue-500"></i>
                                                </button>
                                                <button class="mr-4" title="Edit"
                                                    data-modal-target="edit-account-modal{{$i}}"
                                                    data-modal-toggle="edit-account-modal{{$i}}">
                                                    <i class="fas fa-edit hover:text-green-400"></i>
                                                </button>
                                                <button title="Remove"
                                                    data-modal-toggle="del-account-modal{{$i}}"
                                                    data-modal-target="del-account-modal{{$i}}">
                                                    <i class="fas fa-trash hover:text-red-600"></i>
                                                </button>
                                            </div>
                                            <div class="justify-end block dropdown-container md:hidden">
                                                <i class="p-1 cursor-pointer fa-solid fa-ellipsis-vertical focus-ring"
                                                    data-dropdown-toggle="action-dropdown-{{ $account->id }}"></i>
                                                <div id="action-dropdown-{{ $account->id }}"
                                                    class="z-10 hidden w-20 bg-white rounded-md shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                    tabindex="-1">
                                                    <div class="p-0.5">
                                                        <a href="{{ route('account.show', ['account' => $account->id]) }}"
                                                            class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-gray-100"
                                                            tabindex="-1" value="{{ $account->id }}">View</a>
                                                        <a class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-gray-100 edit-btn"
                                                            tabindex="-1" data-modal-target="edit-account-modal{{$i}}"
                                                            data-modal-toggle="edit-account-modal{{$i}}">Edit</a>
                                                        <hr>
                                                        <a class="block px-4 py-2 text-sm text-gray-500 rounded-md hover:bg-red-500 hover:text-white"
                                                            tabindex="-1" data-modal-toggle="del-account-modal{{$i}}"
                                                            data-modal-target="del-account-modal{{$i}}">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div id="del-account-modal{{$i}}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative w-full max-w-md max-h-full p-4">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="del-account-modal{{$i}}">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="p-4 text-center md:p-5">
                                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to remove <b>{{ $account->name }}</b>?</h3>
                                                    <form class="inline-flex items-center " action="{{ route('account.delete', ['account' => $account->id]) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                            Remove
                                                        </button>
                                                    </form>
                                                    <button data-modal-hide="del-account-modal{{$i}}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @include('account.edit')

                                    @php
                                        $i++;
                                    @endphp

                                    @empty
                                    <p class="flex justify-center m-3" style="font-size: 20px">No accounts found.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        @include('account.create')
                    </section>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    window.addEventListener("load", function(event) {
        document.querySelector('[data-dropdown-toggle="dropdown"]').click();
    });

    window.addEventListener("load", function(event) {
        const dropdownToggles = document.querySelectorAll('[data-dropdown-toggle="action-dropdown"]');
        dropdownToggles.forEach(function(toggle) {
            toggle.addEventListener("click", function() {
                const dropdown = toggle.nextElementSibling;
                if (dropdown.classList.contains("hidden")) {
                    dropdown.classList.remove("hidden");
                } else {
                    dropdown.classList.add("hidden");
                }
            });
        });

        // Close the dropdown if clicked outside
        document.addEventListener("click", function(event) {
            const isClickInside = event.target.closest('[data-dropdown-toggle="action-dropdown"]');
            if (!isClickInside) {
                dropdownToggles.forEach(function(toggle) {
                    const dropdown = toggle.nextElementSibling;
                    if (!dropdown.classList.contains("hidden")) {
                        dropdown.classList.add("hidden");
                    }
                });
            }
        });
    });
</script>