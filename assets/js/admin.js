document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.save-btn').forEach(button => {
        button.addEventListener('click', event => {
            const table = button.dataset.table;
            const id = button.dataset.id;
            const row = button.closest('tr');
            const data = {};

            row.querySelectorAll('td[contenteditable="true"]').forEach(td => {
                data[td.dataset.key] = td.textContent;
            });

            fetch('../functions/update_table_data.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ table, id, data })
            }).then(response => {
                return response.json().then(json => ({ status: response.status, body: json }));
            }).then(({ status, body }) => {
                if (status === 200) {
                    alert('Datele au fost salvate cu succes!');
                } else {
                    alert('Eroare la salvarea datelor: ' + body.error);
                }
            }).catch(error => console.error('Fetch error:', error));
        });
    });
});
