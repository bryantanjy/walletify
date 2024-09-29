<div id="edit-record-modal{{$i}}" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-lg max-h-full p-4">
        <!--Modal Content-->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal Header-->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Edit Financial Record
                </h3>
                <button type="button"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="edit-record-modal{{$i}}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <form method="POST" action="{{ route('record.update', ['record' => $record->id]) }}">
                @csrf
                @method('PUT')
                
                {{-- error return --}}
                @if ($errors->any())
                <div class="p-4 mb-3 bg-red-100 border-red-500 rounded-md alert alert-danger md:p-5">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @php
                    $userSessionType = session('user_session_type', 'personal');
                @endphp
                <div class="grid grid-cols-2 gap-4 p-4 mb-4 md:p-5">
                    <input type="hidden" name="group_id" value="{{ session('active_group_id') }}">
                    <input type="hidden" name="id" id="id" value="{{ $record->id }}">
                    <!-- Hide account selection for group session -->
                    @if ($userSessionType == 'personal')
                    <div class="col-span-2">
                        <label for="account_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Virtual Account</label>
                        <select name="account" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required>
                            <option value="" selected disabled>Select an account</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" @selected($record->account_id == $account->id)>{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    <div class="col-span-2">
                        <label for="type"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Record
                            Type</label>
                        <select name="type" id="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required>
                            <option value="" selected disabled>Select record type</option>
                            <option value="Expense" @selected($record->type == 'Expense')>Expense</option>
                            <option value="Income" @selected($record->type == 'Income')>Income</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label for="category"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                        <select name="category" id="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required>
                            <option value="" selected disabled>Select one category</option>
                            @forelse ($categories as $category)
                                <option value="{{ $category->id }}" @selected($record->category_id == $category->id)>{{ $category->name }}</option>
                            @empty
                                <option value="">No category found. Please contact Admin.</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label for="amount"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 rounded-e-0 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                <img src="{{ asset('images/ringgit.png') }}" alt="RM">
                            </span>
                            <input type="number" name="amount" id="amount" 
                            class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            min="0.01" step="0.01" value="{{ $record->amount }}" required>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label for="datetime"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                        <input type="datetime-local" name="datetime" id="datetime"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            value="{{ Carbon\Carbon::parse($record->datetime)->format('Y-m-d\TH:i') }}" required>
                    </div>

                    <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea name="description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="Write your details here...">{{ $record->description }}</textarea>                        
                    </div>

                    <div class="flex justify-center col-span-2 gap-5">
                       <button type="submit"
                            class="text-white inline-flex items-center max-w-fit bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Save
                        </button>
                        <button type="button" data-modal-hide="edit-record-modal{{$i}}"
                            class="text-white inline-flex items-center max-w-fit bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Cancel
                        </button> 
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>
