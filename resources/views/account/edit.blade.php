<div id="edit-account-modal{{$i}}" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!--Modal Content-->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal Header-->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Edit Virtual Account
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="edit-account-modal{{$i}}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            
            <form method="POST"
                action="{{ route('account.update', ['account' => $account->id]) }}" class="p-4 md:p-5">
                @csrf
                @method('PUT')

                {{-- error return --}}
                @if ($errors->any())
                <div class="border-red-500 rounded-md alert alert-danger bg-red-100 p-4 md:p-5 mb-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <input type="hidden" name="id" id="id">
                        <label for="account-type"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Account
                            Type</label>
                        <select name="type" id="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected disabled>Select account type</option>
                            <option value="General" @selected($account->type == 'General')>General</option>
                            <option value="Saving Account" @selected($account->type == 'Saving Account')>Saving Account</option>
                            <option value="Credit/Debit Card" @selected($account->type == 'Credit/Debit Card')>Credit/Debit Card</option>
                            <option value="Cash" @selected($account->type == 'Cash')>Cash</option>
                            <option value="Insurance" @selected($account->type == 'Insurance')>Insurance</option>
                            <option value="Loan" @selected($account->type == 'Loan')>Loan</option>
                            <option value="Investment" @selected($account->type == 'Investment')>Investment</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="account-name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Account
                            Name</label>
                        <input type="text" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter account name" value="{{ $account->name }}">
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center max-w-fit bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.25 6a.75.75 0 0 0-1.5 0v4.94l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V9.75Z"
                                clip-rule="evenodd" />
                        </svg>
                        Save
                    </button>
                </div>


            </form>
        </div>
    </div>
</div>
