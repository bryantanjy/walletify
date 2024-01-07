{{-- show record modal --}}
<div id="showModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showRecordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg relative p-4">

        <!--Modal Content-->
        <div class="modal-content relative p-4 rounded-lg" style="background-color: #E1F1FA">
            <div class="modal-header flex justify-between items-center pb-3">
                <h2 class="font-semibold" style="font-size:20px">Record details</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                @if (isset($record))
                    <div>
                        @php
                            $userSessionType = session('user_session_type', 'personal');
                        @endphp
                        <input type="hidden" name="group_id" value="{{ session('active_group_id') }}">
                        {{-- hide this item if the session is group --}}
                        @if ($userSessionType == 'personal')
                            <div>
                                <label for="account_id" class="w-32 pr-2 mt-4">Account Type:</label>
                                <span id="account_name"></span>
                            </div>
                        @endif

                        <div>
                            <label for="recordType" class="w-32 text-left pr-2 mt-4">Type of Record:</label>
                            <span id="record_type"></span>
                        </div>
                        <div>
                            <label for="category" class="w-32 text-left pr-2 mt-4">Category:</label>
                            <span id="category_name"></span>
                        </div>
                        <div>
                            <label for="amount" class="w-32 text-left pr-2 mt-4">Amount:</label>
                            <span id="amount"></span>
                        </div>
                        <div>
                            <label for="datetime" class="w-32 text-left pr-2 mt-4">Date:</label>
                            <span id="datetime"></span>
                        </div>
                        <div>
                            <label for="description" class="w-32 text-left pr-2 mt-4">Description:</label>
                            <span id="description"></span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
