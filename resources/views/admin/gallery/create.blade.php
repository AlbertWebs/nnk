@extends('admin.layout')

@section('title', 'Create Gallery Item')
@section('page-title', 'Add New Image to Gallery')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
            <input type="file" name="image" id="image" accept="image/*" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <p class="mt-1 text-sm text-gray-500">Max file size: 10MB. Accepted formats: JPEG, PNG, JPG, GIF, WEBP</p>
        </div>

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title (Optional)</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
            <textarea name="description" id="description" rows="4"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.gallery.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Upload Image</button>
        </div>
    </form>
</div>
@endsection

