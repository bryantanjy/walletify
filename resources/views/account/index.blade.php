<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script type="text/javascript" src="{{ asset('js/account.js') }}"></script>
</head>

<x-app-layout>
    <main class="flex">
        <aside class="fixed left-0 z-40 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar"
            style="border-right: 2px solid white; width: 20%; height:100vh; margin-top: 65px;">
            <div class="h-full px-3 py-4 overflow-y-auto" style="background-color: #92C3E3">
                <ul class="space-y-2 font-medium">
                    <li>
                        <div class="flex items-center p-2 text-gray-900 rounded-lg dark:text-black mx-auto">
                            <span href="{{ route('account.index') }}" class="mx-auto"
                                style="font-size:24px; font-weight:bolder">Account</span>
                        </div>
                    </li>
                    <div class="flex justify-center">
                        <button class="justify-center rounded text-white createAccountBtn"
                            style="background: #4D96EB; width: 125px; height: 26px" data-bs-toggle="modal"
                            data-bs-target="#createAccountModal">
                            <i class="far fa-plus-square mr-1" style="color: #ffffff;"></i>
                            <span>Add</span>
                        </button>
                    </div>
                </ul>
            </div>
        </aside>
        <div class="flex-1 p-4 sm:ml-64" style="width: 80%; margin-left:20%; margin-top: 65px;">
            @if ($accounts && count($accounts) > 0)
                <div class="p-4" style="width:70%">
                    @foreach ($accounts as $account)
                        <div class="rounded-md bg-white mb-3">
                            <div class="grid grid-cols-4 items-center rounded-md px-5 hover:bg-gray-100" style="height: 50px">
                                <div class="col-start-1 col-end-2">
                                    {{ $account->name }}
                                </div>
                                <div class="col-start-2 col-end-3" style="font-size: 14px; color:gray">
                                    {{ $account->type }}
                                </div>
                                <div class="col-start-4 col-end-4">
                                    RM {{ $balances[$account->id] }}
                                </div>
                                <div class="col-start-5 col-end-5">
                                    <button class="editAccountBtn mr-4" value="{{ $account->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="deleteAccountBtn" onclick="showDeleteModal({{ $account->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="m-3 flex justify-center" style="font-size: 20px">No accounts found.</p>
            @endif
        </div>
        @include('account.create')
        @include('account.edit')
    </main>
</x-app-layout>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content relative p-4 text-center rounded-lg sm:p-5" style="background-color: #E1F1FA">
            <div class="modal-header flex justify-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body flex flex-col items-center">
                Are you sure you want to delete this account?
            </div>
            <div class="flex justify-center items-center space-x-4">
                @if (isset($account))
                    <form id="deleteForm" method="POST"
                        action="{{ route('account.delete', ['account' => $account->id]) }}">
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

<style>
    .editAccountBtn {
        background-color: transparent;
        border: none;
        cursor: pointer;
    }

    .editAccountBtn i {
        color: black;
        transition: color 0.3s ease;
    }

    .editAccountBtn:hover i {
        color: rgb(62, 244, 62);
    }

    .deleteAccountBtn {
        background-color: transparent;
        border: none;
        cursor: pointer;
    }

    .deleteAccountBtn i {
        color: black;
        transition: color 0.3s ease;
    }

    .deleteAccountBtn:hover i {
        color: red;
    }
</style>
