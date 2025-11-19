// Display Cart
document.addEventListener("DOMContentLoaded", function () {
    const cartItemsContainer = document.getElementById('cart-items');
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
    } else {
        let cartHTML = '<ul>';
        cart.forEach(item => {
            cartHTML += `
                <li>
                    ${item.name} - $${item.price} x ${item.quantity}
                    <button class="remove-from-cart" data-product-id="${item.id}">Remove</button>
                </li>
            `;
        });
        cartHTML += '</ul>';
        cartItemsContainer.innerHTML = cartHTML;

        // Remove from cart functionality
        const removeButtons = document.querySelectorAll('.remove-from-cart');
        removeButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.dataset.productId;

                // Remove product from cart
                cart = cart.filter(item => item.id !== productId);
                localStorage.setItem('cart', JSON.stringify(cart));

                // Refresh the cart display
                location.reload();
            });
        });
    }
});
