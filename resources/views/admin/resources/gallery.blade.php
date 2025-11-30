@extends('admin.layout')

@section('title', 'Gallery - Resources')
@section('page-title', 'Gallery')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Gallery Images</h2>
        <p class="text-sm text-gray-600">Click on any image to view it in full size</p>
    </div>

    @if($galleries->count() > 0)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($galleries as $gallery)
                    <div class="group relative cursor-pointer overflow-hidden rounded-lg border border-gray-200 hover:border-purple-500 transition-all duration-300 hover:shadow-lg">
                        <img 
                            src="{{ asset('storage/' . $gallery->image_path) }}" 
                            alt="{{ $gallery->title ?? 'Gallery Image' }}" 
                            class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110"
                            onclick="openImageModal('{{ asset('storage/' . $gallery->image_path) }}', '{{ $gallery->title ?? 'Untitled' }}', '{{ $gallery->description ?? '' }}')"
                        >
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                            </svg>
                        </div>
                        @if($gallery->title)
                            <div class="p-2 bg-white">
                                <p class="text-xs text-gray-700 truncate" title="{{ $gallery->title }}">{{ $gallery->title }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $galleries->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No images found</h3>
            <p class="text-sm text-gray-500">There are no images in the gallery yet.</p>
        </div>
    @endif
</div>

<!-- Image Modal for Zoom -->
<div id="imageModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-90" onclick="closeImageModal()">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative max-w-7xl w-full" onclick="event.stopPropagation()">
            <!-- Close Button -->
            <button onclick="closeImageModal()" class="absolute top-4 right-4 z-10 text-white hover:text-gray-300 transition-colors bg-black bg-opacity-50 rounded-full p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <!-- Image Container -->
            <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
                <div class="p-4 bg-gray-50 border-b border-gray-200">
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-900"></h3>
                    <p id="modalDescription" class="text-sm text-gray-600 mt-1"></p>
                </div>
                <div class="flex items-center justify-center bg-black p-4">
                    <img id="modalImage" src="" alt="" class="max-w-full max-h-[80vh] object-contain">
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    #imageModal {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    #imageModal.hidden {
        display: none;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    #modalImage {
        animation: zoomIn 0.3s ease-in-out;
    }
    
    @keyframes zoomIn {
        from {
            transform: scale(0.9);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function openImageModal(imageSrc, title, description) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const modalDescription = document.getElementById('modalDescription');
        
        modalImage.src = imageSrc;
        modalImage.alt = title;
        modalTitle.textContent = title;
        modalDescription.textContent = description || '';
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }
    
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.style.overflow = ''; // Restore scrolling
    }
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageModal();
        }
    });
    
    // Close modal when clicking outside the image
    document.getElementById('imageModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeImageModal();
        }
    });
</script>
@endpush
@endsection

