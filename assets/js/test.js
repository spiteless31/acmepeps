function test() {
    console.log(autocomplete.value);
    url = `/testy/autocomplete/${autocomplete.value}`;
    fetch(url)
        .then(response => response.json())
        .then(products => {
            console.log(products);
            autocomplete_results.innerHTML = '';
            products.forEach(product => {
                let p = document.createElement('p');
                p.textContent = `${product.name} (${product.ref}) ${product.price} €`;
                autocomplete_results.appendChild(p);
            });
        });
}