function addToList(button, productId, productImage, productName, price) {
    let list = JSON.parse(localStorage.getItem("wish_list")) || [];
    let existingProduct = cart.find((item) => item.productId === productId);
    if (existingProduct) {
        existingProduct.count += count;
    } else {
        list.push({
            productId: productId,
            productName: productName,
            productImage: productImage,
            price: price,
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

function loadListItems() {
    const cartItemsContainer = document.getElementById("cart-items-container");
    const emptyCartButton = document.getElementById("empty-cart");
    const cart = JSON.parse(localStorage.getItem("wish_list")) || [];
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
            <img src="${item.productImage}">
            <span>${item.price}</span>
        `;
        cartItemsContainer.appendChild(itemElement);
    });
    emptyCartButton.style.display = "inline-block";
}

function empltyList() {
    localStorage.removeItem("wish_list");
    loadCartItems();
}
