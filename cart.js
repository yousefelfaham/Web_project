// Cart Management Logic
const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
const viewCartButton = document.getElementById('view-cart-btn');
const cartModal = document.getElementById('cart-modal');
const closeModalButton = document.getElementById('close-modal-btn');
const cartCount = document.getElementById('cart-count');
const cartItemsContainer = document.getElementById('cart-items');
const cartTotalContainer = document.getElementById('cart-total');
const clearCartButton = document.getElementById('clear-cart-btn');

let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Update Cart Display
const updateCartDisplay = () => {
    cartCount.textContent = `${cart.reduce((acc, item) => acc + item.quantity, 0)} items`;

    cartItemsContainer.innerHTML = '';
    let totalPrice = 0;
    cart.forEach(item => {
        totalPrice += item.price * item.quantity;
        cartItemsContainer.innerHTML += `
            <p>${item.name} (x${item.quantity}) - EG ${item.price * item.quantity}</p>
        `;
    });
    cartTotalContainer.textContent = `Total: EG ${totalPrice}`;
};

// Add Product to Cart
addToCartButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        const card = e.target.closest('.product-card');
        const productId = card.dataset.id;
        const productName = card.dataset.name;
        const productPrice = parseInt(card.dataset.price, 10);

        const existingProduct = cart.find(item => item.id === productId);
        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cart.push({ id: productId, name: productName, price: productPrice, quantity: 1 });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartDisplay();
    });
});

// View Cart Modal
viewCartButton.addEventListener('click', () => {
    cartModal.style.display = 'flex';
    updateCartDisplay();
});

// Close Cart Modal
closeModalButton.addEventListener('click', () => {
    cartModal.style.display = 'none';
});

// Clear Cart
clearCartButton.addEventListener('click', () => {
    cart = [];
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
    cartModal.style.display = 'none';
});
