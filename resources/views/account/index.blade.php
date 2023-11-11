<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="{{ asset('js/modal.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/modal.css') }}">
</head>

<x-app-layout>
    <main class="flex">
        <aside class="fixed left-0 z-40 transition-transform -translate-x-full sm:translate-x-0"
            aria-label="Sidebar" style="border-right: 2px solid white; width: 20%; height:100vh; margin-top: 65px;">
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
                            style="background: #4D96EB; width: 125px; height: 26px" data-toggle="modal"
                            data-target="#createAccountModal" >
                            <i class="far fa-plus-square mr-1" style="color: #ffffff;"></i>
                            <span>Add</span>
                        </button>
                    </div>
                </ul>
            </div>
        </aside>
        <div class="flex-1 p-4 sm:ml-64 " style="width: 80%; margin-left:20%; margin-top: 65px;">
            @if ($accounts && count($accounts) > 0)
                <div class="mt-1 p-4 ml-14" id="accountIndexContainer" style="width:1000px">
                    @foreach ($accounts as $account)
                        <div class="card rounded-md bg-white">
                            <div class="flex mb-4 data-row">
                                <div class="w-1/5 h-12 ml-4 flex items-center">
                                    {{ $account->name }}
                                </div>
                                <div class="w-2/5 h-12 flex items-center" style="font-size: 14px; color:gray">
                                    {{ $account->type }}
                                </div>
                                <div class="w-1/5 h-12 flex items-center">
                                    RM 0.00
                                </div>
                                <div class="w-1/5 flex justify-end mr-4">
                                    <button class="editAccountBtn mr-4" value="{{ $account->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="deleteAccountBtn"
                                        onclick="showDeleteModal({{ $account->id }})">
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
        <div class="modal-content-s relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
            <div class="modal-header flex justify-end">
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body flex flex-col items-center">
                Are you sure you want to delete this account?
            </div>
            <div class="flex justify-center items-center space-x-4">
                @if(isset($account))
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
                    data-dismiss="modal">Cancel</button>
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
