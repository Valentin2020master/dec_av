document.addEventListener('DOMContentLoaded', () => {
    // Obține referințe la elementele din DOM
    const deselecteazaButon = document.getElementById('deselecteaza-toate');
    const principalList = document.getElementById('principal-list');
    const bifateList = document.getElementById('bifate-list');
    const BATCH_SIZE = 10; // Loturi de 10 checkbox-uri

    // Adaugă eveniment pentru butonul "deselectează toate"
    deselecteazaButon.addEventListener('click', () => {
        // Obține toate checkbox-urile principale
        const checkboxuriPrincipale = Array.from(principalList.querySelectorAll('input[type="checkbox"]'));
        // Procesează checkbox-urile în loturi, debifându-le
        processCheckboxesInBatches(checkboxuriPrincipale, false);
    });

    // Adaugă eveniment pentru schimbările din lista principală de checkbox-uri
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
            }, index * 100);
        });
    }

    // Funcție pentru a gestiona schimbarea unui checkbox
    function handleCheckboxChange(checkbox) {
        // Obține toate sub-checkbox-urile dacă există
        const subCheckboxes = checkbox.closest('li, details')?.querySelectorAll('ul input[type="checkbox"]') || [];

        // Actualizează starea fiecărui sub-checkbox
        subCheckboxes.forEach(subCheckbox => {
            subCheckbox.checked = checkbox.checked;
            updateCheckboxState(subCheckbox);
        });

        // Adaugă sau elimină elemente din lista bifate, și actualizează starea checkbox-ului
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
        if (!Array.from(bifateList.children).some(item => item.textContent === element.nextElementSibling.textContent)) {
            const listItem = document.createElement('tr');
            listItem.setAttribute('id', 'row-' + element.dataset.pt);
            // Obține datele pentru elementul curent și le afișează în lista bifate
            fetchPTData(element.dataset.pt).then(data => {
                if (data && data.pt) {
                    listItem.innerHTML = `
                        <td>${data.oficiu}</td>
                        <td>${data.statiune}</td>
                        <td>${data.fider}</td>
                        <td>${data.pt}</td>
                        <td>${data.casnici}</td>
                        <td>${data.economici}</td>
                        <td>${data.localitatea}</td>
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
        const listItemToRemove = document.getElementById('row-' + element.dataset.pt);
        if (listItemToRemove) {
            listItemToRemove.remove();
        }
    }

    // Funcție pentru a obține datele pentru un anumit pt de la server
    async function fetchPTData(pt) {
        try {
            const response = await fetch('../functions/fetch_pt_data2.php', {
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
            const response = await fetch('../functions/update_checkbox_state2.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `pt=${encodeURIComponent(checkbox.dataset.pt)}&checked=${checkbox.checked ? 1 : 0}`
            });
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
        } catch (error) {
            console.error('Update state error:', error);
            // Retrimite cererea dacă a eșuat
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

    // Funcție pentru a obține elementele bifate inițial de la server
    async function fetchInitialCheckedItems() {
        try {
            const response = await fetch('../functions/get_checked_items2.php');
            if (response.ok) {
                const checkedItems = await response.json();
                // Procesează checkbox-urile inițial bifate în loturi
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
