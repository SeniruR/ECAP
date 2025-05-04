<?php include_once __DIR__ . '/dash.php'; ?>
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
        display: flex;
        gap: 10px;
    }
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 20px 0;
        font-size: 16px;
        text-align: left;
        border: 1px solid #ddd; 
        border-radius: 10px;
        overflow: hidden; 
    }

    table thead tr {
        background-color: #f2f2f2;
        color: #333;
    }

    table th, table td {
        padding: 12px 15px;
        border: 1px solid #ddd;
    }

    tr td{
        text-align: justify;
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
    tr {
        text-align: center;
    }
    
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 8px;
    }
    .btn0, .btn1, .btn2, .btn {
        display: inline-block;
        padding: 8px 12px;
        font-size: 14px;
        color: #fff;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn0:hover, .btn1:hover, .btn2:hover, .btn:hover {
        text-decoration: none;
    }

    .btn0 {
        background-color: #007bff;
    }

    .btn1 {
        background-color: rgba(46, 125, 50, 1);
    }

    .btn2 {
        background-color: rgba(255, 193, 7, 1);
    }

    .btn1:hover {
        background-color: rgba(46, 125, 50, 0.8);
    }

    .btn2:hover {
        background-color: rgba(255, 193, 7, 0.8);
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: rgb(255, 53, 73);
    }
    .removebtn {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<main>
    <div class="topic">
        <h2>Category List</h2>
        <div class="topic-discription">
            <p>List of all categories available in the system.</p>
            <div class="controls">
                <input type="text" id="searchInput" placeholder="Search by name..." onkeyup="filterTable()">
                <a href="adm_types" class="dash-btn">Add Types</a>
            </div>
        </div>
    </div>
    <div class="table-container">
        <?php if (!empty($itemtypes)): ?>
            <table id="itemTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Short Description</th>
                        <th>Description</th>
                        <th>Actions</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itemtypes as $type): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($type['name']); ?></td>
                            <td><?php echo htmlspecialchars($type['short_discription']); ?></td>
                            <td><?php echo htmlspecialchars($type['discription']); ?></td>
                            <td>
                            <div class="action-buttons">
                                <a href="adm_types?no=<?php echo $type['no']; ?>" class="btn0">Edit</a>
                                <br>
                                <?php if($type['inactive_status']==0):?>
                                    <a href="adm_changecatstatus?status=0&no=<?php echo $type['no']; ?>" class="btn1">Enabled</a>
                                <?php else: ?>
                                    <a href="adm_changecatstatus?status=1&no=<?php echo $type['no']; ?>" class="btn2">Disabled</a>
                                <?php endif;?>
                            </div>
                            </td>
                            <td>
                                <div class="removebtn">
                                    <a href="adm_remove_type?no=<?php echo $type['no']; ?>" class="btn btn-danger">X</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No categories found.</p>
        <?php endif; ?>
    </div>
</main>

<script>
    function filterTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const table = document.getElementById('itemTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByTagName('td')[0];

            if (nameCell) {
                const nameText = nameCell.textContent.toLowerCase();

                if (nameText.includes(searchInput) || searchInput === '') {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }
</script>
