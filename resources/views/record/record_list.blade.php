<div class="grid px-5 bg-white rounded-md border border-bottom">
    <div class="text-right mr-5 totalBalance">Total: <b>{{ $totalBalance < 0 ? '-' : '' }}RM
            {{ number_format(abs($totalBalance), 2) }}</b></div>
</div>
@foreach ($records as $record)
    <div class="grid grid-cols-9 px-5 bg-gray-200 items-center record-list mt-1 rounded-md hover:bg-gray-100">
        <div class="col-start-1 col-end-1 category_name"><strong>{{ $record->category->name }}</strong></div>
        <div class="col-start-2 col-end-4 datetime text-center">
            {{ Carbon\Carbon::parse($record->datetime)->format('d/m/Y h:i A') }}</div>
        @php
            $userSessionType = session('user_session_type', 'personal');
        @endphp
        @if ($userSessionType == 'personal')
            <div class="col-start-4 col-end-4 account_name">{{ $record->account->name }}</div>
            <div class="col-start-5 col-end-8 description">{{ $record->description }}</div>
        @else
            <div class="col-start-4 col-end-8 description">{{ $record->description }}</div>
        @endif
        <div class="col-start-8 col-end-8 username">{{ $record->user->name }}</div>
        <div class="text-right dropdown-container col-start-9 col-end-9" tabindex="-1">
            @if ($record->type === 'Expense')
                <span class="amount" style="color: rgb(250, 56, 56);"><strong>-RM
                        {{ $record->amount }}</strong></span>
            @else
                <span class="amount" style="color: rgb(90, 216, 90);"><strong>RM
                        {{ $record->amount }}</strong></span>
            @endif
            <i class="fa-solid fa-ellipsis-vertical ml-3 menu focus-ring"></i>
            <div class="dropdown shadow">
                <button class="viewRecordBtn" value="{{ $record->id }}">View</button>
                <button class="editRecordBtn" value="{{ $record->id }}">Edit</button>
                <button class="deleteRecordBtn" onclick="recordDeleteModal({{ $record->id }})">Delete</button>
            </div>
        </div>
    </div>
@endforeach
<div class="mt-2 flex justify-center">{{ $records->appends(request()->query())->links() }}</div>
