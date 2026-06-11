@extends('layouts.admin')
@section('title', 'Gallery Management')

@push('styles')
<style>
    .sortable-ghost { opacity: .4; }
    .drag-handle { cursor: grab; }
    .drag-handle:active { cursor: grabbing; }
</style>
@endpush

@section('content')
<div class="flex items-start gap-6">
    {{-- Upload panel --}}
    <div class="w-72 flex-shrink-0">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h2 class="font-semibold text-gray-900 text-sm mb-4">Upload images</h2>
            <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" id="upload-form">
                @csrf
                <div id="drop-zone"
                     class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-forest-400 hover:bg-forest-50 transition-colors mb-4"
                     onclick="document.getElementById('file-input').click()">
                    <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-xs text-gray-400">Click to upload<br>JPG, PNG, WebP · Max 8MB each</p>
                </div>
                <input type="file" name="images[]" id="file-input" multiple accept="image/*" class="hidden">
                <div id="file-preview" class="grid grid-cols-3 gap-1.5 mb-4 hidden"></div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Category</label>
                        <select name="category" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                            @foreach(['general','dorms','activities','facilities','outdoor'] as $cat)
                            <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Caption (optional)</label>
                        <input type="text" name="caption" placeholder="e.g. Main dormitory"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                    </div>
                </div>

                <button type="submit" id="upload-btn" disabled
                        class="w-full mt-4 bg-forest-600 hover:bg-forest-700 disabled:opacity-40 disabled:cursor-not-allowed text-white font-medium py-2 rounded-full text-sm transition-colors">
                    Upload Images
                </button>
            </form>
        </div>
        <p class="text-xs text-gray-400 mt-3 px-1">Drag images in the gallery to reorder. Changes save automatically.</p>
    </div>

    {{-- Gallery grid --}}
    <div class="flex-1">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-gray-900 text-sm">{{ $images->count() }} images</h2>
            <div id="save-indicator" class="text-xs text-gray-400 hidden">Saving order...</div>
        </div>

        @if($images->isEmpty())
        <div class="bg-white rounded-xl border border-gray-100 p-16 text-center text-gray-400">
            No images yet. Upload your first photo.
        </div>
        @else
        <div id="gallery-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($images as $image)
            <div class="gallery-card group bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm relative" data-id="{{ $image->id }}">
                <div class="drag-handle aspect-square bg-gray-100 overflow-hidden">
                    <img src="{{ $image->thumb_url }}" alt="{{ $image->caption }}" class="w-full h-full object-cover" loading="lazy">
                </div>

                {{-- Overlay on hover --}}
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors rounded-xl flex flex-col items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                    <button onclick="openEdit({{ $image->id }}, '{{ e($image->caption) }}', '{{ $image->category }}', {{ $image->is_visible ? 'true' : 'false' }})"
                            class="bg-white text-gray-800 text-xs font-medium px-3 py-1.5 rounded-full hover:bg-gray-100">
                        Edit
                    </button>
                    <form method="POST" action="{{ route('admin.gallery.destroy', $image) }}" class="inline"
                          onsubmit="return confirm('Delete this image?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white text-xs font-medium px-3 py-1.5 rounded-full hover:bg-red-600">
                            Delete
                        </button>
                    </form>
                </div>

                {{-- Caption --}}
                <div class="px-2.5 py-2">
                    <div class="text-xs text-gray-600 truncate">{{ $image->caption ?: '—' }}</div>
                    <div class="flex items-center justify-between mt-0.5">
                        <span class="text-xs text-gray-400">{{ $image->category }}</span>
                        @unless($image->is_visible)
                        <span class="text-xs text-red-400">Hidden</span>
                        @endunless
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- Edit modal --}}
<div id="edit-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
        <h3 class="font-semibold text-gray-900 mb-4">Edit image</h3>
        <form id="edit-form" method="POST" class="space-y-4">
            @csrf @method('PATCH')
            <div>
                <label class="block text-sm text-gray-600 mb-1.5">Caption</label>
                <input type="text" name="caption" id="edit-caption" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1.5">Category</label>
                <select name="category" id="edit-category" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                    @foreach(['general','dorms','activities','facilities','outdoor'] as $cat)
                    <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_visible" id="edit-visible" value="1" class="rounded">
                <span class="text-sm text-gray-700">Visible on public gallery</span>
            </label>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-forest-600 hover:bg-forest-700 text-white font-medium py-2 rounded-full text-sm">Save</button>
                <button type="button" onclick="closeEdit()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 rounded-full text-sm">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
// File preview
document.getElementById('file-input').addEventListener('change', function() {
    const preview = document.getElementById('file-preview');
    const btn = document.getElementById('upload-btn');
    preview.innerHTML = '';
    if (this.files.length > 0) {
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full aspect-square object-cover rounded-lg';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
        preview.classList.remove('hidden');
        btn.disabled = false;
    }
});

// Drag-and-drop to upload zone
const dropZone = document.getElementById('drop-zone');
dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-forest-500'); });
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-forest-500'));
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('border-forest-500');
    const input = document.getElementById('file-input');
    input.files = e.dataTransfer.files;
    input.dispatchEvent(new Event('change'));
});

// Sortable reorder
const grid = document.getElementById('gallery-grid');
if (grid) {
    Sortable.create(grid, {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'sortable-ghost',
        onEnd: async function() {
            const indicator = document.getElementById('save-indicator');
            indicator.classList.remove('hidden');
            const order = Array.from(grid.querySelectorAll('.gallery-card')).map(c => c.dataset.id);
            await fetch('{{ route("admin.gallery.reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                },
                body: JSON.stringify({ order }),
            });
            indicator.textContent = 'Saved ✓';
            setTimeout(() => indicator.classList.add('hidden'), 2000);
        }
    });
}

// Edit modal
function openEdit(id, caption, category, visible) {
    document.getElementById('edit-form').action = `/admin/gallery/${id}`;
    document.getElementById('edit-caption').value = caption;
    document.getElementById('edit-category').value = category;
    document.getElementById('edit-visible').checked = visible;
    document.getElementById('edit-modal').classList.remove('hidden');
}
function closeEdit() {
    document.getElementById('edit-modal').classList.add('hidden');
}
document.getElementById('edit-modal').addEventListener('click', function(e) {
    if (e.target === this) closeEdit();
});
</script>
@endpush
