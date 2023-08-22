<div id="createRecordModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createRecordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog relative p-4 w-full  h-full md:h-auto" role="document">
        <!--Modal Content-->
        <div class="modal-content-m relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
            <div class="modal-header flex justify-between items-center pb-3 rounded-t">
                <h2 class="font-semibold " style="font-size:20px">Create Account</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <x-section-border />
            <div class="modal-body flex flex-col items-center">
                <form action="{{ route('record.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-1">
                        <div class="flex items-center">
                            <label for="accountName" class="w-32 text-left pr-2 mt-4">Account</label>
                            <select name="account_id" class="border rounded px-2 py-1"
                                style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;width:175px;"
                                required>
                                <option value="" selected disabled>Select an account</option>
                                @isset($accounts)
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->account_id }}">{{ $account->account_name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label for="recordType" class="w-32 text-left pr-2 mt-4">Type of Record</label>
                            <select name="record_type" class="border rounded px-2 py-1"
                                style="height: 30px;width:175px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;"
                                required>
                                <option value="Expense">Expense</option>
                                <option value="Income">Income</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label for="category" class="w-32 text-left pr-2 mt-4">Category</label>
                            <select name="category_name" class="fborder rounded px-2 py-1"
                                style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;width:175px;"
                                required>
                                <option value="" selected disabled>Select a category</option>
                                {{-- @foreach ($categories as $category)
                                    <option value="{{ $category['category_id'] }}">{{ $category['category_name'] }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label for="amount" class="w-32 text-left pr-2 mt-4">Amount</label>
                            <input type="text" class="border rounded px-2 py-1" name="amount" placeholder="0.00"
                                style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;text-align:right;width:175px;"
                                required>
                        </div>
                        <div class="flex items-center">
                            <label for="date" class="w-32 text-left pr-2 mt-4">Date</label>
                            <input type="text" class="border rounded px-2 py-1" name="date" placeholder="1/1/2023"
                                style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;width:175px;"
                                required>
                            <label for="time" class="w-32 text-left pr-2 mt-4 ml-10">Time</label>
                            <input type="text" class="border rounded px-2 py-1" name="time" placeholder="00:00 AM"
                                style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;width:175px;"
                                required>
                        </div>
                        <div class="flex items-center">
                            <label for="description" class="w-32 text-left pr-2 mt-4">Description</label>
                            <textarea type="text" name="record_description" class="border rounded px-2 py-1 flex-grow" placeholder="Remarks" maxlength="50"
                                style="height: 60px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;"></textarea>
                        </div>
                        <div class="flex mt-6 justify-center">
                            <button type="submit"
                                class="py-1 px-3 bg-blue-500 text-white rounded-lg hover:bg-blue-400">Add
                                Record</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
