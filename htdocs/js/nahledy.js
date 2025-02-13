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
