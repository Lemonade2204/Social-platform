<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">
                        {{ $user->name }}'s Profile
                    </h1>

                    <div class="mb-6">
                        <p class="text-gray-600">
                            Joined on {{ $user->created_at->format('M d, Y') }}
                        </p>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Posts by {{ $user->name }}</h2>
                    <ul>
                    @foreach ($posts as $post)
                    
                        <div class="bg-white shadow-md rounded p-4 mb-4">
                            
                            <div class="flex items-center justify-between mb-2">
                                <h2 class="font-bold">
                                    <a href="{{ route('users.show', $post->user_id) }}" class="text-blue-600 hover:underline">{{ $user->name }}</a>
                                        </h2>   
                                <small class="text-gray-500">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <p class="mb-2">{{$post->content }}</p>

                        @if($post->image_path)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="max-w-full h-auto rounded mb-2">
                            </div>
                        @endif
                        @if(auth()->check() && auth()->id() === $post->user_id)
                            <form action="{{ route('posts.destroy', $post) }}" class="inline-block" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded" type="submit">Delete</button>
                            </form>
                        @endif
                       
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
