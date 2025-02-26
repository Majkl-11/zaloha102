document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("businessCardForm");
    const templateSelect = document.getElementById("template");
    const priceElement = document.getElementById("price");
    const orderButton = document.getElementById("orderButton");
    const logoInput = document.getElementById("logo");

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
            .then(response => response.json()) 
            .then(data => {
                priceElement.innerText = data.price ? `${parseFloat(data.price).toFixed(2)} Kč` : "0 Kč";
            });
        } else {
            priceElement.innerText = "0 Kč";
        }
    });

    orderButton.addEventListener("click", function (event) {
        event.preventDefault();
        const formData = new FormData(form);
        formData.append("price", priceElement.innerText.replace(" Kč", "").trim());

        fetch("?c=objednat&a=createOrder", {
            method: "POST",
            body: formData
        })
        .then(() => location.reload()) // Okamžitý refresh stránky po odeslání formuláře
        .catch(() => location.reload()); // I v případě chyby refresh
    });

    templateSelect.dispatchEvent(new Event("change"));
});
