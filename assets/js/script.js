document.addEventListener('DOMContentLoaded', () => {
    const deselecteazaButon = document.getElementById('deselecteaza-toate');
    const principalList = document.getElementById('principal-list');
    const bifateList = document.getElementById('bifate-list');
    const BATCH_SIZE = 10;
    const addedElements = new Set(); // Set pentru a ține evidența elementelor adăugate

    // Eveniment pentru butonul "deselectează toate"
    deselecteazaButon.addEventListener('click', () => {
        const checkboxuriPrincipale = Array.from(principalList.querySelectorAll('input[type="checkbox"]'));
        processCheckboxesInBatches(checkboxuriPrincipale, false);
    });

    // Eveniment pentru schimbările din lista principală de checkbox-uri
    principalList.addEventListener('change', event => {
        if (event.target.classList.contains('pt-checkbox')) {
            handleCheckboxChange(event.target);
        }
    });

    // Funcție pentru procesarea checkbox-urilor în loturi
    function processCheckboxesInBatches(checkboxes, checked) {
        const batches = [];
        for (let i = 0; i < checkboxes.length; i += BATCH_SIZE) {
            batches.push(checkboxes.slice(i, i + BATCH_SIZE));
        }

        // Procesează fiecare lot cu un interval de 100ms între loturi
        batches.forEach((batch, index) => {
            setTimeout(() => {
                batch.forEach(checkbox => {
                    checkbox.checked = checked;
                    handleCheckboxChange(checkbox);
                });
            }, index * 500);
        });
    }

    // Funcție pentru a gestiona schimbarea unui checkbox
    function handleCheckboxChange(checkbox) {
        const subCheckboxes = checkbox.closest('li, details')?.querySelectorAll('ul input[type="checkbox"]') || [];

        // Actualizează starea fiecărui sub-checkbox
        subCheckboxes.forEach(subCheckbox => {
            subCheckbox.checked = checkbox.checked;
            updateCheckboxState(subCheckbox);
        });

        // Adaugă sau elimină elemente din lista bifate și actualizează starea checkbox-ului
        if (!checkbox.closest('li, details').querySelector('ul')) {
            checkbox.checked ? adaugaElementBifat(checkbox) : eliminaElementBifat(checkbox);
            updateCheckboxState(checkbox);
        } else {
            subCheckboxes.forEach(subCheckbox => {
                if (!subCheckbox.closest('li, details').querySelector('ul')) {
                    subCheckbox.checked ? adaugaElementBifat(subCheckbox) : eliminaElementBifat(subCheckbox);
                }
            });
        }
    }

    // Funcție pentru a adăuga un element în lista bifate
    function adaugaElementBifat(element) {
        if (!addedElements.has(element.dataset.pt)) {
            addedElements.add(element.dataset.pt); // Adaugă elementul în set pentru a evita duplicarea
            const listItem = document.createElement('tr');
            listItem.setAttribute('id', 'row-' + element.dataset.pt);
            fetchPTData(element.dataset.pt).then(data => {
                if (data && data.pt) {
                    listItem.innerHTML = `
                        <td>${data.oficiu}</td>
                        <td>${data.statiune}</td>
                        <td>${data.fider}</td>
                        <td>${data.pt}</td>
                        <td class="casnici">${data.casnici}</td>
                        <td class="economici">${data.economici}</td>
                        <td class="localitate">${data.localitatea}</td>
                        <td>${data.adresa}</td>
                        <td>${data.apartenenta}</td>
                    `;
                    bifateList.appendChild(listItem);
                }
            }).catch(error => console.error('Error fetching data:', error));
        }
    }

    // Funcție pentru a elimina un element din lista bifate
    function eliminaElementBifat(element) {
        addedElements.delete(element.dataset.pt); // Elimină elementul din set
        const listItemToRemove = document.getElementById('row-' + element.dataset.pt);
        if (listItemToRemove) {
            listItemToRemove.remove();
        }
    }

    // Funcție pentru a obține datele pentru un anumit pt de la server
    async function fetchPTData(pt) {
        try {
            const response = await fetch('./functions/fetch_pt_data.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `pt=${encodeURIComponent(pt)}`
            });
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Network response was not ok');
            }
        } catch (error) {
            console.error('Fetch error:', error);
            throw error;
        }
    }

    // Funcție pentru a actualiza starea unui checkbox pe server
    async function updateCheckboxState(checkbox) {
        try {
            const checkboxes = Array.isArray(checkbox) ? checkbox : [checkbox];
            const response = await fetch('./functions/update_checkbox_state.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(checkboxes.map(checkbox => ({
                    pt: checkbox.dataset.pt,
                    checked: checkbox.checked ? 1 : 0
                })))
            });
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
        } catch (error) {
            console.error('Update state error:', error);
            retryUpdateCheckboxState(checkbox);
        }
    }


    // Funcție pentru a retrimite cererea de actualizare a stării unui checkbox în caz de eșec
    function retryUpdateCheckboxState(checkbox, retries = 3) {
        if (retries > 0) {
            setTimeout(() => {
                updateCheckboxState(checkbox).catch(() => retryUpdateCheckboxState(checkbox, retries - 1));
            }, 500);
        } else {
            console.error('Failed to update checkbox state after multiple attempts');
        }
    }


    // Funcție pentru a șterge lista de elemente bifate
    function clearBifateList() {
        while (bifateList.firstChild) {
            bifateList.removeChild(bifateList.firstChild);
        }
    }

    // Funcție pentru a obține elementele bifate inițial de la server
    async function fetchInitialCheckedItems() {
        try {
            const response = await fetch('./functions/get_checked_items.php');
            if (response.ok) {
                const checkedItems = await response.json();
                clearBifateList();
                const checkboxes = checkedItems.map(item => principalList.querySelector(`input[data-pt="${item}"]`)).filter(Boolean);
                processCheckboxesInBatches(checkboxes, true);
            } else {
                throw new Error('Network response was not ok');
            }
        } catch (error) {
            console.error('Fetch initial checked items error:', error);
        }
    }

    // Obține elementele bifate inițial la încărcarea paginii
    fetchInitialCheckedItems();
});

