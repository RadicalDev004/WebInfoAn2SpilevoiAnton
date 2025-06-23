<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{title}}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { margin-bottom: 10px; }
        select { padding: 6px 12px; margin-top: 10px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }

        .header-container {
            display: flex;
            align-items: center;
        }
        .header-button {
            margin-right: 10px;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header-container">
        <button type="button" onclick="window.location.href='/auth/status'" class="header-button back-button">←</button>
        <h1>{{title}}</h1>
    </div>

    {{add_entry_panel}}

    <label for="table-select">Select a table:</label>
    <select id="table-select" name="table">
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
                credentials: 'include',
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
            const id = row.querySelector('td').textContent.trim();

            fetch('/api/deleteentry.php', {
                method: 'POST',
                credentials: 'include',
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
        function getCookie(cname) {
    console.log(document.cookie);
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
    </script>

    {{table_content}}
</body>
</html>
