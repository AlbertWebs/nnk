@extends('front.master-pages')

@section('content')

   <!-- Contents -->
	<div class="section section-contents section-pad">
		<div class="container">
			<div class="content row">

				<div class="row">
					<div class="col-md-12">
						<h1>Gallery</h1>
						<p>
							Welcome to the NNK Staff Sacco Gallery. Browse through our collection of images showcasing our events, activities, achievements, and moments that define our community. Click on any image to view it in full size.
						</p>
						
						<hr>

						@if($galleries->count() > 0)
							<div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 30px;">
								@foreach($galleries as $gallery)
									<div class="gallery-item" style="position: relative; overflow: hidden; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); cursor: pointer; transition: transform 0.3s ease, box-shadow 0.3s ease;" 
										 onclick="openImageModal('{{ asset('storage/' . $gallery->image_path) }}', '{{ $gallery->title ?? 'Untitled' }}', '{{ $gallery->description ?? '' }}')"
										 onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.2)'"
										 onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
										<img src="{{ asset('storage/' . $gallery->image_path) }}" 
											 alt="{{ $gallery->title ?? 'Gallery Image' }}" 
											 style="width: 100%; height: 250px; object-fit: cover; display: block;">
										<!-- @if($gallery->title)
											<div style="padding: 12px; background: white; border-top: 1px solid #eee;">
												<p style="margin: 0; font-size: 14px; color: #333; font-weight: 500;">{{ $gallery->title }}</p>
											</div>
										@endif -->
										<div class="gallery-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0); display: flex; align-items: center; justify-content: center; transition: background 0.3s ease;"
											 onmouseover="this.style.background='rgba(0,0,0,0.5)'"
											 onmouseout="this.style.background='rgba(0,0,0,0)'">
											<svg style="width: 40px; height: 40px; color: white; opacity: 0; transition: opacity 0.3s ease;" 
												 onmouseover="this.style.opacity='1'" 
												 onmouseout="this.style.opacity='0'"
												 fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
											</svg>
										</div>
									</div>
								@endforeach
							</div>

							<div style="margin-top: 40px; text-align: center;">
								{{ $galleries->links() }}
							</div>
						@else
							<div style="text-align: center; padding: 60px 20px;">
								<p style="font-size: 18px; color: #666; margin-bottom: 10px;">No images in gallery yet.</p>
								<p style="color: #999;">Check back soon for updates.</p>
							</div>
						@endif
					</div>
				</div>

			</div>
		</div>		
	</div>
	<!-- End Section -->

<!-- Image Modal for Zoom -->
<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; overflow-y: auto;" onclick="closeImageModal()">
	<div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px;">
		<div style="position: relative; max-width: 90%; max-height: 90vh; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.5);" onclick="event.stopPropagation()">
			<!-- Close Button -->
			<button onclick="closeImageModal()" style="position: absolute; top: 15px; right: 15px; z-index: 10000; background: rgba(0,0,0,0.7); color: white; border: none; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.3s ease;" 
					onmouseover="this.style.background='rgba(0,0,0,0.9)'"
					onmouseout="this.style.background='rgba(0,0,0,0.7)'">
				<svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
				</svg>
			</button>
			
			<!-- Image Container -->
			<div style="background: #f5f5f5; padding: 20px; border-bottom: 1px solid #ddd;">
				<h3 id="modalTitle" style="margin: 0 0 8px 0; font-size: 20px; color: #333; font-weight: 600;"></h3>
				<p id="modalDescription" style="margin: 0; font-size: 14px; color: #666;"></p>
			</div>
			<div style="display: flex; align-items: center; justify-content: center; background: #000; padding: 20px;">
				<img id="modalImage" src="" alt="" style="max-width: 100%; max-height: 75vh; object-fit: contain; display: block;">
			</div>
		</div>
	</div>
</div>

@push('styles')
<style>
	#imageModal {
		animation: fadeIn 0.3s ease-in-out;
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

	@media (max-width: 768px) {
		.gallery-grid {
			grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)) !important;
			gap: 15px !important;
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
		
		modal.style.display = 'block';
		document.body.style.overflow = 'hidden'; // Prevent background scrolling
	}
	
	function closeImageModal() {
		const modal = document.getElementById('imageModal');
		modal.style.display = 'none';
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

