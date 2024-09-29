<div id="view-record-modal{{$i}}" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-lg max-h-full p-4">
        <!--Modal Content-->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal Header-->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Financial Record Details
                </h3>
                <button type="button"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="view-record-modal{{$i}}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            
            <div class="p-4 modal-body md:p-5">
                @php
                    $userSessionType = session('user_session_type', 'personal');
                @endphp
                <input type="hidden" name="group_id" value="{{ session('active_group_id') }}">
                {{-- hide this item if the session is group --}}
                @if ($userSessionType == 'personal')
                    <div class="col-span-2 mb-4">
                        <label for="account_id" class="w-32 pr-2 mt-4">Account Type:</label>
                        <span id="account_name">{{ $record->account->name }}</span>
                    </div>
                @endif

                <div class="col-span-2 mb-4">
                    <label for="recordType" class="w-32 pr-2 mt-4 text-left">Type of Record:</label>
                    <span id="record_type">{{ $record->type }}</span>
                </div>
                <div class="col-span-2 mb-4">
                    <label for="category" class="w-32 pr-2 mt-4 text-left">Category:</label>
                    <span id="category_name">{{ $record->category->name }}</span>
                </div>
                <div class="col-span-2 mb-4">
                    <label for="amount" class="w-32 pr-2 mt-4 text-left">Amount:</label>
                    <span id="amount">{{ $record->amount }}</span>
                </div>
                <div class="col-span-2 mb-4">
                    <label for="datetime" class="w-32 pr-2 mt-4 text-left">Date:</label>
                    <span id="datetime">{{ Carbon\Carbon::parse($record->datetime)->format('d/m/Y, h:i A') }}</span>
                </div>
                <div class="col-span-2 mb-4">
                    <label for="description" class="w-32 pr-2 mt-4 text-left">Description:</label>
                    <span id="description">{{ $record->description }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
