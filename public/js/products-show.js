document.addEventListener('DOMContentLoaded', function() {
    const cartForm = document.getElementById('add-to-cart-form');
    
    if (cartForm) {
        cartForm.addEventListener('submit', function(e) {
            
            const submitButton = cartForm.querySelector('button[type="submit"]:focus');
            if (submitButton && submitButton.disabled) {
                e.preventDefault();
                return;
            }

            let isValid = true;
            
            const sizeGroup = document.getElementById('size-group');
            const sizeError = document.getElementById('size-error');
            if (sizeGroup) { 
                const selectedSize = sizeGroup.querySelector('input[name="size_id"]:checked');
                if (!selectedSize) {
                    isValid = false;
                    sizeError.classList.remove('d-none'); 
                    sizeError.classList.add('d-block');
                } else {
                    sizeError.classList.add('d-none');
                    sizeError.classList.remove('d-block');
                }
            }

            const colorGroup = document.getElementById('color-group');
            const colorError = document.getElementById('color-error');
            if (colorGroup) { 
                const selectedColor = colorGroup.querySelector('input[name="color_id"]:checked');
                if (!selectedColor) {
                    isValid = false;
                    colorError.classList.remove('d-none');
                    colorError.classList.add('d-block');
                } else {
                    colorError.classList.add('d-none');
                    colorError.classList.remove('d-block');
                }
            }

            if (!isValid) {
                e.preventDefault(); 
            }
        });
    }
});