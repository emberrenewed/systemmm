@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
    <h1 class="text-2xl font-bold">Tickets</h1>
    <p id="realtime-status" class="text-sm text-gray-600 mt-2">Connecting realtime...</p>

    <form method="GET" action="{{ route('tickets.index') }}" class="my-6">
        <label for="status">Status</label>

        <select id="status" name="status" class="border p-2 mr-4">
            <option value="">All statuses</option>

            @foreach (['open', 'in_progress', 'resolved', 'closed'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>

        <label for="priority">Priority</label>

        <select id="priority" name="priority" class="border p-2 mr-4">
            <option value="">All priorities</option>

            @foreach (['low', 'medium', 'high'] as $priority)
                <option value="{{ $priority }}" @selected(request('priority') === $priority)>
                    {{ $priority }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-black text-white p-2">
            Filter
        </button>

        <a href="{{ route('tickets.index') }}" class="border p-2">
            Reset
        </a>
    </form>

    <table class="w-full border-collapse">
        <thead>
            <tr class="border">
                <th class="border p-2">ID</th>
                <th class="border p-2">Subject</th>
                <th class="border p-2">User</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Priority</th>
                <th class="border p-2">Created</th>
                <th class="border p-2">Action</th>
            </tr>
        </thead>

        <tbody id="tickets-tbody">
            @forelse ($tickets as $ticket)
                <tr data-ticket-id="{{ $ticket->id }}">
                    <td class="border p-2">{{ $ticket->id }}</td>
                    <td class="border p-2">{{ $ticket->subject }}</td>
                    <td class="border p-2">{{ $ticket->user->name }}</td>
                    <td class="border p-2">{{ $ticket->status ?? 'Not set' }}</td>
                    <td class="border p-2">{{ $ticket->priority ?? 'Not set' }}</td>
                    <td class="border p-2">{{ $ticket->created_at->diffForHumans() }}</td>
                    <td class="border p-2">
                        <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600">View</a>
                    </td>
                </tr>
            @empty
                <tr id="tickets-empty-row">
                    <td colspan="7" class="border p-4 text-center">
                        No tickets found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

@push('scripts')
    @vite('resources/js/pages/admin/tickets-index.js')
@endpush
