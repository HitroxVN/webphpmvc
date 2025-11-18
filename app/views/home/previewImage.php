<!-- Modal để xem ảnh to (tách riêng) -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body bg-dark p-0">
                <img id="modalImage" src="" alt="" class="img-fluid w-100" style="max-height: 80vh; object-fit: contain;">
            </div>
            <div class="modal-footer bg-dark border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainImage = document.getElementById('mainImage');
        const thumbnails = document.querySelectorAll('.thumbnail-img');
        // If bootstrap is not loaded yet, this will throw; guard with try/catch
        let imageModal = null;
        try {
            imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        } catch (e) {
            // bootstrap may not be ready; we'll create modal instance on demand
            imageModal = null;
        }
        const modalImage = document.getElementById('modalImage');

        // Click vào ảnh phụ để thay đổi ảnh chính
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const fullSrc = this.getAttribute('data-full-src');
                if (fullSrc) mainImage.src = fullSrc;
                
                // Cập nhật active class
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Click vào ảnh chính để mở modal xem to
        mainImage.addEventListener('click', function() {
            modalImage.src = mainImage.src;
            if (!imageModal) {
                // create modal instance lazily
                imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            }
            imageModal.show();
        });
    });
</script>
