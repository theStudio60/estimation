document.addEventListener("DOMContentLoaded", function() {
    const plafondsPrice = parseFloat(document.querySelector('[data-plafonds-price]').dataset.plafondsPrice);
    const mursPrice = parseFloat(document.querySelector('[data-murs-price]').dataset.mursPrice);

  function calculerPrix() {
    let m2Categorie1 = parseFloat(document.querySelector('[name="m2Categorie1"]').value) || 0;
    let m2Categorie2 = parseFloat(document.querySelector('[name="m2Categorie2"]').value) || 0;
    let ajustementCategorie1 = parseFloat(document.querySelector('[name="ajustementCategorie1"]').value) || 0;
    let ajustementCategorie2 = parseFloat(document.querySelector('[name="ajustementCategorie2"]').value) || 0;

    let prixBaseCategorie1 = m2Categorie1 * plafondsPrice;
    let prixBaseCategorie2 = m2Categorie2 * mursPrice;
    
    let prixTotalAjusteCategorie1 = prixBaseCategorie1 * (1 + ajustementCategorie1 * 0.01);
    let prixTotalAjusteCategorie2 = prixBaseCategorie2 * (1 + ajustementCategorie2 * 0.01);

    let prixTotal = prixTotalAjusteCategorie1 + prixTotalAjusteCategorie2;

    document.getElementById("prixTotal").textContent = prixTotal.toFixed(2);
    document.getElementById("prixTotalInput").value = prixTotal.toFixed(2); // Ajoutez cette ligne ici
}

let formElements = document.querySelectorAll('input, select');
formElements.forEach(element => {
    element.addEventListener('change', calculerPrix);
    element.addEventListener('input', calculerPrix);
});

calculerPrix();

    
});


