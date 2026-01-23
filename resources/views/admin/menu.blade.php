<div class="flex w-full gap-2">
    <button type="button" data-id="{{ $row->id }}" data-status="{{ config('constants.status.accepted') }}"
        class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl text-sm px-3 py-1 shadow-sm focus:outline-none focus:ring-2 focus:ring-green-300 transition-all duration-200">
        Accept
    </button>

    <button type="button" data-id="{{ $row->id }}" data-status="{{ config('constants.status.rejected') }}"
        class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl text-sm px-3 py-1 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-200">
        Reject
    </button>
</div>
