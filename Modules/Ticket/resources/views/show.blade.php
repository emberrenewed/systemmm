@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->id)

@section('content')
    <a href="{{ route('tickets.index') }}">← Back to tickets</a>
    <h1 class="text-2xl font-bold">{{ $ticket->subject }}</h1>

    <p>
        By {{ $ticket->user->name }} · {{ $ticket->created_at->format('Y-m-d H:i') }}
        · Status:
        <strong>{{ $ticket->status ?: 'not set' }}</strong>
    </p>

    <p class="mt-4">{{ $ticket->description }}</p>

    <hr class="my-6">

    <h2 class="text-xl font-bold">Update ticket</h2>

    <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="mt-4">
        @csrf
        @method('PATCH')

        <label for="status">Status</label>
        <select id="status" name="status" class="border p-2 mr-4">
            <option value="">Not set</option>

            @foreach (['open', 'in_progress', 'resolved', 'closed'] as $status)
                <option value="{{ $status }}" @selected($ticket->status === $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>

        <label for="priority">Priority</label>
        <select id="priority" name="priority" class="border p-2 mr-4">
            <option value="">Not set</option>

            @foreach (['low', 'medium', 'high'] as $priority)
                <option value="{{ $priority }}" @selected($ticket->priority === $priority)>
                    {{ $priority }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="bg-black text-white p-2">Update</button>
    </form>
    @error('status')<p class="text-red-600">{{ $message }}</p>@enderror
    @error('priority')<p class="text-red-600">{{ $message }}</p>@enderror

    @if ($ticket->status !== 'closed')
        <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="mt-4"
              onsubmit="return confirm('Close this ticket? Users will not be able to reply anymore.');">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="closed">
            <button type="submit" class="bg-red-600 text-white p-2">Close ticket</button>
        </form>
    @else
        <p class="mt-4 text-red-700 font-semibold">This ticket is closed. No more replies are allowed.</p>
    @endif

    <hr class="my-6">

    <h2 class="text-xl font-bold">Replies</h2>

    @forelse ($ticket->replies as $reply)
        <div class="border p-4 mt-4">
            <p>
                {{ $reply->user->name }}
                @if ($reply->user->is_admin)
                    <strong>(Admin)</strong>
                @endif

                · {{ $reply->created_at->diffForHumans() }}
            </p>

            <p class="mt-2">{{ $reply->message }}</p>

            @if ($reply->image)
                <div class="mt-3">
                    <img src="{{ $reply->imageUrl() }}" alt="Reply image" class="max-w-md border">
                </div>
            @endif
        </div>
    @empty
        <p class="mt-4">No replies yet.</p>
    @endforelse

    @if ($ticket->status !== 'closed')
        <h2 class="text-xl font-bold mt-6">Send a reply</h2>

        <form method="POST" action="{{ route('replies.store', $ticket) }}" class="mt-4" enctype="multipart/form-data">
            @csrf

            <label for="message">Message</label>
            <textarea id="message" name="message" rows="4" class="block w-full border p-2 mt-2">{{ old('message') }}</textarea>
            @error('message') <p class="text-red-600">{{ $message }}</p> @enderror

            <label for="image" class="block mt-4">Image (optional)</label>
            <input id="image" type="file" name="image" accept="image/*" class="block mt-2">
            @error('image') <p class="text-red-600">{{ $message }}</p> @enderror

            <button type="submit" class="bg-black text-white p-2 mt-4">Send reply</button>
        </form>
    @endif
@endsection
