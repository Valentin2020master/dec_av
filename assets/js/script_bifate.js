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


/////// Functia pentru cautare

function searchTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("dataTable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j]) {
                if (cells[j].innerText.toUpperCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
        }

        if (match) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}
