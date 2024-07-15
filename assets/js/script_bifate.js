function reloadPage() {
    location.reload();
}

setInterval(reloadPage, 30000); // Reîncarcă la fiecare 30 de secunde

function submitForm() {
    document.getElementById('filterForm').submit();
}

document.addEventListener('DOMContentLoaded', function () {
    // Restaurarea filtrelor din localStorage
    var values = JSON.parse(localStorage.getItem('oficiuFilters') || '[]');
    values.forEach(function (value) {
        var checkbox = document.querySelector('input[name="oficiu[]"][value="' + value + '"]');
        if (checkbox) {
            checkbox.checked = true;
        }
    });

    // Adăugarea evenimentului pentru checkbox-uri
    var checkboxes = document.querySelectorAll('input[name="oficiu[]"]');
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var values = [];
            checkboxes.forEach(function (cb) {
                if (cb.checked) {
                    values.push(cb.value);
                }
            });
            localStorage.setItem('oficiuFilters', JSON.stringify(values));
            submitForm();
        });
    });
});