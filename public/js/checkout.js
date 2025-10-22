document.addEventListener('DOMContentLoaded', function() {
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const applyBtn = document.getElementById('apply-discount-btn');
    const discountInput = document.getElementById('discount-code-input');
    const messageContainer = document.getElementById('discount-message');
    
    const subtotalDisplay = document.getElementById('subtotal-display');
    const shippingDisplay = document.getElementById('shipping-display');
    const totalDisplay = document.getElementById('total-display');

    if (applyBtn) {
        applyBtn.addEventListener('click', async function() {
            const code = discountInput.value;
            if (!code) {
                messageContainer.innerHTML = '<span class="text-danger">Vui lòng nhập mã.</span>';
                return;
            }
            try {
                messageContainer.innerHTML = 'Đang kiểm tra...';
                const response = await fetch('/apply-discount', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        discount_code: code
                    })
                });
                const data = await response.json();
                if (data.success) {
                    subtotalDisplay.innerText = data.newSubtotalFormatted + 'đ';
                    shippingDisplay.innerText = data.newShippingFormatted + 'đ';
                    totalDisplay.innerText = data.newTotalFormatted + 'đ';
                    messageContainer.innerHTML = `<span class="text-success">${data.message}</span>`;
                    applyBtn.disabled = true;
                    discountInput.disabled = true;
                } else {
                    messageContainer.innerHTML = `<span class="text-danger">${data.message}</span>`;
                }
            } catch (error) {
                console.error('Lỗi:', error);
                messageContainer.innerHTML = '<span class="text-danger">Không thể áp dụng mã.</span>';
            }
        });
    }

    const apiHost = 'https://provinces.open-api.vn/api/';
    const provinceSelect = document.getElementById('province-select');
    const districtSelect = document.getElementById('district-select');
    const wardSelect = document.getElementById('ward-select');

    async function fetchApi(url) {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return await response.json();
        } catch (error) {
            console.error('Lỗi khi fetch API:', error);
            return null;
        }
    }

    function renderOptions(selectElement, data, defaultText) {
        selectElement.innerHTML = `<option value="">-- ${defaultText} --</option>`;
        data.forEach(item => {
            const option = new Option(item.name, item.name);
            option.dataset.code = item.code; 
            selectElement.appendChild(option);
        });
        selectElement.disabled = false;
    }

    async function loadProvinces() {
        const data = await fetchApi(apiHost + 'p/');
        if (data) {
            renderOptions(provinceSelect, data, 'Chọn Tỉnh/Thành phố');
        }
    }

    if (provinceSelect) {
        provinceSelect.addEventListener('change', async function() {
            const selectedOption = this.options[this.selectedIndex];
            const provinceCode = selectedOption.dataset.code;
            
            districtSelect.innerHTML = '<option value="">-- Đang tải... --</option>';
            wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
            districtSelect.disabled = true;
            wardSelect.disabled = true;

            if (provinceCode) {
                const data = await fetchApi(apiHost + 'p/' + provinceCode + '?depth=2');
                if (data && data.districts) {
                    renderOptions(districtSelect, data.districts, 'Chọn Quận/Huyện');
                }
            }
        });
    }

    if (districtSelect) {
        districtSelect.addEventListener('change', async function() {
            const selectedOption = this.options[this.selectedIndex];
            const districtCode = selectedOption.dataset.code;

            wardSelect.innerHTML = '<option value="">-- Đang tải... --</option>';
            wardSelect.disabled = true;

            if (districtCode) {
                const data = await fetchApi(apiHost + 'd/' + districtCode + '?depth=2');
                if (data && data.wards) {
                    renderOptions(wardSelect, data.wards, 'Chọn Phường/Xã');
                }
            }
        });
    }

    if(provinceSelect) {
        loadProvinces();
    }
});