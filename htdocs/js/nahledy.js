<<<<<<< Updated upstream
// Funkce pro změnu mini náhledu šablony
document.getElementById('template').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const imageUrl = selectedOption.getAttribute('data-image');
    const previewImage = document.getElementById('templatePreviewImage');

    // Zobrazit mini náhled
    previewImage.src = imageUrl;
    document.getElementById('templatePreview').style.display = 'block';
});

 // Funkce pro odeslání AJAX požadavku pro výpočet ceny
 document.getElementById('businessCardForm').addEventListener('change', function () {
    const quantity = document.getElementById('quantity').value;
    const paperType = document.getElementById('paperType').value;
    const printType = document.getElementById('printType').value;
    const measurement = document.getElementById('measurement').value;
    const template = document.getElementById('template').value;

    if (quantity && paperType && printType && dimension && template) {
        // Odeslání AJAX požadavku
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/objednat/calculatePrice', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const price = xhr.responseText;
                document.getElementById('price').innerText = price + ' Kč';
            }
        };
        xhr.send('quantity=' + quantity + '&paperType=' + paperType + '&printType=' + printType + '&measurement=' + measurement + '&template=' + template);
    }
});
=======
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("businessCardForm");
    const templateSelect = document.getElementById("template");
    const priceElement = document.getElementById("price");
    const orderButton = document.getElementById("orderButton");
    const orderMessage = document.getElementById("orderMessage");

    // Funkce pro změnu mini náhledu šablony 
    templateSelect.addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];
        const imageUrl = selectedOption.getAttribute("data-image");
        const previewImage = document.getElementById("templatePreviewImage");

        if (imageUrl) {
            previewImage.src = imageUrl;
            document.getElementById("templatePreview").style.display = "block";
        } else {
            document.getElementById("templatePreview").style.display = "none";
        }
    });

    // Funkce pro odeslání AJAX požadavku pro výpočet ceny
    form.addEventListener("change", function () {
        const quantity = document.getElementById("quantity").value;
        const paperType = document.getElementById("paperType").value;
        const printType = document.getElementById("printType").value;
        const measurement = document.getElementById("measurement").value;
        const template = templateSelect.value;

        if (quantity > 0 && paperType && printType && measurement && template) {
            const data = new URLSearchParams();
            data.append("quantity", quantity);
            data.append("paperType", paperType);
            data.append("printType", printType);
            data.append("measurement", measurement);
            data.append("template", template);

            fetch("?c=objednat&a=calculatePrice", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: data
            })
            .then(response => response.json()) // Očekáváme JSON odpověď
            .then(data => {
                if (data.price) {
                    let formattedPrice = new Intl.NumberFormat("cs-CZ", {
                        style: "currency",
                        currency: "CZK"
                    }).format(parseFloat(data.price));

                    priceElement.innerText = formattedPrice;
                } else {
                    priceElement.innerText = "0 Kč";
                }
            })
            .catch(error => console.error("Chyba při načítání ceny:", error));
        } else {
            priceElement.innerText = "0 Kč";
        }
    });
    
    // Odesílání objednávky do databáze po kliknutí na tlačítko "Objednat"
    orderButton.addEventListener("click", function () {
        const quantity = document.getElementById("quantity").value;
        const paperType = document.getElementById("paperType").value;
        const printType = document.getElementById("printType").value;
        const measurement = document.getElementById("measurement").value;
        const template = templateSelect.value;
        const price = parseFloat(priceElement.innerText.replace(/[^\d.]/g, ''));

        if (quantity > 0 && paperType && printType && measurement && template && price > 0) {
            const data = new URLSearchParams();
            data.append("quantity", quantity);
            data.append("paperType", paperType);
            data.append("printType", printType);
            data.append("measurement", measurement);
            data.append("template", template);
            data.append("price", price);

            fetch("?c=objednat&a=createOrder", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: data
            })
            .then(response => response.json())
            .then(data => {
                orderMessage.innerText = data.message;
                if (data.success) {
                    orderMessage.style.color = "green";
                } else {
                    orderMessage.style.color = "red";
                }
            })
            .catch(error => {
                orderMessage.innerText = "Chyba při odesílání objednávky!";
                orderMessage.style.color = "red";
                console.error("Chyba:", error);
            });
        } else {
            orderMessage.innerText = "Vyplňte všechna pole a zkontrolujte cenu!";
            orderMessage.style.color = "red";
        }
    });

    // Inicializace náhledu šablony při načtení stránky
    templateSelect.dispatchEvent(new Event("change"));
});
>>>>>>> Stashed changes
