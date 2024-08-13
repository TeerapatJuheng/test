<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store List</title>
</head>
<body>
    <h1>Registered Stores</h1>
    <div id="store-list"></div>

    <script>
        fetch('store_list.php')
        .then(response => response.json())
        .then(data => {
            const storeList = document.getElementById('store-list');
            data.forEach(store => {
                const storeDiv = document.createElement('div');
                storeDiv.innerHTML = `<strong>${store.store_name}</strong><br>
                                      Email: ${store.store_email}<br>
                                      Phone: ${store.store_phone}<br>
                                      Address: ${store.store_address}<br><hr>`;
                storeList.appendChild(storeDiv);
            });
        });
    </script>
</body>
</html>
