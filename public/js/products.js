document.addEventListener('DOMContentLoaded', function () {
    
    // Tìm các thành phần chính
    const filterForm = document.getElementById('product-filter-form');
    const productGrid = document.querySelector('.product-grid');
    const paginationContainer = document.querySelector('.pagination-container');
    const mainContent = document.querySelector('.main-content');

    // Chỉ chạy JS nếu tìm thấy các thành phần này
    if (filterForm && productGrid && paginationContainer && mainContent) {

        /**
         * TẠO HÀM LỌC CHUNG
         * Hàm này sẽ lấy dữ liệu form, tạo URL và gọi AJAX
         */
        const handleFilterSubmit = () => {
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData).toString();
            const url = filterForm.action + '?' + params;

            // Gọi hàm tải sản phẩm
            loadProducts(url);

            // Cập nhật URL trên trình duyệt
            window.history.pushState({ path: url }, '', url);
        };


        // === CẬP NHẬT CHÍNH ===
        
        // 1. LỌC KHI NHẤN NÚT "LỌC" (NẾU BẠN QUYẾT ĐỊNH THÊM LẠI NÚT NÀY)
        filterForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Ngăn tải lại trang
            handleFilterSubmit(); // Gọi hàm lọc
        });

        // 2. LỌC TỰ ĐỘNG KHI THAY ĐỔI BẤT KỲ INPUT NÀO
        // Đây là mấu chốt: Lắng nghe sự kiện 'change' trên toàn bộ form
        filterForm.addEventListener('change', function (e) {
            // Khi bất kỳ checkbox, radio, hoặc select thay đổi, gọi hàm lọc
            handleFilterSubmit();
        });
        
        // =======================


        // 3. XỬ LÝ PHÂN TRANG (Giữ nguyên)
        mainContent.addEventListener('click', function(e) {
            // Chỉ xử lý khi click vào link phân trang
            if (e.target.matches('.pagination-container .page-link')) {
                e.preventDefault(); // Ngăn click link
                const url = e.target.href;
                if (url) {
                    loadProducts(url);
                    window.history.pushState({path: url}, '', url);
                }
            }
        });
    }

    /**
     * HÀM TẢI SẢN PHẨM BẰNG AJAX (Giữ nguyên)
     */
    async function loadProducts(url) {
        try {
            // Thêm hiệu ứng loading (tùy chọn)
            productGrid.style.opacity = '0.5';

            // Thêm header 'X-Requested-With' để Laravel biết đây là AJAX
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            // Cập nhật HTML cho lưới sản phẩm và phân trang
            productGrid.innerHTML = data.product_grid_html;
            paginationContainer.innerHTML = data.pagination_html;
            
            // Bỏ hiệu ứng loading
            productGrid.style.opacity = '1';

            // Cuộn lên đầu danh sách sản phẩm (tùy chọn)
            // mainContent.scrollIntoView({ behavior: 'smooth' });

        } catch (error) {
            console.error('Lỗi khi tải sản phẩm:', error);
            window.location.href = url; // Nếu lỗi, tải lại trang
        }
    }
});