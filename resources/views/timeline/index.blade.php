<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Timeline
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto px-4">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Create Post Button --}}
            <div class="flex justify-end mb-6">
                <a href="{{ route('posts.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow">
                    + Create Post
                </a>
            </div>

            {{-- Posts --}}
            @forelse($posts as $post)
                <div class="bg-white rounded-xl shadow p-5 mb-6">

                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <a href="{{ route('users.show', $post->user_id) }}"
                               class="font-semibold text-gray-800 hover:text-blue-600">
                                {{ $post->user->name }}
                            </a>
                            <p class="text-xs text-gray-500">
                                {{ $post->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    {{-- Content --}}
                    <p class="text-gray-700 mb-3">
                        {{ $post->content }}
                    </p>

                    {{-- Image --}}
                    @if($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}"
                             class="rounded-lg mb-3 w-full max-h-96 object-cover">
                    @endif

                    {{-- Actions --}}
                    <div class="flex items-center gap-6 text-sm text-gray-600 mb-4">
                        @auth
                        <form action="{{ route('posts.like', $post) }}" method="POST">
                            @csrf
                            <button class="flex items-center gap-1 hover:text-red-500">
                                @if($post->isLikedBy(auth()->user()))
                                    ❤️ <span>Unlike</span>
                                @else
                                    🤍 <span>Like</span>
                                @endif
                            </button>
                        </form>
                        @endauth

                        <span>👍 {{ $post->likes()->count() }}</span>
                    </div>

                    {{-- Comments --}}
                    <div class="space-y-3 mb-4">
                        @foreach($post->comments as $comment)
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="flex justify-between text-sm">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <span class="text-gray-400 text-xs">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-gray-700 text-sm mt-1">
                                    {{ $comment->body }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Add Comment --}}
                    @auth
                    <form action="{{ route('posts.comments.store', $post) }}" method="POST">
                        @csrf
                        <textarea name="body"
                                  rows="2"
                                  placeholder="Write a comment..."
                                  class="w-full border rounded-lg p-2 text-sm mb-2 focus:ring focus:ring-blue-200"></textarea>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                            Comment
                        </button>
                    </form>
                    @endauth

                    {{-- Delete --}}
                    @if(auth()->check() && auth()->id() === $post->user->id)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 text-sm">
                                Delete Post
                            </button>
                        </form>
                    @endif

                </div>
            @empty
                <div class="text-center text-gray-500">
                    Your timeline is empty. Follow users to see posts.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>