function addToCart(button, productId, productName, price, count = 1) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let existingProduct = cart.find((item) => item.productId === productId);

    if (existingProduct) {
        existingProduct.count += count;
    } else {
        cart.push({
            productId: productId,
            productName: productName,
            price: price,
            count: count,
        });
    }
    // localStorage.setItem("cart", JSON.stringify(cart));
    // if (!button.classList.contains("disabled")) {
    //     document.getElementById("myAudio2").play();
    //     button.classList.add("disabled");
    //     button.classList.add("clicked");
    //     setTimeout(() => {
    //         button.classList.remove("clicked");
    //         button.classList.remove("disabled");
    //     }, 300);
    // }
}

function loadCartItems() {
    const cartItemsContainer = document.getElementById("cart-items-container");
    const emptyCartButton = document.getElementById("empty-cart");
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    cartItemsContainer.innerHTML = "";
    if (cart.length === 0) {
        cartItemsContainer.innerHTML = "<p>Your cart is empty.</p>";
        emptyCartButton.style.display = "none";
        return;
    }
    cart.forEach((item) => {
        const itemElement = document.createElement("div");
        itemElement.className = "cart-item";
        itemElement.innerHTML = `
            <span>${item.productName}</span>
            <span>${item.price} x ${item.count}</span>
        `;
        cartItemsContainer.appendChild(itemElement);
    });
    emptyCartButton.style.display = "inline-block";
}

function empltyCart() {
    localStorage.removeItem("cart");
    loadCartItems();
}
function sendCart() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    if (cart.length === 0) {
        alert("Your cart is empty.");
        return;
    }
    const message = cart
        .map((item) => `${item.productName} (${item.count} x ${item.price})`)
        .join("\n");
    const phoneNumber = "+96181390698"; // Replace with your WhatsApp number
    const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(
        "Order Details:\n" + message
    )}`;
    window.open(url, "_blank");
}
