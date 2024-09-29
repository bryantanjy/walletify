<x-app-layout>
    <div class="bg-white overflow-y-auto">
        <div class="overflow-y-auto">
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

                <main class="px-2 mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
                    <div
                        class="flex flex-col items-baseline justify-between pb-6 mb-5 border-b border-gray-200 md:flex-row md:space-y-0 md:space-x-4 pt-14">
                        <div class="relative w-full md:w-1/2">
                            <h1 class="text-4xl font-bold tracking-tight text-gray-900">Financial Records</h1>
                        </div>

                        <div
                            class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                            <button data-modal-target="create-record-modal" data-modal-toggle="create-record-modal" type="button"
                                class="justify-center rounded-lg px-4 py-2.5 text-white text-sm font-medium bg-blue-500 hover:bg-blue-700">
                                <i class="mr-2 far fa-plus"></i>
                                <span>Add Record</span>
                            </button>

                            {{-- mobile filter --}}
                            {{-- <div class="flex items-center justify-end w-full md:w-auto">
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
                            </div> --}}
                        </div>
                    </div>

                    <!-- Table section -->
                    <livewire:records-table />
                    
                </main>
            </div>
        </div>
    </div>
</x-app-layout>


<!-- Set user session type in Blade template -->
<script>
    window.userSessionType = '{{ session('user_session_type', 'personal') }}';
</script>
