@extends('layouts.app')

@section('title', 'Replies')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">All Replies</h1>

    <div class="bg-white rounded-lg shadow divide-y divide-gray-100">
        @forelse ($replies as $reply)
            <div class="p-4">
                <p class="text-sm text-gray-500">
                    {{ $reply->user->name }}
                    ·
                    <a href="{{ route('tickets.show', $reply->ticket) }}" class="text-blue-600 hover:underline">
                        {{ $reply->ticket->subject }}
                    </a>
                    · {{ $reply->created_at->diffForHumans() }}
                </p>
                <p class="mt-2 text-gray-800">{{ $reply->message }}</p>
                @if ($reply->image)
                    <div class="mt-3">
                        <img src="{{ $reply->imageUrl() }}" alt="Reply image" class="max-w-sm border">
                    </div>
                @endif
            </div>
        @empty
            <p class="p-6 text-center text-gray-500">No replies yet.</p>
        @endforelse
    </div>
@endsection
