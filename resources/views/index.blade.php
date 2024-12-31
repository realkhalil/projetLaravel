@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Posts</h1>

    <!-- Flash Messages (if any) -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Loop through Posts -->
    @foreach ($posts as $post)
        <div class="card mb-4">
            <div class="card-header">
                <strong>{{ $post->user->name }}</strong>
                <span class="text-muted"> - {{ $post->created_at->diffForHumans() }}</span>
            </div>
            <div class="card-body">
                <p>{{ $post->content }}</p>
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mt-3" alt="Post Image">
                @endif
            </div>
            <div class="card-footer">
                <!-- Like Button -->
                <form action="{{ route('likes.store') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <button type="submit" class="btn btn-sm btn-primary">
                        👍 Like ({{ $post->likes->count() }})
                    </button>
                </form>

                <!-- Comment Button -->
                <button class="btn btn-sm btn-secondary" data-bs-toggle="collapse" data-bs-target="#comments-{{ $post->id }}">
                    💬 Comments ({{ $post->comments->count() }})
                </button>
            </div>

            <!-- Comments Section -->
            <div class="collapse mt-3" id="comments-{{ $post->id }}">
                <div class="px-3">
                    <!-- Display Comments -->
                    @foreach ($post->comments as $comment)
                        <div class="mb-2">
                            <strong>{{ $comment->user->name }}</strong>:
                            <span>{{ $comment->content }}</span>
                            <span class="text-muted small"> - {{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach

                    <!-- Add New Comment -->
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="input-group mt-2">
                            <input type="text" name="content" class="form-control" placeholder="Add a comment..." required>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection
