<?php

use App\Services\BlogService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
new class extends Component
{
    use WithPagination;


    public string $search = '';
    public array $pending = [];
    public array $edit = [];
    public string $title = '';
    public string $content = '';

    public function validationAttributes(): array
    {
        $attributes = [
            'title' => 'title',
            'content' => 'content',
        ];

        foreach (array_keys($this->edit['title']?? []) as $id){
            $attributes["edit.title.$id"]='title';
            $attributes["edit.content.$id"]='content';
        }

        return $attributes;
    }


    public function mount(): void
    {
        $this->pending = session('pending_edits', []);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function stageEdit(int $postId): void
    {
        $this->validate([
            "edit.title." . $postId => 'required|string|max:255',
            "edit.content." . $postId=> 'required|string',
        ]);

        try {
            $post = app(BlogService::class)->getBlogById($postId);
            $this->authorize('update', $post);

            $this->pending[$postId] = [
                'id' => $postId,
                'title' => $this->edit['title'][$postId],
                'content' => $this->edit['content'][$postId],
            ];
            session(['pending_edits' => $this->pending]);
            $this->dispatch('close-edit-modal');
            $this->dispatch('notify', message: 'Blog staged', type: 'status');
        } catch (ModelNotFoundException $e) {
            Log::error('stageEdit not found error: ', ['error:' => $e->getMessage()]);
            $this->dispatch('notify', message: 'Staged blog not found', type: 'error');
        } catch (AuthorizationException $e) {
            Log::error('stageEdit unauthorized error: ', ['error:' => $e->getMessage()]);
            session()->flash('error', 'Unauthorized user');
            $this->dispatch('notify', message: 'Unauthorized user', type: 'error');
            $this->redirect(route('blog.blogPage'));
        } catch (QueryException $e) {
            Log::error('stageEdit query error: ', ['error:' => $e->getMessage()]);
            $this->dispatch('notify', message: 'Something went wrong', type: 'error');
        }
        catch (\RuntimeException $e) {
            Log::error('stageEdit query error: ', ['error:' => $e->getMessage()]);
            $this->dispatch('notify', message: 'Something went wrong', type: 'error');
        }
    }

    public function batchUpdate(): void
    {
        try {
            app(BlogService::class)->batchUpdate();
            $this->pending = [];
            session()->forget('pending_edits');
            $this->dispatch('notify', message: 'Blog post updated', type: 'status');

        } catch (QueryException $e) {
            Log::error('batchUpdate query error: ', ['error:' => $e->getMessage()]);
            $this->dispatch('notify', message: 'Something went wrong', type: 'error');
        } catch (\RuntimeException $e) {
            Log::error('batchUpdate query error: ', ['error:' => $e->getMessage()]);
            $this->dispatch('notify', message: 'Something went wrong', type: 'error');
        }
    }

    public function deleteBlog(int $id):void
    {
        try {
            $post = app(BlogService::class)->getBlogById($id);
            $this->authorize('delete', $post);
            app(BlogService::class)->deleteBlog($post);
            $this->dispatch('notify', message: 'Blog post deleted', type: 'status');

        } catch (ModelNotFoundException $e) {
            Log::error('deleteBlog not found error: ', ['error:' => $e->getMessage()]);
            $this->dispatch('notify', message: 'Blog post not found', type: 'error');
        } catch (AuthorizationException $e) {
            Log::error('deleteBlog unauthorized error: ', ['error:' => $e->getMessage()]);
            $this->dispatch('notify', message: 'Unauthorized user', type: 'error');
            $this->redirect(route('blog.blogPage'));
        } catch (QueryException $e) {
            Log::error('deleteBlog query error: ', ['error:' => $e->getMessage()]);
            $this->dispatch('notify', message: 'Something went wrong', type: 'error');
        }
    }

    public function createBlog():void
    {
        try {
            $this->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);
            $data = [
                'title'=>$this->title,
                'content'=>$this->content,
                'user_id' => Auth::id(),
            ];
            app(BlogService::class)->createBlog($data);
            $this->reset('title', 'content');
            $this->dispatch('close-create-modal');
            $this->dispatch('notify', message: 'Blog created', type: 'status');

        } catch (QueryException $e) {
            Log::error('createBlog query error: ', ['error:' => $e->getMessage()]);
            $this->dispatch('notify', message: 'Something went wrong', type: 'error');
        }
    }

    public function with(): array
    {
        try {
            $posts = app(BlogService::class)->blogSearch($this->search);
        } catch (QueryException $e) {
            Log::error('blog-manage blogSearch error: ', ['error:' => $e->getMessage()]);
            $this->dispatch('notify', message: 'Something went wrong', type: 'error');
            $this->redirect(route('blog.blogPage'));
            $posts = collect();

        }

        foreach ($posts as $post) {
            if (! isset($this->edit['title'][$post->id])) {
                $staged = $this->pending[$post->id] ?? null;
                $this->edit['title'][$post->id] = $staged['title'] ?? $post->title;
                $this->edit['content'][$post->id] = $staged['content'] ?? $post->content;
            }
        }

        return [
            'data' => $posts,
        ];
    }
};
?>

