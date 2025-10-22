document.addEventListener('DOMContentLoaded', function() {
 
    const clipboard = new ClipboardJS('.btn-copy-code');

    clipboard.on('success', function(e) {
        const originalText = e.trigger.innerHTML;
        
        e.trigger.innerHTML = 'Đã chép!';
        e.trigger.classList.add('copied');
    
        setTimeout(function() {
            e.trigger.innerHTML = originalText;
            e.trigger.classList.remove('copied');
        }, 2000);

        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        alert('Lỗi! Vui lòng sao chép thủ công.');
    });
});