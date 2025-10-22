<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 style="font-size: 1.5rem;">ShopFashion</h5>
                <p>Thời trang cho mọi phong cách. Mang đến cho bạn những sản phẩm chất lượng tốt nhất.</p>
            </div>
            
            <div class="col-md-4 mb-4">
                <h5>Liên kết</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                    <li><a href="{{ route('promotions.index') }}">Khuyến mãi</a></li>
                    <li><a href="{{ route('contact.form') }}">Liên hệ</a></li>
                    <li><a href="#">Chính sách đổi trả</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-4">
                <h5>Mạng xã hội</h5>
                <p>Theo dõi chúng tôi để nhận thông tin mới nhất.</p>
                <div class="social-icons">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 ShopFashion. All rights reserved.</p>
        </div>
    </div>
</footer>