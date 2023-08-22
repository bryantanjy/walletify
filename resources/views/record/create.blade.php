<div id="createRecordModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createRecordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!--Modal Content-->
        <div class="modal-content relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
            <div class="modal-header flex items-center justify-between">
                <h2 class="modal-title" style="font-weight: bold; font-size:20px">Create Account</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <x-section-border />
            <div class="modal-body">

                <form action="{{ route('record.store') }}" method="POST" style="text-align: left">
                    @csrf
                    <div class="mb-3 form-group w-5/5">
                        <label for="accountName" class="w-3/5">Account</label>
                        <select name="account_id" class="form-control w-1/5 justify-items-between"
                            style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;" required>
                            <option value="" selected disabled>Select an account</option>                          
                            @isset($accounts)
                                @foreach ($accounts as $account)
                                <option value="{{ $account->account_id }}">{{ $account->account_name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="mb-3 form-group ">
                        <label for="recordType" class="w-2/5">Type of Record</label>
                        <select name="record_type" class="form-control w-3/5"
                            style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;" required>
                            <option value="Expense">Expense</option>
                            <option value="Income">Income</option>
                        </select>
                    </div>
                    <div class="mb-3 form-group ">
                        <label for="category">Category</label>
                        <select name="category_name" class="form-control"
                            style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;" required>
                            <option value="" selected disabled>Select a category</option>
                            {{-- @foreach ($categories as $category)
                                <option value="{{ $category['category_id'] }}">{{ $category['category_name'] }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="mb-3 form-group ">
                        <label for="accountName">Amount</label>
                        <input type="text" class="" name="amount" placeholder="0.00"
                            style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;" required>
                    </div>
                    <div class="mb-3 form-group ">
                        <label for="accountName">Date</label>
                        <input type="text" class="items-right" name="date" placeholder="1/1/2023"
                            style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;" required>
                        <label for="accountName">Time</label>
                        <input type="text" class="items-right" name="time" placeholder="00:00 AM"
                            style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;" required>
                    </div>
                    <div class="mb-3 form-group ">
                        <label for="accountName">Description</label>
                        <textarea type="text" name="record_description" class="form-control " placeholder="Remarks" maxlength="50"
                            style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;"></textarea>
                    </div>
                    <div class="flex mt-6 justify-center text-white">
                        <button type="submit"
                            style="background: #4D96EB; width:100px; height:26px; border:0px solid; border-radius: 5px">Add
                            Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
