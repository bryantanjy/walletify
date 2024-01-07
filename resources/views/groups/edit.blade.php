{{-- edit participant modal --}}
<div id="editParticipantModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editParticipantModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <!--Modal Content-->
        <div class="modal-content relative p-4 text-center rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex items-center justify-between">
                <h2 class="modal-title" style="font-weight: bold; font-size:20px">Edit Participant</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="modal-body">
                <!-- Group invite form -->
                <form id="editParticipantForm" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="user_id" id="user_id" value="{{$group->user_id}}">
                    <input type="hidden" name="group_id" id="group_id" value="{{$group->id}}">

                    {{-- role assign --}}
                    <div class="mb-3 row">
                        <label class="col-1 text-left" for="role">Role</label>
                        <select class="col-2 rounded-md border-0" name="role" id="role"
                            style="height: 30px; padding:0px 10px; width:40%" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- permission assign --}}
                    <div class="row mb-3">
                        <h4 class="col-3 text-left">Permission</h4>
                        <p class="col-6"></p>
                    </div>
                    <div class="row mb-3">
                        @foreach ($permissions as $permission)
                            <div class="col-4 text-left">
                                <input class="col-1" type="checkbox" name="permissions[]" id="permission{{ $permission->id }}" value="{{ $permission->id }}">
                                <span class="col-3" style="height: 30px; padding:0px 10px; width:50%; text-transform:capitalize">{{ $permission->name }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- button --}}
                    <div class="flex mt-6 mx-auto" style="width: 30%; justify-content:space-between">
                        <button type="submit"
                            style="background: #4D96EB; width:100px; height:26px; border:0px solid; border-radius: 5px">Save</button>
                        <button type="button" data-bs-dismiss="modal"
                            style="background: #fff; width:100px; height:26px; border:0px solid; border-radius: 5px">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
