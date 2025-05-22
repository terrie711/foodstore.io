
document.addEventListener("DOMContentLoaded", () => {
    document.body.style.opacity = 0;
    document.body.style.transition = "opacity 1s ease";
    setTimeout(() => {
        document.body.style.opacity = 1;
    }, 100);
});


document.querySelectorAll('.button, .btn, .hi, .cbtn').forEach(button => {
    button.addEventListener('click', function (e) {
        const ripple = document.createElement("span");
        ripple.className = "ripple";
        ripple.style.left = `${e.offsetX}px`;
        ripple.style.top = `${e.offsetY}px`;
        this.appendChild(ripple);

        setTimeout(() => ripple.remove(), 600);
    });
});


document.querySelectorAll('input, textarea').forEach(input => {
    input.addEventListener('focus', () => {
        input.style.boxShadow = "0 0 8px #f2b880";
    });
    input.addEventListener('blur', () => {
        input.style.boxShadow = "none";
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const cartBubble = document.getElementById("cartToggle");
    const cartPanel = document.getElementById("cartPanel");

    cartBubble.addEventListener("click", () => {
        cartPanel.style.display = (cartPanel.style.display === "flex") ? "none" : "flex";
    });

    document.addEventListener("click", function(event) {
        if (!cartPanel.contains(event.target) && !cartBubble.contains(event.target)) {
            cartPanel.style.display = "none";
        }
    });
});
document.getElementById("aboutBtn").addEventListener("click", () => {
    document.getElementById("aboutSection").style.display = "block";
});

document.getElementById("closeAbout").addEventListener("click", () => {
    document.getElementById("aboutSection").style.display = "none";
});
document.addEventListener("DOMContentLoaded", () => {

    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener("keyup", () => {
            const filter = searchInput.value.toLowerCase();
            const cards = document.querySelectorAll(".food-card");

            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.parentElement.style.display = text.includes(filter) ? "" : "none";
            });
        });
    }
});
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");

    if (searchInput) {
        searchInput.addEventListener("keyup", function () {
            const query = this.value;
            fetch("search.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "query=" + encodeURIComponent(query)
            })
            .then(res => res.text())
            .then(data => {
                document.getElementById("foodResults").innerHTML = data;
                attachAddToCartHandlers(); // reattach events to new buttons
            });
        });
    }

    function attachAddToCartHandlers() {
        document.querySelectorAll(".add-to-cart-form").forEach(form => {
            form.addEventListener("submit", function (e) {
                e.preventDefault();
                const foodId = this.dataset.id;
                const quantity = this.querySelector('input[name="quantity"]').value;
                const button = this.querySelector(".add-to-cart-btn");

                button.disabled = true;
                button.innerHTML = "✔";
                button.classList.add("cart-added");

                fetch(window.location.href, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: `ac=${foodId}&quantity=${quantity}`
                })
                .then(res => res.json())
                .then(data => {
                    document.querySelector(".cart-count").textContent = data.count;
                    setTimeout(() => {
                        button.innerHTML = "Add to Cart";
                        button.disabled = false;
                        button.classList.remove("cart-added");
                    }, 1000);
                });
            });
        });
    }

    attachAddToCartHandlers(); // Initial binding
});