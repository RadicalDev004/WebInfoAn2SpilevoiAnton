<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <button type="button" onclick="window.location.href='/auth/status'" class="header-button back-button">←</button>
    <title>{{title}}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { margin-bottom: 10px; }
        select { padding: 6px 12px; margin-top: 10px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>{{title}}</h1>
     {{add_entry_panel}}

    <label for="table">Select a table:</label>
    <select id="table-select">
        {{table_options}}
    </select>

    <script>
        document.getElementById('table-select').addEventListener('change', function () {
            const table = this.value;
            if (table) {
                window.location.href = '/admin/index/' + encodeURIComponent(table);
            }
        });
        
        function submitNewEntry(form) {
        const formData = new FormData(form);
        const entry = {};
        formData.forEach((val, key) => entry[key] = val);

        fetch('/api/addentry.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                table: document.getElementById('table-select').value,
                entry: entry
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'ok') {
                alert('Entry added!');
                location.reload();
            } else {
                alert(data.error || 'Error');
            }
        });

            return false;
        }

        function deleteEntry(button) {
    const row = button.closest('tr');
    const id = row.querySelector('td').textContent.trim(); // assuming first cell is ID

    fetch('/api/deleteentry.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            table: document.getElementById('table-select').value,
            id: id
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            alert('Entry deleted!');
            location.reload();
        } else {
            alert(data.error || 'Error');
        }
    });

    return false;
}
    </script>

    {{table_content}}
    
   
</body>
</html>
