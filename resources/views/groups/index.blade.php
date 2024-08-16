<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}
    <script src="{{ asset('js/group-participant.js') }}"></script>
</head>
<x-app-layout>
    <main class="flex">
        <aside class="fixed left-0 z-40 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar"
            style="border-right: 2px solid white; width: 20%; height:100vh; margin-top: 65px;">
            <div class="h-full px-3 py-4 overflow-y-auto" style="background-color: #92C3E3">
                <ul class="space-y-2 font-medium">
                    <li>
                        <div class="flex items-center p-2 text-gray-900 rounded-lg dark:text-black mx-auto">
                            <span href="{{ route('groups.index') }}" class="mx-auto" style="font-size:24px;"><b>Expense
                                    Sharing</b></span>
                        </div>
                    </li>
                    <div class="flex justify-center" style="text-align: center">
                        <button class="justify-center rounded text-white"
                            style="background: #4D96EB; width: 175px; height: 30px" data-bs-toggle="modal"
                            data-bs-target="#inviteUserModal">
                            <i class="far fa-plus-square mr-1" style="color: #ffffff;"></i>
                            <span>Add Participant</span>
                        </button>
                    </div>
                </ul>
            </div>
        </aside>
        <div class="p-4 sm:ml-64 items-center justify-center" style="width: 80%; margin-left:20%; margin-top: 70px;">
            <div class="p-4 pt-2" style="width:70%">
                <h2 style="font-weight: bold; font-size:20px; margin-bottom: 10px">{{ $group->name }}'s Group</h2>
                <div class="flex items-center mb-2">
                    <h4 style="font-weight: bold; ">{{ $group->members->count() }}/10 Participants
                    </h4>
                    <button class="ml-5 rounded-md bg-red-300 p-2 flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#leaveGroupModal">
                        <span for="leave group">Leave Group</span>
                        <i class="fa-solid fa-arrow-right-from-bracket text-red-500 ml-2"></i>
                    </button>

                </div>

                @foreach ($members as $member)
                    <div class="rounded-md bg-white mb-3">
                        <div class="grid grid-cols-4 items-center rounded-md px-5 hover:bg-gray-100"
                            style="height: 50px">
                            <div class="col-start-1 col-end-2" id="username">
                                {{ $member->name }}
                            </div>
                            <div class="col-start-2 col-end-3" style="font-size: 14px; color:gray" id="role">
                                {{-- {{ $member->roles->pluck('name')->implode(', ') }} --}}
                            </div>
                            <div class="col-start-5 col-end-5">

                                <button class="editMemberBtn mr-4" data-member="{{ $member->id }}"
                                    data-group="{{ $activeGroupId }}" data-bs-toggle="modal"
                                    data-bs-target="#editParticipantModal">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="deleteMemberBtn"
                                    onclick="showDeleteModal({{ $group->id, $member->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @include('groups.edit')
    </main>
</x-app-layout>

{{-- invite participant modal --}}
<div id="inviteUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="inviteUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!--Modal Content-->
        <div class="modal-content relative p-4 text-center rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex items-center justify-between">
                <h2 class="modal-title" style="font-weight: bold; font-size:20px">Send Invitation</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="modal-body">
                <!-- Group invite form -->
                <form action="{{ route('groups.send-invitation', ['groupId' => $group->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3 text-left">
                        <label for="email" class="mb-2">Enter Participant's Email</label><br>
                        <input type="email" name="email" class="rounded-md border-0 w-full"
                            style="height: 35px; padding:0px 10px;" placeholder="e.g. user@email.com" required>
                    </div>
                    <div class="flex mt-6 justify-center text-white">
                        <button type="submit"
                            style="background: #4deb67; width:175px; height:30px; border:0px solid; border-radius: 5px; font-weight:bold">Send
                            Invitation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content relative p-4 rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex justify-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body flex flex-col items-center">
                Are you sure you want to remove this participant?
            </div>
            <div class="flex justify-center items-center space-x-4">

                <form id="deleteForm" method="POST"
                    action="{{ route('groups.delete', ['group' => $group->id, 'user' => $member->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width: 120px"
                        class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 mt-4">Yes</button>
                </form>

                <button type="button" style="width: 120px"
                    class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-900 focus:z-10"
                    data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

{{-- Leave Group Modal --}}
<div class="modal fade" id="leaveGroupModal" tabindex="-1" role="dialog" aria-labelledby="leaveGroupModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content relative p-4 rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex justify-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body flex flex-col items-center">
                Are you sure you want to leave this group?
            </div>
            <div class="flex justify-center items-center space-x-4">

                <form action="{{ route('groups.leaveGroup', ['group' => $group->id, 'user' => Auth::id()]) }}"
                    method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width: 120px"
                        class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 mt-4">Yes</button>
                </form>
                <button type="button" style="width: 120px"
                    class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-900 focus:z-10"
                    data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
