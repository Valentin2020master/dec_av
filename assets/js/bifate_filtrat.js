document.addEventListener('DOMContentLoaded', function () {
    function fetchBifateData() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../functions/bifate_filtrat_data.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            console.error('Eroare de la server: ' + response.error);
                            return;
                        }

                        const bifateList = document.getElementById('bifate-list-filtrat');
                        bifateList.innerHTML = ''; // Clear the list before adding new items

                        const addedPTs = new Set();
                        response.forEach(item => {
                            if (!addedPTs.has(item.pt)) {
                                addedPTs.add(item.pt);
                                const listItem = document.createElement('tr');
                                listItem.innerHTML = `
                                    <td>${item.oficiu}</td>
                                    <td>${item.statiune}</td>
                                    <td>${item.fider}</td>
                                    <td>${item.pt}</td>
                                    <td>${item.localitatea}</td>
                                    <td>${item.adresa}</td>
                                    <td>${item.apartenenta}</td>
                                `;
                                bifateList.appendChild(listItem);
                            }
                        });
                    } catch (error) {
                        console.error('Eroare la parsarea JSON: ' + error + "\nRăspuns: " + xhr.responseText);
                    }
                } else {
                    console.error('Eroare la preluarea datelor filtrate: ' + xhr.statusText);
                }
            }
        };
        xhr.send();
    }

    fetchBifateData();

    // Actualizează datele bifate la intervale regulate (opțional)
    setInterval(fetchBifateData, 5000); // la fiecare 5 secunde
});

