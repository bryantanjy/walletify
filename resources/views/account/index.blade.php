<head>
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}
    <script type="text/javascript" src="{{ asset('js/account.js') }}"></script>
</head>

<x-app-layout>
    <div class="bg-white" style="height: calc(100vh - 64px);">
        <div class="h-screen overflow-hidden">
            {{-- mobile side bar filter --}}
            <div x-data="{open: false}">
                <div class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true"
                    x-show="open" x-cloak>
                    <!-- Background backdrop, show/hide based on slide-over state.  -->
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <div class="fixed inset-0 overflow-hidden" x-show="open"
                        x-transition:enter="transform transition ease-in-out duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                        <div class="absolute inset-0 overflow-hidden">
                            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-sm pl-10">
                                <!-- Slide-over panel, show/hide based on slide-over state. -->
                                <div class="pointer-events-auto relative w-screen max-w-md">
                                    <!-- Close button, show/hide based on slide-over state. -->
                                    <div class="absolute left-0 top-0 -ml-8 flex pr-2 pt-4 sm:-ml-10 sm:pr-4">
                                        <button @click="open = false" type="button"
                                            class="relative rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                            <span class="absolute -inset-2.5"></span>
                                            <span class="sr-only">Close panel</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex h-full flex-col overflow-y-auto bg-white py-6 shadow-xl">
                                        <div class="px-4 sm:px-6">
                                            <h2 class="text-lg font-semibold leading-6 text-gray-900"
                                                id="slide-over-title">
                                                Filters</h2>
                                        </div>
                                        <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                            <form class="border-t border-gray-200" method="GET"
                                                action="{{route('account.index')}}">

                                                <div class="border-t border-gray-200 px-2 py-6">
                                                    <h3 class="-mx-2 -my-3 flow-root">
                                                        <span class="px-2 py-3 font-medium text-gray-900">Type</span>
                                                    </h3>
                                                    <!-- Filter section, show/hide based on section state. -->
                                                    <div class="pt-6" id="filter-section-mobile-2">
                                                        <div class="space-y-6">
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-0" name="type[]"
                                                                    value="General" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{ in_array('General',
                                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                                <label for="filter-mobile-type-0"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">General</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-1" name="type[]"
                                                                    value="Saving" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{ in_array('Saving
                                                                    Account', request()->input('type', [])) ? 'checked'
                                                                : '' }}>
                                                                <label for="filter-mobile-type-1"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Saving
                                                                    Account</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-2" name="type[]"
                                                                    value="Credit/Debit Card" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{
                                                                    in_array('Credit/Debit Card',
                                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                                <label for="filter-mobile-type-2"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Credit/Debit
                                                                    Card</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-3" name="type[]"
                                                                    value="Cash" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    vonchange="this.form.submit()" {{ in_array('Cash',
                                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                                <label for="filter-mobile-type-3"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Cash</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-4" name="type[]"
                                                                    value="Insurance" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{
                                                                    in_array('Insurance', request()->input('type', []))
                                                                ? 'checked' : '' }}>
                                                                <label for="filter-mobile-type-4"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Insurance</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-5" name="type[]"
                                                                    value="Loan" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{ in_array('Loan',
                                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                                <label for="filter-mobile-type-5"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Loan</label>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <input id="filter-mobile-type-6" name="type[]"
                                                                    value="Investment" type="checkbox"
                                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                                    onchange="this.form.submit()" {{
                                                                    in_array('Investment', request()->input('type', []))
                                                                ? 'checked' : '' }}>
                                                                <label for="filter-mobile-type-6"
                                                                    class="ml-3 min-w-0 flex-1 text-gray-500">Investment</label>
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

                <main class="mx-auto max-w-screen-2xl px-4 sm:px-6 lg:px-8">
                    <div
                        class="flex flex-col items-baseline md:flex-row md:space-y-0 md:space-x-4 justify-between border-b border-gray-200 pb-6 pt-14">
                        <div class="w-full md:w-1/2 relative">
                            <h1 class="text-4xl font-bold tracking-tight text-gray-900">Virtual Accounts</h1>
                        </div>

                        <div
                            class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                            <button type="button"
                                class="justify-center rounded-lg px-4 py-2.5 text-white text-sm font-medium bg-blue-500 hover:bg-blue-700 createAccountBtn"
                                data-bs-toggle="modal" data-bs-target="#createAccountModal">
                                <i class="far fa-plus" style="color: #ffffff;"></i>
                                <span>Add Account</span>
                            </button>
                            <div class="flex items-center w-full space-x-3 md:w-auto justify-end">
                                <div>
                                    <button type="button" data-dropdown-toggle="dropdown"
                                        class="group inline-flex justify-center rounded-lg px-4 py-2.5 border text-sm font-medium text-gray-700 hover:text-gray-900"
                                        id="menu-button" aria-expanded="false" aria-haspopup="true">
                                        Sort
                                        <svg class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div id="dropdown"
                                    class="hidden absolute z-10 mt-2 p-1 w-50 rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                    <div class="py-1" role="none">
                                        <a href="{{ route('account.index', array_merge(request()->query(), ['sort' => 'default'])) }}"
                                            class="text-gray-500 block px-4 py-2 text-sm hover:bg-gray-100 rounded-md"
                                            @if(request('sort', 'default') == 'default') style="background-color: #CDD6FF" @endif
                                            role="menuitem" tabindex="-1" id="menu-item-0">
                                            Default
                                        </a>
                                        <a href="{{ route('account.index', array_merge(request()->query(), ['sort' => 'newest'])) }}"
                                            class="text-gray-500 block px-4 py-2 text-sm hover:bg-gray-100 rounded-md"
                                            @if(request('sort') == 'newest') style="background-color: #CDD6FF" @endif
                                            role="menuitem" tabindex="-1" id="menu-item-1">
                                            Newest
                                        </a>
                                        <a href="{{ route('account.index', array_merge(request()->query(), ['sort' => 'balance_low'])) }}"
                                            class="text-gray-500 block px-4 py-2 text-sm hover:bg-gray-100 rounded-md"
                                            @if(request('sort') == 'balance_low') style="background-color: #CDD6FF" @endif
                                            role="menuitem" tabindex="-1" id="menu-item-2">
                                            Balance: Low to High
                                        </a>
                                        <a href="{{ route('account.index', array_merge(request()->query(), ['sort' => 'balance_high'])) }}"
                                            class="text-gray-500 block px-4 py-2 text-sm hover:bg-gray-100 rounded-md"
                                            @if(request('sort') == 'balance_high') style="background-color: #CDD6FF" @endif
                                            role="menuitem" tabindex="-1" id="menu-item-3">
                                            Balance: High to Low
                                        </a>
                                    </div>
                                </div>
                                <button @click="open = true" type="button"
                                    class="rounded-lg border -m-2 ml-2 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden"
                                    aria-controls="mobileFilter">
                                    <span class="sr-only">Filters</span>
                                    <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <section aria-labelledby="products-heading" class="pb-24 pt-6">

                        <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                            <!-- Filters -->
                            <form class="hidden lg:block" method="GET" action="{{route('account.index')}}">
                                <div class="border-b border-gray-200 py-6">
                                    <h3 class="-my-3 flow-root"><span class="font-medium text-gray-900">Type</span></h3>
                                    <!-- Filter section, show/hide based on section state. -->
                                    <div class="pt-6" id="filter-section-0">
                                        <div class="space-y-4">
                                            <div class="flex items-center">
                                                <input id="filter-type-0" name="type[]" value="General" type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('General',
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-0"
                                                    class="ml-3 text-sm text-gray-600">General</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-type-1" name="type[]" value="Saving Account"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('Saving Account',
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-1" class="ml-3 text-sm text-gray-600">Saving
                                                    Account</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-type-2" name="type[]" value="Credit/Debit Card"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('Credit/Debit Card',
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-2"
                                                    class="ml-3 text-sm text-gray-600">Credit/Debit Card</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-type-3" name="type[]" value="Cash" type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('Cash',
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-3"
                                                    class="ml-3 text-sm text-gray-600">Cash</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-type-4" name="type[]" value="Insurance"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('Insurance',
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-4"
                                                    class="ml-3 text-sm text-gray-600">Insurance</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-type-5" name="type[]" value="Loan" type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('Loan',
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-5"
                                                    class="ml-3 text-sm text-gray-600">Loan</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input id="filter-type-5" name="type[]" value="Investment"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                    onchange="this.form.submit()" {{ in_array('Investment',
                                                    request()->input('type', [])) ? 'checked' : '' }}>
                                                <label for="filter-type-5"
                                                    class="ml-3 text-sm text-gray-600">Investment</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Product grid -->
                            <div class="lg:col-span-3">
                                @if ($accounts && count($accounts) > 0)
                                <div class="p-4" id="account-container">
                                    @foreach ($accounts as $account)
                                    <div class="rounded-md bg-white mb-3 shadow-lg">
                                        <div class="border grid grid-cols-7 gap-2 items-center rounded-md px-8 hover:bg-blue-100"
                                            style="height: 50px">
                                            <div class="col-span-2" id="account_name">
                                                <span class="text-xs text-gray-400">Name:</span><br>
                                                <div class="truncate md:indent-2 text-xs md:text-sm"
                                                    title="{{ $account->name }}">{{ $account->name }}</div>
                                            </div>
                                            <div class="col-span-2 font-light text-sm" id="account_type">
                                                <span class="text-xs text-gray-400">Type:</span><br>
                                                <div class="truncate md:indent-2 text-xs md:text-sm"
                                                    title="{{ $account->type }}">{{ $account->type }}</div>
                                            </div>
                                            <div class="col-span-2">
                                                <span class="text-xs text-gray-400">Balance:</span><br>
                                                <div class="truncate md:indent-2 text-xs md:text-sm"
                                                    title="RM {{ $balances[$account->id] }}">RM {{
                                                    $balances[$account->id] }}</div>
                                            </div>
                                            <div class="flex justify-end hidden md:block">
                                                <button class="viewAccountBtn mr-4" title="View"
                                                    onclick="window.location.href='{{ route('account.show', ['account' => $account->id]) }}'">
                                                    <i class="fas fa-eye hover:text-blue-500"></i>
                                                </button>
                                                <button class="editAccountBtn mr-4" title="Edit"
                                                    value="{{ $account->id }}">
                                                    <i class="fas fa-edit hover:text-green-400"></i>
                                                </button>
                                                <button class="deleteAccountBtn" title="Remove" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal">
                                                    <i class="fas fa-trash hover:text-red-600"></i>
                                                </button>
                                            </div>
                                            <div class="flex justify-end dropdown-container block md:hidden">
                                                <i class="fa-solid fa-ellipsis-vertical p-1 focus-ring cursor-pointer"
                                                    data-dropdown-toggle="action-dropdown-{{ $account->id }}"></i>
                                                <div id="action-dropdown-{{ $account->id }}"
                                                    class="hidden z-10 w-20 rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                    tabindex="-1">
                                                    <div class="p-0.5">
                                                        <a href="{{ route('account.show', ['account' => $account->id]) }}"
                                                            class="text-gray-500 block px-4 py-2 text-sm hover:bg-gray-100 rounded-md"
                                                            tabindex="-1" value="{{ $account->id }}">View</a>
                                                        <a class="text-gray-500 block px-4 py-2 text-sm hover:bg-gray-100 rounded-md"
                                                            tabindex="-1" value="{{ $account->id }}">Edit</a>
                                                        <hr>
                                                        <a class="text-gray-500 block px-4 py-2 text-sm hover:bg-red-500 hover:text-white rounded-md"
                                                            tabindex="-1" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- @include('account.create') --}}
                                {{-- @include('account.edit') --}}
                                @else
                                <p class="m-3 flex justify-center" style="font-size: 20px">No accounts found.</p>
                                @endif
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Delete Modal --}}
{{-- <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content relative p-4 text-center rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex justify-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body flex flex-col items-center">
                Are you sure you want to delete this account?
            </div>
            <div class="flex justify-center items-center space-x-4">
                @if (isset($account))
                <form id="deleteForm" method="POST" action="{{ route('account.delete', ['account' => $account->id]) }}">
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
</div> --}}

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