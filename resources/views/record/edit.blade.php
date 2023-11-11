<div id="editRecordModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <!--Modal Content-->
        <div class="modal-content-m relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
            <div class="modal-header flex items-center justify-between">
                <h2 class="modal-title" style="font-weight: bold; font-size:20px">Edit Record</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <x-section-border />
            <div class="modal-body">
                @if(isset($record))
                <form id="editRecord" method="POST" action="{{ route('record.update', ['record'=> $record->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-1">
                        <div class="flex items-center">
                            <label for="accountName" class="w-32 text-left pr-2 mt-4">Account</label>
                            <select name="account_id" id="account_id" class="rounded-md" 
                                style="height: 30px; padding:0px 10px; margin:15px 0px 0px 20px;width:175px;"
                                required>
                                <option value="" selected disabled>Select an account</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}" >{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label for="recordType" class="w-32 text-left pr-2 mt-4">Type of Record</label>
                            <select name="type" id="type" class="rounded-md" 
                                style="height: 30px;width:175px; padding:0px 10px; margin:15px 0px 0px 20px;"
                                required>
                                <option value="Expense" >Expense</option>
                                <option value="Income" >Income</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label for="category" class="w-32 text-left pr-2 mt-4">Category</label>
                            <select name="category_id" id="category_id" class="rounded-md" 
                                style="height: 30px; padding:0px 10px; margin:15px 0px 0px 20px;width:175px;"
                                required>
                                <option value="" selected disabled>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label for="amount" class="w-32 text-left pr-2 mt-4">Amount</label>
                            <input type="number" step="0.01" class="rounded-md" name="amount" id="amount"
                                placeholder="0.00" 
                                style="height: 30px; padding:0px 10px; margin:15px 0px 0px 20px;text-align:right;width:175px;"
                                required>
                        </div>
                        <div class="flex items-center">
                            <label for="date" class="w-32 text-left pr-2 mt-4">Date</label>
                            <input type="date" class="rounded-md" name="date" id="date"
                                placeholder="1/1/2023" 
                                style="height: 30px; margin:15px 0px 0px 20px;width:175px;"
                                required>
                            <label for="time" class="w-32 text-left pr-2 mt-4 ml-10">Time</label>
                            <input type="time" class="rounded-md" name="time" id="time"
                                placeholder="00:00 AM" 
                                style="height: 30px; margin:15px 0px 0px 20px;width:175px;"
                                required>
                        </div>
                        <div class="flex items-center">
                            <label for="description" class="w-32 text-left pr-2 mt-4">Description</label>
                            <textarea type="text" name="description" id="description" class="rounded-md flex-grow"
                                placeholder="Remarks" maxlength="255" style="height: 60px; padding:0px 10px; margin:15px 0px 0px 20px;"></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="record_id" name="record_id">
                    <div class="flex mt-6 justify-center text-black">
                        <button type="submit" class="mr-5"
                            style="background: #4D96EB; width:100px; height:26px; border:0px solid; border-radius: 5px">Save</button>
                        <button
                            style="background: #e5e5e5;width:100px; height:26px; border:0px solid; border-radius: 5px"
                            data-dismiss="modal">Cancel</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
