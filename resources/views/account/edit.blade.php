<div id="editAccountModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <!--Modal Content-->
        <div class="modal-content-s relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
            <div class="modal-header flex items-center justify-between">
                <h2 class="modal-title" style="font-weight: bold; font-size:20px">Edit Account</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <x-section-border />
            <div class="modal-body">
                @if (isset($account))
                    <form id="edit-form" method="POST"
                        action="{{ route('account.update', ['account' => $account->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <input type="hidden" name="account_id" id="account_id">
                            <label for="accountType">Account Type</label>
                            <select name="account_type" id="account_type" class="rounded-md"
                                style="height: 30px; padding:0px 10px; margin:15px 0px 0px 20px; width:50%">
                                <option value="General">General</option>
                                <option value="Saving Account">Saving Account</option>
                                <option value="Credit/Debit Card">Credit/Debit Card</option>
                                <option value="Cash">Cash</option>
                                <option value="Insurance">Insurance</option>
                                <option value="Loan">Loan</option>
                                <option value="Investment">Investment</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="accountName">Account Name</label>
                            <input type="text" class="rounded-md" name="account_name" id="account_name"
                                placeholder="Account Name"
                                style="height: 30px; padding:0px 10px; margin:15px 0px 0px 11px; width:50%" required>
                        </div>
                        <div class="flex mt-6 justify-center text-white">
                            <button type="submit"
                                style="background: #4D96EB; width:100px; height:26px; border:0px solid; border-radius: 5px">Save</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
