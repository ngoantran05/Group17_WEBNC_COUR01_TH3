document.addEventListener('DOMContentLoaded', function() {
    
    // Khởi tạo Clipboard
    // Nó sẽ tự động tìm tất cả các nút có class 'btn-copy-code'
    const clipboard = new ClipboardJS('.btn-copy-code');

    // Xử lý khi copy thành công
    clipboard.on('success', function(e) {
        const originalText = e.trigger.innerHTML;
        
        // Đổi chữ trên nút
        e.trigger.innerHTML = 'Đã chép!';
        e.trigger.classList.add('copied');
        
        // Reset nút sau 2 giây
        setTimeout(function() {
            e.trigger.innerHTML = originalText;
            e.trigger.classList.remove('copied');
        }, 2000);

        e.clearSelection();
    });

    // Xử lý khi copy thất bại
    clipboard.on('error', function(e) {
        alert('Lỗi! Vui lòng sao chép thủ công.');
    });
});