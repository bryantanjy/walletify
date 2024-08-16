<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}
    <script src="{{ asset('js/expense-sharing.js') }}"></script>
</head>
<x-app-layout>
    <main class="flex">
        <aside class="fixed left-0 z-40 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar"
            style="border-right: 2px solid white; width: 20%; height:100vh; margin-top: 65px;">
            <div class="h-full px-3 py-4 overflow-y-auto" style="background-color: #92C3E3">
                <ul class="space-y-2 font-medium">
                    <li>
                        <div class="flex items-center p-2 text-gray-900 rounded-lg dark:text-black mx-auto">
                            <span class="mx-auto" style="font-size:24px;"><b>Expense
                                    Sharing</b></span>
                        </div>
                    </li>
                    <div class="flex justify-center" style="text-align: center">
                        <button class="justify-center rounded text-white" data-bs-toggle="modal"
                            data-bs-target="#createGroupModal" style="background: #4D96EB; width: 150px; height: 26px">
                            <i class="far fa-plus-square mr-1" style="color: #ffffff;"></i>
                            <span>Create Group</span>
                        </button>
                    </div>
                </ul>
            </div>
        </aside>
        <div class="p-4 sm:ml-64 items-center justify-center" style="width: 80%; margin-left:20%; margin-top: 70px;">
            @if ($groups && count($groups) > 0)
                <div class="p-4" style="width:70%">
                    @foreach ($groups as $group)
                        <div class="rounded-md bg-white mb-3">
                            <div class="grid grid-cols-4 items-center rounded-md px-5 hover:bg-gray-100"
                                style="height: 50px">
                                <div class="col-start-1 col-end-2" id="group_name">
                                    {{ $group->name }}
                                </div>
                                <div class="col-start-2 col-end-3" style="font-size: 14px; color:gray"
                                    id="group_description">
                                    {{ $group->description }}
                                </div>
                                <div class="col-start-5 col-end-5">
                                    <button class="editGroupBtn mr-4" value="{{ $group->id }}"
                                        data-bs-toggle="modal" data-bs-target="#editGroupModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="deleteAccountBtn" onclick="showDeleteModal({{ $group->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center" style="font-size: 20px">No groups created at the moment</p>
            @endif
        </div>
        @include('expense-sharing.create')
        @include('expense-sharing.edit')
    </main>
</x-app-layout>

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
                Are you sure you want to delete this group?
            </div>
            <div class="flex justify-center items-center space-x-4">
                @if (isset($group))
                    <form id="deleteForm" method="POST"
                        action="{{ route('expense-sharing.delete', ['group' => $group->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width: 120px"
                            class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 mt-4">Yes</button>
                    </form>
                @endif
                <button type="button" style="width: 120px"
                    class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-900 focus:z-10"
                    data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@if (count($errors) > 0)
    <script>
        $(document).ready(function() {
            $('#createGroupModal').modal('show');
        });
    </script>
@endif
