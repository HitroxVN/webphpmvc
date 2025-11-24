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
    const modalImage = document.getElementById('modalImage');
    const imageModalEl = document.getElementById('imageModal');

    // Lưu ảnh chính ban đầu
    const originalMainImage = mainImage.src;

    // Khởi tạo modal
    let imageModal = new bootstrap.Modal(imageModalEl);

    // Click ảnh phụ → đổi ảnh chính
    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function() {
            const fullSrc = this.getAttribute('data-full-src');
            if (fullSrc) mainImage.src = fullSrc;

            thumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Click ảnh chính → mở modal
    mainImage.addEventListener('click', function() {
        modalImage.src = mainImage.src;
        imageModal.show();
    });

    // Khi đóng modal → trả về ảnh chính ban đầu
    imageModalEl.addEventListener('hidden.bs.modal', function() {
        mainImage.src = originalMainImage;
        
        // Reset active thumbnail
        thumbnails.forEach(t => t.classList.remove('active'));
        thumbnails[0]?.classList.add('active'); // active ảnh đầu tiên
    });
});
</script>