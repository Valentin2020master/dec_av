document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('add-record-form');
    const message = document.getElementById('message');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(form);

        try {
            const response = await fetch('../functions/add.php', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();
            console.log('Raw response:', text);

            const result = JSON.parse(text);
            if (result.success) {
                message.textContent = 'Înregistrarea a fost adăugată cu succes.';
                form.reset();
            } else {
                message.textContent = 'Eroare la adăugarea înregistrării: ' + (result.error || '');
            }
        } catch (error) {
            console.error('Error:', error);
            message.textContent = 'A apărut o eroare.';
        }
    });
});
