<?php

use App\Services\BlogService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $search = '';
    public string $error = '';

    public function with(): array
    {
        try{
            $posts = app(BlogService::class)->blogSearch($this->search);
            $this->error = '';
        } catch (QueryException $e){
            Log::error('blogPage error: ', ['error:' => $e->getMessage()]);
            $this->error='Something went wrong';
            $posts = collect();
        }

        return [
            'posts'=>$posts
        ];
    }
};
?>

<div>
    <div class="mb-8">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search blogs..."
            class="w-full px-5 py-3 bg-white border border-gray-100 rounded-xl text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10">
    </div>
    @if ($posts->isEmpty())
        <div class="text-center py-24">
            <div class="text-5xl mb-4">📭</div>
            <p class="text-gray-400 font-medium">No posts found.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($posts as $post)
                <a href="{{ route('blog.blogDetailPage', $post->title) }}" class="block no-underline">
                    <article class="bg-white border border-gray-100 rounded-2xl p-7 hover:-translate-y-1 hover:shadow-xl transition-all duration-200 cursor-pointer">
                        <div class="flex items-center gap-2.5 mb-4">
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-sm font-bold text-gray-500">
                                {{ strtoupper(substr($post->author->name, 0, 1)) }}
                            </div>
                            <span class="text-xs text-gray-400 font-medium">{{ $post->author->name }} · {{ $post->created_at?->format('F j, Y') }}</span>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900 tracking-tight leading-snug mb-2">
                            {{ $post->title }}
                        </h2>
                        <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">
                            {{ $post->content }}
                        </p>
                        <div class="mt-5 pt-4 border-t border-gray-50 flex justify-end">
                            <span class="text-xs font-semibold text-gray-900 flex items-center gap-1">
                                Read blogs →
                            </span>
                        </div>
                    </article>
                </a>
            @endforeach
        </div>
        <!-- Pagination -->
        <x-pagination :pagination="$posts"/>
    @endif
    @if (session('status') || session('error') || $error)
        <div id="snackbar">{{ session('status') ?? session('error') ?? $error}}</div>
    @endif
</div>
