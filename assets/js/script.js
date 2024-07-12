document.addEventListener('DOMContentLoaded', function () {
    const deselecteazaButon = document.getElementById('deselecteaza-toate');
    const principalList = document.getElementById('principal-list');
    const bifateList = document.getElementById('bifate-list');

    deselecteazaButon.addEventListener('click', function () {
        const checkboxuriPrincipale = principalList.querySelectorAll('input[type="checkbox"]');
        checkboxuriPrincipale.forEach(checkbox => {
            checkbox.checked = false;
            handleCheckboxChange(checkbox); // Debifează și elementele în bifate-list
            updateCheckboxState(checkbox); // Actualizează starea în baza de date
        });
    });

    principalList.addEventListener('change', function (event) {
        if (event.target.classList.contains('pt-checkbox')) {
            const checkbox = event.target;
            handleCheckboxChange(checkbox);
        }
    });

    function handleCheckboxChange(checkbox) {
        const subCheckboxes = checkbox.closest('li, details').querySelectorAll('ul input[type="checkbox"]');
        subCheckboxes.forEach(subCheckbox => {
            subCheckbox.checked = checkbox.checked;
            updateCheckboxState(subCheckbox); // Actualizează starea fiecărui sub-checkbox în baza de date
        });

        if (!checkbox.closest('li, details').querySelector('ul')) {
            if (checkbox.checked) {
                adaugaElementBifat(checkbox);
            } else {
                eliminaElementBifat(checkbox);
            }
            updateCheckboxState(checkbox); // Actualizează starea checkboxului părinte în baza de date
        } else {
            subCheckboxes.forEach(subCheckbox => {
                if (!subCheckbox.closest('li, details').querySelector('ul')) {
                    if (checkbox.checked) {
                        adaugaElementBifat(subCheckbox);
                    } else {
                        eliminaElementBifat(subCheckbox);
                    }
                }
            });
        }
    }

    function adaugaElementBifat(element) {
        const existent = Array.from(bifateList.children).find(item => item.textContent === element.nextElementSibling.textContent);
        if (!existent) {
            const listItem = document.createElement('tr');
            listItem.setAttribute('id', 'row-' + element.dataset.pt);
            fetchPTData(element.dataset.pt, function (data) {
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
            });
        }
    }

    function eliminaElementBifat(element) {
        const listItemToRemove = document.getElementById('row-' + element.dataset.pt);
        if (listItemToRemove) {
            listItemToRemove.remove();
        }
    }

    function fetchPTData(pt, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../functions/fetch_pt_data.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    callback(response);
                } else {
                    console.error('Error fetching data: ' + xhr.statusText);
                }
            }
        };
        xhr.send('pt=' + encodeURIComponent(pt));
    }

    function updateCheckboxState(checkbox) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../functions/update_checkbox_state.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status !== 200) {
                    console.error('Error updating checkbox state: ' + xhr.statusText);
                }
            }
        };
        xhr.send('pt=' + encodeURIComponent(checkbox.dataset.pt) + '&checked=' + (checkbox.checked ? 1 : 0));
    }

    // Afișează elementele bifate la încărcarea paginii
    fetchInitialCheckedItems();

    function fetchInitialCheckedItems() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../functions/get_checked_items.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    response.forEach(item => {
                        const checkbox = principalList.querySelector(`input[data-pt="${item}"]`);
                        if (checkbox) {
                            checkbox.checked = true;
                            adaugaElementBifat(checkbox);
                        }
                    });
                } else {
                    console.error('Error fetching initial checked items: ' + xhr.statusText);
                }
            }
        };
        xhr.send();
    }


});




///////////
