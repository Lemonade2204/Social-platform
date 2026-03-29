
<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <h1>Your Timeline</h1>
                        @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">{{session('success')}}</div>
                        @endif
                        <div class="flex justify-end mb-4">
                        <a class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"  href="{{ route('posts.create')}}">Create a new Post</a>
                    </div>
                        <ul>
                            @forelse($posts as $post)
                            <div class="bg-white shadow-md rounded p-4 mb-4">
                                
                                <div class="flex items-center justify-between mb-2">
                                        <h2 class="font-bold">
                                            <a href="{{route('users.show', $post->user_id)}}" class="text-blue-600 hover:underline">{{$post->user->name}}</a>
                                            </h2>
                                        <small class="text-gray-500">{{$post->created_at->diffForHumans() }}</small>
                                </div>
                                        <p class="mb-2"> {{$post->content}}</p>

                                        @if($post->image_path)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $post->image_path)}}" alt="" class="w-1/2 h-auto rounded">
                                            </div>
                                        @endif

                                        <div class="flex items-center gap-4 mb-2">
                                            <form action="{{route('posts.like', $post)}}" method="POST">
                                                @csrf
                                                <button type="submit" class="flex items-center gap-1">
                                                    @auth
                                                    @if($post->isLikedBy(auth()->user()))
                                                    <svg class="w-5 h-5 fill-red-600"><use xlink:href="#icon-heart"/></svg>
                                                    <span class="text-red-600"> Unlike</span>
                                                    @else
                                                    <svg class="w-5 h-5 fill-none stroke-gray-600"><use xlink:href="#icon-heart"/></svg>
                                                    <span class="text-red-600"> like</span>
                                                    @endif
                                                </button>
                                                @endauth
                                            </form>
                                            <span class="text-gray-600">{{$post->likes()->count()}} likes</span>
                                        </div>
                                        <div class="space-y-2 mb-4">
                                            @foreach($post->comments as $comment)
                                                <div class="border-l-4 border-blue-200 pl-2">
                                                    <strong>{{$comment->user->name}}</strong>
                                                    <small class="text-gray-500">{{$comment->created_at->diffForHumans()}}</small>
                                                    <p>{{$comment->body}}</p>
                                                </div>
                                            @endforeach
                                        </div>

                                        @auth
                                            <form action="{{route('posts.comments.store', $post)}}" method="POST">
                                                @csrf
                                                <textarea name="body"  rows="2" placeholder="add a comment..." class="w-full border rounded p-2 mb-2"></textarea>
                                                <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                    Comment
                                                </button>
                                            </form>
                                            @endauth

                                        @if(auth()->check() && auth()->id() === $post->user->id)
                                        <form action="{{route('posts.destroy', $post)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded" type="submit">Delete Post</button>
                                        </form>
                                        @endif
                                    

                                
                            </div>
                            @empty
                            <li class="text-gray-600">
                                Your timeline is empty , follow some users!
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
