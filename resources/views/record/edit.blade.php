@php
    $accounts = $accounts ?? [];
@endphp
<div id="editRecordModal" class="recordModal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <!--Modal Content-->
        <div class="modal-content-m relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
            <div class="modal-header flex items-center justify-between">
                <h2 class="modal-title" style="font-weight: bold; font-size:20px">Edit Record</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <x-section-border />
            <div class="modal-body">
                <form id="edit-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-1">
                        <div class="flex items-center">
                            <label for="accountName" class="w-32 text-left pr-2 mt-4">Account</label>
                            <select name="account_name" id="account_name" class="border rounded-md px-2 py-1"
                                style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;width:175px;"
                                required>
                                <option value="" selected disabled>Select an account</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->account_id }}">{{ $account->account_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label for="recordType" class="w-32 text-left pr-2 mt-4">Type of Record</label>
                            <select name="record_type" id="record_type" class="border rounded-md px-2 py-1"
                                style="height: 30px;width:175px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;"
                                required>
                                <option value="Expense">Expense</option>
                                <option value="Income">Income</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label for="category" class="w-32 text-left pr-2 mt-4">Category</label>
                            <select name="category_name" id="category_name" class="border rounded-md px-2 py-1"
                                style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;width:175px;"
                                required>
                                <option value="" selected disabled>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label for="amount" class="w-32 text-left pr-2 mt-4">Amount</label>
                            <input type="number" class="border rounded-md px-2 py-1" name="amount" id="amount"
                                placeholder="0.00"
                                style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;text-align:right;width:175px;"
                                required>
                        </div>
                        <div class="flex items-center">
                            <label for="date" class="w-32 text-left pr-2 mt-4">Date</label>
                            <input type="date" class="border rounded-md px-2 py-1" name="date" id="date"
                                placeholder="1/1/2023"
                                style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;width:175px;"
                                required>
                            <label for="time" class="w-32 text-left pr-2 mt-4 ml-10">Time</label>
                            <input type="time" class="border rounded-md px-2 py-1" name="time" id="time"
                                placeholder="00:00 AM"
                                style="height: 30px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;width:175px;"
                                required>
                        </div>
                        <div class="flex items-center">
                            <label for="description" class="w-32 text-left pr-2 mt-4">Description</label>
                            <textarea type="text" name="record_description" id="record_description" class="border rounded-md px-2 py-1 flex-grow"
                                placeholder="Remarks" maxlength="50" style="height: 60px; padding:0px 10px 0px 10px; margin:15px 0px 0px 20px;"></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="record_id" name="record_id">
                    <div class="flex mt-6 justify-center text-white">
                        <button type="submit"
                            style="background: #4D96EB; width:100px; height:26px; border:0px solid; border-radius: 5px">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.editRecordBtn', function() {
                    var recordId = $(this).val();
                    var editRecord = $('#editRecordModal');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: '/record/edit/' + recordId,
                    success: function(data) {

                        $.get('/account', function(data) {
                            var accountSelect = $('#account_name');
                            accountSelect.empty();
                            accountSelect.append(new Option('Select an account', ''));
                            if ($.isArray(data)) {
                                // Add the new options from the fetched data
                                $.each(data, function(index, account) {
                                    accountSelect.append(new Option(account.account_name,
                                        account.account_id));
                                });
                            }
                        });
                        editRecord.find('#account_name').val(data.account_id);
                        editRecord.find('#record_type').val(data.record_type);
                        editRecord.find('#category_name').val(data.category_id);
                        editRecord.find('#amount').val(data.amount);
                        editRecord.find('#date').val(data.date);
                        editRecord.find('#time').val(data.time);
                        editRecord.find('#record_description').val(data.record_description);
                        editRecord.find('#record_id').val(data.record_id);

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

                // Submit form using AJAX
                $('#edit-form').submit(function(event) {
                    event.preventDefault();
                    var formData = $(this).serialize();
                    var recordId = {{ $record->record_id }}; // Pass the record ID from the controller

                    $.ajax({
                        type: 'PUT',
                        url: '/record/update/' + recordId,
                        data: formData,
                        success: function(response) {
                            window.location.href = '{{ route('record.index') }}';
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
</script>
