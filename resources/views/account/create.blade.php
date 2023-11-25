<div id="createAccountModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createAccountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!--Modal Content-->
        <div class="modal-content relative p-4 text-center rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex items-center justify-between">
                <h2 class="modal-title" style="font-weight: bold; font-size:20px">Create Account</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <!-- Account creation form -->
                <form action="{{ route('account.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="accountType">Account Type</label>
                        <select name="type" class="rounded-md border-0"
                            style="height: 30px; padding:0px 10px; margin:15px 0px 0px 20px; width:50%" required>
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
                        <input type="text" name="name" class="rounded-md border-0"
                            style="height: 30px; padding:0px 10px; margin:15px 0px 0px 11px; width:50%"
                            placeholder="Account Name" required>
                    </div>
                    <div class="flex mt-6 justify-center text-white">
                        <button type="submit" style="background: #4D96EB; width:100px; height:26px; border:0px solid; border-radius: 5px">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>