<div>
    <div class="max-w-6xl mx-auto px-6 py-10">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manage Blogs</h1>
                <p class="text-sm text-gray-400 mt-1">Create, edit, and publish blogs.</p>
            </div>
            <button 
                x-on:click="$dispatch('open-create-modal')"
                class="flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-700 transition-colors">
            + New Blog
        </button>
    </div>

    <div class="mb-8">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search blogs..."
            class="w-full px-5 py-3 bg-white border border-gray-100 rounded-xl text-sm text-gray-900 placeholder-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10">
    </div>

    @if ($data->isEmpty())
        <!-- Empty -->
        <div id="empty" class=" text-center py-32">
            <div class="text-5xl mb-4">📭</div>
            <p class="text-gray-400 font-medium mb-4">No blogs yet.</p>
            <button 
                x-on:click="$dispatch('open-create-modal')"
                class="px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-700 transition-colors">
                Create your first post
            </button>
        </div>
    @else
        <!-- Table -->
        <div id="table-wrap" >
            <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50">
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-12">ID</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Content</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider whitespace-nowrap">Created At</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($data as $post)
                            @php
                                $edit = $pending[$post->id] ?? null;
                                $canEdit = $post->user_id === auth()->id();
                            @endphp
                            <tr wire:key="row-{{ $post->id }}" id="row-{{ $post->id }}" class="border-b border-gray-100 hover:bg-gray-50 transition-colors {{ $edit ? 'bg-amber-50' : '' }}">
                                <td class="px-6 py-4 text-sm text-gray-400 w-12">{{$post->id}}</td>
                                <td class="px-6 py-4">
                                    <span id="title-{{ $post->id }}" class="text-sm font-semibold text-gray-900">{{ $edit['title'] ?? $post->title }}</span>
                                    @if ($edit)
                                        <span class="text-[10px] uppercase font-bold text-amber-600 ml-2">pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span id="content-{{ $post->id }}" class="text-sm text-gray-500 line-clamp-2">{{ $edit['content'] ?? $post->content }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-400 whitespace-nowrap">{{ $post->created_at?->format('F j, Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $post->author->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button @if ($canEdit) x-on:click="$dispatch('open-edit-modal',{{ $post->id }})"  @endif
                                            @disabled(! $canEdit)
                                            class="text-xs font-semibold text-gray-900 border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-transparent">
                                            Edit
                                        </button>
                                        <form wire:submit="deleteBlog({{ $post->id }})">
                                            <button type="submit" @disabled(! $canEdit)
                                                class="text-xs font-semibold text-red-600 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-transparent">
                                                Delete
                                            </button>
                                        </form>
                                        <x-modals.modal
                                            wire:key="edit-modal-{{ $post->id }}"
                                            wire:ignore.self
                                            x-data="{ open: false }" x-show="open"
                                            x-on:open-edit-modal.window="if ($event.detail == {{ $post->id }}) open = true"
                                            x-on:close-edit-modal.window="open = false"
                                            id="edit-modal-{{ $post->id }}" title="Edit Post">
                                            <x-modals.edit :post="$post"/>
                                        </x-modals.modal>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <x-pagination :pagination="$data" :disabled="$search !== ''"/>

    <!-- Save Button (fixed bottom right) -->
    <div class="fixed bottom-8 right-8 flex items-center gap-3">
        <button type="button" wire:click="batchUpdate" @if (empty($pending)) disabled @endif
            class="relative flex items-center gap-2 px-6 py-3 bg-gray-900 text-white text-sm font-semibold rounded-xl shadow-lg hover:bg-gray-700 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
            <span>Save Changes</span>
            @if (! empty($pending))
                <span class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ count($pending) }}</span>
            @endif
        </button>
    </div>

    <x-modals.modal 
        wire:ignore.self
        x-data="{open:false}"
        x-show="open"
        x-on:open-create-modal.window="open=true"
        x-on:close-create-modal.window="open=false"
        id="create-modal" 
        title="New Blog" >
        <x-modals.create/>
    </x-modals.modal>

    </div>
</div>
