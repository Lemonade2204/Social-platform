<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">  
                        <h1>All Posts</h1>
                        @if (session('success'))
                            <div>
                                {{ session('success') }}
                            </div>
                        @endif

                        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>

                        <ul>
                            @foreach ($posts as $post)
                                <li>
                                <strong>{{ $post->user->name }}:</strong> {{ $post->content }}
                                @if(auth()->check() && auth()->id() === $post->user_id)
                                  <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit">Delete</button>
                                  </form>
                                @endif
                                </li>
                                
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
