@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

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
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 0.5rem;
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
</style>
@endpush

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Users</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['users'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Services</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['services'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Gallery Images</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['galleries'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Admins</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['admins'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('admin.users.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg mr-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Manage Users</h3>
                <p class="text-sm text-gray-600">View and edit all users</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.services.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg mr-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Manage Services</h3>
                <p class="text-sm text-gray-600">View and edit all services</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.gallery.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg mr-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Manage Gallery</h3>
                <p class="text-sm text-gray-600">View and edit gallery images</p>
            </div>
        </div>
    </a>
</div>

<!-- Tables Section -->
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Database Tables</h2>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Table Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Records</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($tables as $tableName => $count)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $tableName)) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($count) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Recent Users</h2>
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View All →</a>
    </div>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : ($user->role === 'officer' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No users found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Services Table -->
<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Recent Services</h2>
        <a href="{{ route('admin.services.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View All →</a>
    </div>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($services as $service)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $service->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $service->slung }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $service->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No services found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Gallery Section -->
<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Gallery</h2>
        <a href="{{ route('admin.gallery.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View All →</a>
    </div>
    
    <!-- Dropzone -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Upload Images</h3>
        <div class="dropzone" id="gallery-dropzone">
            <div class="dz-message">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <p class="text-lg font-medium text-gray-700 mb-2">Drag & drop images here</p>
                <p class="text-sm text-gray-500">or click to browse files</p>
                <p class="text-xs text-gray-400 mt-2">(Max file size: 10MB - JPEG, PNG, JPG, GIF, WEBP)</p>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="bg-white rounded-lg shadow p-6">
        <div id="gallery-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($galleries as $gallery)
            <div class="gallery-item group" data-id="{{ $gallery->id }}">
                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-48 object-cover">
                <div class="gallery-overlay">
                    <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mr-2">Edit</a>
                    <button onclick="deleteImage({{ $gallery->id }})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                        Delete
                    </button>
                </div>
                @if($gallery->title)
                <p class="mt-2 text-sm text-gray-600 truncate">{{ $gallery->title }}</p>
                @endif
            </div>
            @empty
            <div class="col-span-full text-center py-8 text-gray-500">
                No images in gallery yet. Upload some images to get started!
            </div>
            @endforelse
        </div>
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
            console.log('Attempting to initialize dropzone...');
            
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
            const dropzone = new Dropzone("#gallery-dropzone", {
                url: "{{ route('admin.gallery.upload') }}",
                paramName: "image",
                maxFilesize: 10,
                acceptedFiles: "image/*",
                addRemoveLinks: false,
                method: "post",
                autoProcessQueue: true,
                clickable: true,
                previewTemplate: '<div style="display:none"></div>',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                parallelUploads: 1,
                uploadMultiple: false,
                sending: function(file, xhr, formData) {
                    console.log('Sending file:', file.name);
                    // Ensure CSRF token is sent
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}');
                },
                init: function() {
                    console.log('Dropzone initialized');
                    this.on("addedfile", function(file) {
                        console.log('File added:', file.name);
                    });
                },
                success: function(file, response) {
                    console.log('Upload success:', response);
                    if (response.success) {
                        // Add new image to gallery
                        const grid = document.getElementById('gallery-grid');
                        if (grid) {
                            const emptyMsg = grid.querySelector('.col-span-full');
                            if (emptyMsg) {
                                emptyMsg.remove();
                            }
                            
                            const div = document.createElement('div');
                            div.className = 'gallery-item group';
                            div.setAttribute('data-id', response.gallery.id);
                            div.innerHTML = `
                                <img src="${response.url}" alt="${response.gallery.title || ''}" class="w-full h-48 object-cover">
                                <div class="gallery-overlay">
                                    <a href="/admin/gallery/${response.gallery.id}/edit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mr-2">Edit</a>
                                    <button onclick="deleteImage(${response.gallery.id})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                        Delete
                                    </button>
                                </div>
                                ${response.gallery.title ? `<p class="mt-2 text-sm text-gray-600 truncate">${response.gallery.title}</p>` : ''}
                            `;
                            grid.insertBefore(div, grid.firstChild);
                        }
                        
                        // Remove file from dropzone
                        this.removeFile(file);
                    }
                },
                error: function(file, response) {
                    console.error('Upload error:', response);
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
                    alert(errorMessage);
                    this.removeFile(file);
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

    function deleteImage(id) {
        if (!confirm('Are you sure you want to delete this image?')) {
            return;
        }

        fetch(`/admin/gallery/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`[data-id="${id}"]`);
                if (item) {
                    item.remove();
                }
                
                // Check if gallery is empty
                const grid = document.getElementById('gallery-grid');
                if (grid.children.length === 0) {
                    grid.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">No images in gallery yet. Upload some images to get started!</div>';
                }
            } else {
                alert('Error deleting image');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting image');
        });
    }
</script>
@endpush
@endsection
