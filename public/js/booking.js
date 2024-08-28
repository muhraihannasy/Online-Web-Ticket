const plus = document.getElementById("plus");
const minus = document.getElementById("minus");
const text = document.getElementById("count-text");
const people = document.getElementById("people");
const totalPriceElement = document.getElementById("total-price");

const price = document.getElementById("price");
const subtotalInput = document.getElementById("subtotal");
const total_ppn = document.getElementById("total_ppn");
const total_amount = document.getElementById("total_amount");

const pricePerItem = parseInt(price.textContent, 0);

console.log(price);

function formatRupiah(number) {
    return "Rp " + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function updateTotalPrice() {
    let currentValue = parseInt(people.value);

    const ppn = 0.11;
    const subtotal = currentValue * pricePerItem;
    const totalPpn = subtotal * ppn;
    const totalPrice = subtotal + totalPpn;

    totalPriceElement.textContent = formatRupiah(totalPrice);

    subtotalInput.value = subtotal;
    total_ppn.value = totalPpn;
    total_amount.value = totalPrice;
}

plus.addEventListener("click", () => {
    let currentValue = parseInt(people.value);
    currentValue++;
    people.value = currentValue;
    text.textContent = currentValue;
    updateTotalPrice();
});

minus.addEventListener("click", () => {
    let currentValue = parseInt(people.value);
    if (currentValue > 1) {
        currentValue--;
        people.value = currentValue;
        text.textContent = currentValue;
        updateTotalPrice();
    }
});

// Initialize total price
updateTotalPrice();

console.log(subtotal.value, "Apasdasd");
