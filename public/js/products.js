document.addEventListener('DOMContentLoaded', function () {
    
    const filterForm = document.getElementById('product-filter-form');
    const productGrid = document.querySelector('.product-grid');
    const paginationContainer = document.querySelector('.pagination-container');
    const mainContent = document.querySelector('.main-content');

    if (filterForm && productGrid && paginationContainer && mainContent) {

        const handleFilterSubmit = () => {
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData).toString();
            const url = filterForm.action + '?' + params;

            loadProducts(url);

            window.history.pushState({ path: url }, '', url);
        };

        filterForm.addEventListener('submit', function (e) {
            e.preventDefault(); 
            handleFilterSubmit(); 
        });

        filterForm.addEventListener('change', function (e) {
            handleFilterSubmit();
        });
        
        mainContent.addEventListener('click', function(e) {
            if (e.target.matches('.pagination-container .page-link')) {
                e.preventDefault();
                const url = e.target.href;
                if (url) {
                    loadProducts(url);
                    window.history.pushState({path: url}, '', url);
                }
            }
        });
    }

    async function loadProducts(url) {
        try {
            productGrid.style.opacity = '0.5';
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

            productGrid.innerHTML = data.product_grid_html;
            paginationContainer.innerHTML = data.pagination_html;
            
            productGrid.style.opacity = '1';

        } catch (error) {
            console.error('Lỗi khi tải sản phẩm:', error);
            window.location.href = url; 
        }
    }
});