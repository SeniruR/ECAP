<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <script src="./js/index.js" defer></script>
</head>
<body>
    <main class="listall-main">
    <div class="topic">
        <h3>Our Products</h3>
        <div>
            <select id="productTypeFilter">
                <option value="">All</option>
                <?php foreach ($ItemData as $data): ?>
                    <option value="<?php echo $data['type']; ?>"><?php echo $data['type']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="card-container-wrapper">
        <div class="card-container" id="card-container">
            <?php if (!empty($ItemData)): ?>
                <?php foreach ($ItemData as $data): ?>
                    <a href="event.php?no=<?php echo $data['no']; ?>" data-type="<?php echo $data['type']; ?>">
                        <div class="card">
                            <img src="<?php echo $data['image']?>" alt="Event Image">
                            <div class="card-details">
                                <h2><?php echo $data['name']; ?></h2>
                                <hr>
                                <p><?php echo $data['short_dis']; ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No results found.</p>
            <?php endif; ?>
        </div>
    </div>
    </main>
</body>
</html>
