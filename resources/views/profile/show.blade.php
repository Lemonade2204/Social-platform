<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-avatar.png') }}" alt="Profile Image" class="w-32 h-32 rounded-full mb-4">
                    <h1 class="text-2xl font-bold mb-4">
                        {{ $user->name }}'s Profile
                    </h1>

                    <div class="mb-6">
                        <p class="text-gray-600">
                            Joined on {{ $user->created_at->format('M d, Y') }}
                        </p>
                    </div>

                    <section class="mb-10">
                        <h2 class="text-xl- font-semibold mb-2">About me</h2>
                        <div class="prose max-w-none">
                            {{ $user->about?: "a Mysterious one" }}
                        </div>
                    </section>

                    <h2 class="text-xl font-bold mb-2">Posts by {{ $user->name }}</h2>
                    <ul>
                    @foreach ($posts as $post)
                    
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
                       
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