// Suma Casnici, Economici, Concatinarea Localitati
// document.addEventListener('DOMContentLoaded', function() {
//     const totalCasniciCell = document.getElementById('total-casnici');
//     const totalEconomiciCell = document.getElementById('total-economici');
//
//     // Funcție pentru calcularea totalului
//     function calculateTotals() {
//         const casniciCells = document.querySelectorAll('td.casnici');
//         const economiciCells = document.querySelectorAll('td.economici');
//
//         let totalCasnici = 0;
//         let totalEconomici = 0;
//
//         casniciCells.forEach(cell => {
//             totalCasnici += parseFloat(cell.textContent) || 0;
//         });
//
//         economiciCells.forEach(cell => {
//             totalEconomici += parseFloat(cell.textContent) || 0;
//         });
//
//         totalCasniciCell.textContent = totalCasnici;
//         totalEconomiciCell.textContent = totalEconomici;
//     }
//
//     // Folosim MutationObserver pentru a detecta schimbările în celulele tabelului
//     const observerConfig = { childList: true, subtree: true, characterData: true };
//
//     const observerCallback = function(mutationsList, observer) {
//         calculateTotals();
//     };
//
//     const observer = new MutationObserver(observerCallback);
//
//     observer.observe(document.getElementById('bifate-list'), observerConfig);
//
//     // Calcul totaluri la inițializare
//     calculateTotals();
// });


document.addEventListener('DOMContentLoaded', function() {
    const totalCasniciCell = document.getElementById('total-casnici');
    const totalEconomiciCell = document.getElementById('total-economici');
    const localitatiCell = document.getElementById('localitati-unice'); // Celula cu localitățile

    // Funcție pentru calcularea totalului și colectarea localităților unice
    function calculateTotals() {
        const casniciCells = document.querySelectorAll('td.casnici');
        const economiciCells = document.querySelectorAll('td.economici');
        const localitatiCells = document.querySelectorAll('td.localitate');

        let totalCasnici = 0;
        let totalEconomici = 0;
        let localitati = new Set(); // Set pentru localitățile unice

        casniciCells.forEach(cell => {
            totalCasnici += parseFloat(cell.textContent) || 0;
        });

        economiciCells.forEach(cell => {
            totalEconomici += parseFloat(cell.textContent) || 0;
        });

        // Adăugăm localitățile unice în set
        localitatiCells.forEach(cell => {
            localitati.add(cell.textContent.trim());
        });

        totalCasniciCell.textContent = totalCasnici;
        totalEconomiciCell.textContent = totalEconomici;
        localitatiCell.textContent = Array.from(localitati).join(', '); // Afișăm localitățile separate prin virgulă
    }

    // Folosim MutationObserver pentru a detecta schimbările în celulele tabelului
    const observerConfig = { childList: true, subtree: true, characterData: true };

    const observerCallback = function(mutationsList, observer) {
        calculateTotals();
    };

    const observer = new MutationObserver(observerCallback);

    observer.observe(document.getElementById('bifate-list'), observerConfig);

    // Calcul totaluri și localități la inițializare
    calculateTotals();
});
