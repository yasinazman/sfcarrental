document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('adminLiveSearch');
    const tableBody = document.getElementById('adminsTableBody');

    if (searchInput && tableBody) {
        searchInput.addEventListener('keyup', function() {
            const filterValue = this.value.toLowerCase();
            const rows = tableBody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                if (rows[i].querySelector('.no-data-text')) continue;

                const nameCol = rows[i].getElementsByTagName('td')[0]; 
                if (nameCol) {
                    const textValue = nameCol.textContent || nameCol.innerText;
                    if (textValue.toLowerCase().indexOf(filterValue) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }       
            }
        });
    }
});