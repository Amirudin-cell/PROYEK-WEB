function filterDosen() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    
    const table = document.getElementById('dosen-table');
    const tr = table.getElementsByTagName('tr');
    for (let i = 1; i < tr.length; i++) {
        const tds = tr[i].getElementsByTagName('td');
        let isMatch = false;
        for (let j = 0; j < tds.length; j++) {
            if (tds[j]) {
                const txtValue = tds[j].textContent || tds[j].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    isMatch = true;
                    break;
                }
            }
        }
        tr[i].style.display = isMatch ? "" : "none";
    }
}
