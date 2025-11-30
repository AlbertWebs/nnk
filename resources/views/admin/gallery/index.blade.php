@extends('admin.layout')

@section('title', 'Gallery')
@section('page-title', 'Gallery Management')

@push('styles')
<style>
    .dropzone {
        border: 2px dashed #cbd5e0;
        border-radius: 0.5rem;
        padding: 3rem;
        text-align: center;
        transition: all 0.3s;
        background-color: #f9fafb;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .dropzone:hover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    .dropzone.dz-drag-hover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    .dropzone .dz-message {
        margin: 0;
        pointer-events: none;
    }
    .dropzone.dz-clickable {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">Upload Images</h2>
    <p class="text-sm text-gray-600 mb-4">Drag and drop images here or click to browse</p>
    
    <!-- Dropzone -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="dropzone" id="gallery-dropzone">
            <div class="dz-message">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <p class="text-lg font-medium text-gray-700 mb-2">Drag & drop images here</p>
                <p class="text-sm text-gray-500">or click to browse files</p>
                <p class="text-xs text-gray-400 mt-2">(Max file size: 10MB per file - JPEG, PNG, JPG, GIF, WEBP)</p>
                <p class="text-xs text-blue-600 mt-1 font-medium">You can select and upload multiple images at once!</p>
            </div>
        </div>
    </div>
</div>

<div class="mb-4 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Gallery Images</h2>
        <p class="text-sm text-gray-600">Manage your gallery images</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($galleries as $gallery)
        <div class="relative group border rounded-lg overflow-hidden">
            <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-48 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                <div class="flex space-x-2">
                    <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Edit</a>
                    <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">Delete</button>
                    </form>
                </div>
            </div>
            @if($gallery->title)
            <div class="p-2 bg-white">
                <p class="text-sm text-gray-700 truncate">{{ $gallery->title }}</p>
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-gray-500">
            No images in gallery yet. <a href="{{ route('admin.gallery.create') }}" class="text-blue-500 hover:underline">Add your first image</a>
        </div>
        @endforelse
    </div>
    <div class="mt-6">
        {{ $galleries->links() }}
    </div>
</div>

@push('scripts')
<script>
    (function() {
        // Disable auto discover immediately
        if (typeof Dropzone !== 'undefined') {
            Dropzone.autoDiscover = false;
        }
        
        function initDropzone() {
            console.log('Attempting to initialize dropzone on gallery page...');
            
            if (typeof Dropzone === 'undefined') {
                console.error('Dropzone library not loaded');
                setTimeout(initDropzone, 100);
                return;
            }
            
            const dropzoneElement = document.getElementById('gallery-dropzone');
            if (!dropzoneElement) {
                console.error('Dropzone element not found');
                return;
            }
            
            // Check if already initialized
            if (dropzoneElement.dropzone) {
                console.log('Dropzone already initialized');
                return;
            }
            
            console.log('Initializing dropzone...');
            
            // Create progress container
            const progressContainer = document.createElement('div');
            progressContainer.id = 'upload-progress-container';
            progressContainer.className = 'mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200 hidden';
            progressContainer.innerHTML = `
                <div class="mb-2 flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Upload Progress</span>
                    <span id="upload-progress-text" class="text-sm text-gray-600">0 / 0</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                    <div id="upload-progress-bar" class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <div id="upload-status" class="text-xs text-gray-500"></div>
            `;
            document.querySelector('.dropzone').parentElement.appendChild(progressContainer);
            
            let uploadedCount = 0;
            let failedCount = 0;
            let totalFiles = 0;
            
            const dropzone = new Dropzone("#gallery-dropzone", {
            url: "{{ route('admin.gallery.upload') }}",
            paramName: "image",
            maxFilesize: 10,
            acceptedFiles: "image/*",
            addRemoveLinks: false,
            method: "post",
            autoProcessQueue: false, // Changed to false to allow batch processing
            clickable: true,
            previewTemplate: '<div style="display:none"></div>',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
            },
            parallelUploads: 5, // Upload 5 files at a time
            uploadMultiple: false, // Keep false, we'll process queue manually
            maxFiles: null, // Allow unlimited files
            timeout: 300000, // 5 minutes timeout per file
            sending: function(file, xhr, formData) {
                console.log('Sending file:', file.name);
                // Ensure CSRF token is sent
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}');
            },
            init: function() {
                console.log('Dropzone initialized on gallery page');
                const dzInstance = this;
                
                // Show progress container when files are added
                this.on("addedfiles", function(files) {
                    totalFiles = files.length;
                    uploadedCount = 0;
                    failedCount = 0;
                    progressContainer.classList.remove('hidden');
                    document.getElementById('upload-progress-text').textContent = `0 / ${totalFiles}`;
                    document.getElementById('upload-progress-bar').style.width = '0%';
                    document.getElementById('upload-status').textContent = 'Ready to upload...';
                    
                    // Auto-start upload
                    if (dzInstance.getQueuedFiles().length > 0) {
                        dzInstance.processQueue();
                    }
                });
                
                this.on("addedfile", function(file) {
                    console.log('File added:', file.name);
                });
                
                this.on("success", function(file, response) {
                    console.log('Upload success:', response);
                    uploadedCount++;
                    updateProgress();
                    
                    if (response.success) {
                        // Remove file from queue
                        this.removeFile(file);
                    }
                    
                    // Process next file in queue
                    if (this.getQueuedFiles().length > 0) {
                        this.processQueue();
                    } else if (this.getQueuedFiles().length === 0 && this.getUploadingFiles().length === 0) {
                        // All files processed
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                });
                
                this.on("error", function(file, response) {
                    console.error('Upload error:', response);
                    failedCount++;
                    updateProgress();
                    
                    let errorMessage = 'Error uploading image';
                    if (response) {
                        if (typeof response === 'string') {
                            try {
                                const parsed = JSON.parse(response);
                                errorMessage = parsed.error || parsed.message || errorMessage;
                            } catch (e) {
                                errorMessage = response;
                            }
                        } else if (response.error) {
                            errorMessage = response.error;
                        } else if (response.message) {
                            errorMessage = response.message;
                        }
                    }
                    
                    document.getElementById('upload-status').innerHTML += `<div class="text-red-600 mt-1">✗ ${file.name}: ${errorMessage}</div>`;
                    this.removeFile(file);
                    
                    // Continue processing queue
                    if (this.getQueuedFiles().length > 0) {
                        this.processQueue();
                    } else if (this.getQueuedFiles().length === 0 && this.getUploadingFiles().length === 0) {
                        // All files processed
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                });
                
                this.on("uploadprogress", function(file, progress, bytesSent) {
                    updateProgress();
                });
                
                function updateProgress() {
                    const processed = uploadedCount + failedCount;
                    const percentage = totalFiles > 0 ? Math.round((processed / totalFiles) * 100) : 0;
                    document.getElementById('upload-progress-text').textContent = `${processed} / ${totalFiles}`;
                    document.getElementById('upload-progress-bar').style.width = percentage + '%';
                    
                    if (processed < totalFiles) {
                        document.getElementById('upload-status').textContent = `Uploading... ${uploadedCount} successful, ${failedCount} failed`;
                    } else {
                        document.getElementById('upload-status').textContent = `Complete! ${uploadedCount} successful, ${failedCount} failed. Refreshing page...`;
                    }
                }
            }
        });
        
        console.log('Dropzone initialized successfully');
        console.log('Dropzone instance:', dropzone);
    }
    
    // Initialize when page loads
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initDropzone, 200);
        });
    } else {
        setTimeout(initDropzone, 200);
    }
    
    // Also try after window load
    window.addEventListener('load', function() {
        setTimeout(initDropzone, 300);
    });
    })();
</script>
@endpush
@endsection

