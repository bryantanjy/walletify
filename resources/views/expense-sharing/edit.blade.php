<div id="editGroupModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editGroupModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!--Modal Content-->
        <div class="modal-content relative p-4 text-center rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex items-center justify-between">
                <h2 class="modal-title" style="font-weight: bold; font-size:20px">Edit Group</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="modal-body text-left">
                @if (isset($group))
                    <!-- Group edit form -->
                    <form id="editGroupForm" action="{{ route('expense-sharing.update', ['group' => $group->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="flex items-center">
                            <label for="groupName" class="w-40 pr-2 mt-4">Group Name</label>
                            <input type="text" name="name" class="rounded-md border-0"
                                style="height: 30px; padding:0px 10px; margin:15px 0px 0px 20px; width:50%"
                                value="{{ $group->name }}" placeholder="Group name" required>
                        </div>
                        <div class="flex items-center">
                            <label for="groupDescription" class="w-40 pr-2 mt-4">Group Description</label>
                            <textarea type="text" name="description" class="rounded-md flex-grow border-0" placeholder="Group Description" 
                                maxlength="255" style="height: 60px; padding:0px 10px; margin:15px 0px 0px 20px;">{{ $group->description }}</textarea>
                        </div>
                        <input type="hidden" id="id" name="id">

                        <div class="flex mt-6 justify-evenly">
                            <button type="submit"
                                style="background: #4D96EB; width:100px; height:26px; border:0px solid; border-radius: 5px">Save</button>
                            <button type="button" data-bs-dismiss="modal"
                                style="background: #fff; width:100px; height:26px; border:0px solid; border-radius: 5px">Cancel</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
