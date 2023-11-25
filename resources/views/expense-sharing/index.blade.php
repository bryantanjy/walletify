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
                            <span href="{{ route('budget.index') }}" class="mx-auto"
                                style="font-size:24px;"><b>Expense Sharing</b></span>
                        </div>
                    </li>
                    <div class="flex justify-center" style="text-align: center">
                        <button class="justify-center rounded text-white"
                            style="background: #4D96EB; width: 125px; height: 26px">
                            <i class="far fa-plus-square mr-1" style="color: #ffffff;"></i>
                            <span>Add</span>
                        </button>
                    </div>
                </ul>
            </div>
        </aside>
        <div class="p-4 sm:ml-64 items-center justify-center" style="width: 80%; margin-left:20%; margin-top: 70px;">
            
        </div>
    </main>
</x-app-layout>
