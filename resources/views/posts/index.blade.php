<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            All Posts
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

            {{-- Create Button --}}
            <div class="flex justify-end mb-6">
                <a href="{{ route('posts.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow font-medium">
                    + Create Post
                </a>
            </div>

            {{-- Posts --}}
            @forelse($posts as $post)
                <div class="bg-white rounded-xl shadow-md p-5 mb-6">

                    {{-- Header (Avatar + Name + Time) --}}
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">

                            {{-- Profile Image --}}
                            <a href="{{ $post->user ? route('users.show', $post->user) : '#' }}">
                                <img 
                                    src="{{ $post->user && $post->user->profile_image 
                                        ? asset('storage/' . $post->user->profile_image) 
                                        : asset('images/default-avatar.png') }}"
                                    alt="Profile"
                                    class="w-10 h-10 rounded-full object-cover border shadow-sm hover:opacity-80 transition"
                                >
                            </a>

                            {{-- Name + Time --}}
                            <div>
                                @if($post->user)
                                    <a href="{{ route('users.show', $post->user) }}"
                                       class="font-semibold text-gray-800 hover:text-blue-600">
                                        {{ $post->user->name }}
                                    </a>
                                @else
                                    <span class="text-gray-500">Unknown User</span>
                                @endif

                                <p class="text-xs text-gray-400">
                                    {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <p class="text-gray-700 mb-3">
                        {{ $post->content }}
                    </p>

                    {{-- Image --}}
                    @if($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}"
                             class="w-full max-h-96 object-cover rounded-lg mb-3">
                    @endif

                    {{-- Actions --}}
                    <div class="flex items-center justify-between text-sm text-gray-600 border-t pt-3 mt-3">

                        <div class="flex items-center gap-5">
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

                        {{-- Delete Button --}}
                        @if(auth()->check() && auth()->id() === optional($post->user)->id)
                            <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-sm">
                                    Delete
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Comments --}}
                    <div class="mt-4 space-y-3">
                        @foreach($post->comments as $comment)
                            <div class="flex items-start gap-3 bg-gray-50 p-3 rounded-lg">

                                {{-- Comment Avatar --}}
                                <img 
                                    src="{{ $comment->user && $comment->user->profile_image 
                                        ? asset('storage/' . $comment->user->profile_image) 
                                        : asset('images/default-avatar.png') }}"
                                    class="w-8 h-8 rounded-full object-cover"
                                >

                                <div class="flex-1">
                                    <div class="flex justify-between text-xs text-gray-500">
                                        <span class="font-semibold text-gray-700">
                                            {{ $comment->user->name ?? 'Unknown' }}
                                        </span>
                                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>

                                    <p class="text-sm text-gray-700 mt-1">
                                        {{ $comment->body }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Add Comment --}}
                    @auth
                        <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="mt-3">
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

                </div>
            @empty
                <div class="text-center text-gray-500">
                    No posts available.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>