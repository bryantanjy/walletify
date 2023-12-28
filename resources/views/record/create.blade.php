<div id="createRecordModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createRecordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg relative p-4">

        <!--Modal Content-->
        <div class="modal-content relative p-4 rounded-lg" style="background-color: #E1F1FA">
            <div class="modal-header flex justify-between items-center pb-3">
                <h2 class="font-semibold" style="font-size:20px">Add Record</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForm" action="{{ route('record.store') }}" method="POST">
                    @csrf
                    <div>
                        @if ($errors->any())
                            <div class="text-red-500">
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
                        <input type="hidden" name="group_id" value="{{ session('active_group_id') }}">
                        {{-- hide this item if the session is group --}}
                        @if ($userSessionType == 'personal')
                            <div class="flex items-center form-group">
                                <label for="account_id" class="w-32 pr-2 mt-4">Account Type</label>
                                <select name="account_id" class="rounded-md border-0" value="{{ old('account_id') }}"
                                    style="height: 30px; width:225px; padding:0px 10px; margin:15px 0px 0px 20px;"
                                    required>
                                    <option value="" selected disabled>Select an account</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="flex items-center form-group">
                            <label for="type" class="w-32 pr-2 mt-4">Type of record</label>
                            <select name="type" class="rounded-md border-0" value="{{ old('type') }}"
                                style="height: 30px; width:225px; padding:0px 10px; margin:15px 0px 0px 20px;" required>
                                <option value="Expense">Expense</option>
                                <option value="Income">Income</option>
                            </select>
                        </div>
                        <div class="flex items-center form-group">
                            <label for="category_id" class="w-32 pr-2 mt-4">Category</label>
                            <select name="category_id" class="rounded-md border-0" value="{{ old('category_id') }}"
                                style="height: 30px; width:225px; padding:0px 10px; margin:15px 0px 0px 20px;" required>
                                <option value="" selected disabled>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center form-group">
                            <label for="amount" class="w-32 pr-2 mt-4">Amount</label>
                            <input type="number" step="0.01" class="rounded-md border-0" name="amount"
                                placeholder="0.00" value="{{ old('amount') }}"
                                style="height: 30px; width:225px; padding:0px 10px; margin:15px 0px 0px 20px; text-align:right;"
                                required>
                        </div>
                        <div class="flex items-center form-group">
                            <label for="datetime" class="w-32 pr-2 mt-4">Date</label>
                            <input type="datetime-local" class="rounded-md border-0" name="datetime"
                                value="{{ old('datetime') }}"
                                style="height: 30px; width:225px; margin:15px 0px 0px 20px;" required>
                        </div>
                        <div class="flex items-center form-group">
                            <label for="description" class="w-32 pr-2 mt-4">Description</label>
                            <textarea type="text" name="description" class="rounded-md flex-grow border-0" value="{{ old('description') }}"
                                placeholder="Remarks" maxlength="255" style="height: 60px; padding:0px 10px; margin:15px 0px 0px 20px;"></textarea>
                        </div>
                        <div class="flex mt-6 justify-center">
                            <button type="submit"
                                class="py-1 px-3 bg-blue-500 text-white rounded-md hover:bg-blue-400">Add
                                Record</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
