<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<x-app-layout>
    <main class="flex">
        <aside class="fixed left-0 z-40 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar"
            style="border-right: 2px solid white; width: 20%; height:100vh; margin-top: 65px;">
            <div class="h-full px-3 py-4 overflow-y-auto" style="background-color: #92C3E3">
                <ul class="space-y-2 font-medium">
                    <li>
                        <div class="flex items-center p-2 text-gray-900 rounded-lg dark:text-black mx-auto">
                            <span href="{{ route('groups.index') }}" class="mx-auto"
                                style="font-size:24px;"><b>Expense Sharing</b></span>
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
            @if (session('success'))
                <div class="position-fixed top-20 end-0 p-3" style="z-index: 100">
                    <div class="toast align-items-center bg-green-100 border-0" role="alert" aria-live="assertive"
                        aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fa-regular fa-circle-check" style="color: #48f745;"></i>
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>
                </div>
            @elseif (session('error'))
                <div class="position-fixed top-20 end-0 p-3" style="z-index: 100">
                    <div class="toast align-items-center bg-red-100 border-0" role="alert" aria-live="assertive"
                        aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fa-solid fa-triangle-exclamation" style="color: #dc0404;"></i>
                                {{ session('error') }}
                            </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-4 pt-2" style="width:70%">
                <h2 style="font-weight: bold; font-size:20px; margin-bottom: 10px">{{ $group->name }}'s Group</h2>
                <h4 style="font-weight: bold; margin-bottom: 10px">{{$group->members->count()}}/10 Participants</h4>
                @foreach ($members as $member)
                    <div class="rounded-md bg-white mb-3">
                        <div class="grid grid-cols-4 items-center rounded-md px-5 hover:bg-gray-100"
                            style="height: 50px">
                            <div class="col-start-1 col-end-2" id="username">
                                {{$member->name}}
                            </div>
                            <div class="col-start-2 col-end-3" style="font-size: 14px; color:gray"
                                id="role">
                                {{-- {{ $member->roles->pluck('name')->implode(', ') }} --}}
                            </div>
                            <div class="col-start-5 col-end-5">
                                <button class="editMemberBtn mr-4" value="{{ $member->id }}" data-bs-toggle="modal"
                                    data-bs-target="#editParticipantModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="deleteMemberBtn" onclick="showDeleteModal({{ $member->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</x-app-layout>

<script>
    // trigger toast @ notification
    $(document).ready(function() {
        $('.toast').toast({
            delay: 5000
        }).toast('show');
    });
</script>

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

{{-- edit participant modal --}}
<div id="editParticipantModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editParticipantModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 row">
                        <label class="col-5 text-left" for="role">Role</label>
                        <select name="role" class="col-5 rounded-md border-0"
                            style="height: 30px; padding:0px 10px; width:50%" required>
                            @foreach ($member->roles as $role)
                                <option value="{{$member->role_id}}">{{-- role name --}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-3">
                        <h4 class="col-3 text-left">Permission</h4>
                        <p class="col-6"></p>
                    </div>
                    <div class="row">
                        <label class="col-5 text-left" for="record">Record</label>
                        <select name="recordPermission" id="recordPermission" class="col-5 mb-2 rounded-md border-0"
                        style="height: 30px; padding:0px 10px; width:50%">
                            <option value="">View details only</option>
                            <option value="">Create only</option>
                            <option value="">Create, View details</option>
                            <option value="">Create, View details & Edit</option>
                            <option value="">Create, View details, Edit & Delete</option>
                        </select>
                    </div>
                    <div class="row">
                        <label class="col-5 text-left" for="budget">Budget</label>
                        <select name="budgetPermission" id="BudgetPermission" class="col-5 mb-2 rounded-md border-0"
                        style="height: 30px; padding:0px 10px; width:50%">
                            <option value="">View details only</option>
                            <option value="">Create only</option>
                            <option value="">Create, View details</option>
                            <option value="">Create, View details & Edit</option>
                            <option value="">Create, View details, Edit & Delete</option>
                        </select>
                    </div>
                    <div class="row">
                        <label class="col-5 text-left" for="member">Participant Details</label>
                        <select name="memberPermission" id="memberPermission" class="col-5 mb-2 rounded-md border-0"
                        style="height: 30px; padding:0px 10px; width:50%">
                            <option value="">Send invite only</option>
                            <option value="">Send invite & Edit participant only</option>
                            <option value="">Send invite, Edit participant & Remove participant</option>
                        </select>
                    </div>
                    <div class="flex mt-6 justify-center">
                        <button type="submit" style="background: #4D96EB; width:100px; height:26px; border:0px solid; border-radius: 5px">Save</button>
                        <button type="button" data-bs-dismiss="modal" style="background: #fff; width:100px; height:26px; border:0px solid; border-radius: 5px">Cancel</button>
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
            <input type="hidden" id="recordId" value="">
            <div class="modal-body flex flex-col items-center">
                Are you sure you want to remove this participant?
            </div>
            <div class="flex justify-center items-center space-x-4">

                <form id="deleteForm" method="POST" action="">
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
