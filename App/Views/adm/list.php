<?php include_once __DIR__ . '/dash.php'; ?>
<main>
    <div class="topic">
        <h2>Item List</h2> 
        <div class="topic-discription">
            <p>List of all items available in the system.</p>
            <div class="controls">
                <input type="text" id="searchInput" placeholder="Search by name..." onkeyup="filterTable()">
                <select id="typeFilter" onchange="filterTable()">
                    <option value="">All Types</option>
                    <?php foreach ($itemtypes as $type): ?>
                        <option value="<?php echo $type['name']; ?>"><?php echo $type['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <a href="adm_add" class="dash-btn">Add Item</a>
            </div>
        </div>
    </div>
    <div class="table-container">
        
            <style>
                h2 {
                    margin: 20px 0 10px 0;
                }
                .topic-discription {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
                .controls {
                    margin: 20px 0;
                    display: flex;
                    gap: 10px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                    font-size: 16px;
                    text-align: left;
                }
                table thead tr {
                    background-color: #f2f2f2;
                    color: #333;
                }
                table th, table td {
                    padding: 12px 15px;
                    border: 1px solid #ddd;
                }
                table tbody tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                table tbody tr:hover {
                    background-color: #f1f1f1;
                }
                .Itemimg img {
                    border-radius: 5px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                a {
                    color: #007bff;
                    text-decoration: none;
                }
                a:hover {
                    text-decoration: underline;
                }

                .controls input[type="text"], .controls select {
                    padding: 10px;
                    font-size: 16px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    outline: none;
                    width: 200px;
                    transition: border-color 0.3s ease;
                }

                .controls input[type="text"]:focus, .controls select:focus {
                    border-color: #007bff;
                }

                .controls select {
                    width: auto;
                    cursor: pointer;
                }

                .controls input[type="text"]::placeholder {
                    color: #aaa;
                }
            </style>
            <?php if (!empty($admitemData)): ?>
            <table id="itemTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admitemData as $data): ?>
                        <tr>
                            <td class="Itemimg"><a href="item?no=<?php echo $data['no']; ?>"><img src="<?php echo $data['image']; ?>" alt="Item Image" style="width: 100px; height: auto;"></a></td>
                            <td class="itemName"><?php echo $data['name']; ?></td>
                            <td class="itemType"><?php echo $data['typename']; ?></td>
                            <td><a href="adm_add?no=<?php echo $data['no']; ?>">Edit</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No results found.</p>
        <?php endif; ?>
    </div>
</main>

<script>
    function filterTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const typeFilter = document.getElementById('typeFilter').value.toLowerCase();
        const table = document.getElementById('itemTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByClassName('itemName')[0];
            const typeCell = rows[i].getElementsByClassName('itemType')[0];

            if (nameCell && typeCell) {
                const nameText = nameCell.textContent.toLowerCase();
                const typeText = typeCell.textContent.toLowerCase();

                if (
                    (nameText.includes(searchInput) || searchInput === '') &&
                    (typeText === typeFilter || typeFilter === '')
                ) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }
</script>