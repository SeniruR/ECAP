<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECAP</title>
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <script src="./js/index.js" defer></script>
</head>
<body>
    <div class="notice">
        Attention: This page is currently under maintenance. If you find any mistakes, please reach out to inform us.
    </div>
    <div class="banner">
        <img src="./images/index/index_banner.png" alt="Banner Image">
        <div class="banner-text">
            <h4>Welcome to ECAP</h4>
            <h6>Discover our exceptional collection of eco-friendly products designed to make a positive impact on the environment.</h6>
        </div>
    </div>
    <div class="topic">
        <h3>Our Products</h3>
        <a href="#" class="all-btn">Show all</a>
    </div>
    <div class="card-container-wrapper">
        <div class="card-container" id="card-container">
            <?php if (!empty($ItemData)): ?>
                <?php foreach ($ItemData as $data): ?>
                    <a href="event.php?no=<?php echo $data['no']; ?>">
                        <div class="card">
                            <img src="<?php echo $data['image']?>" alt="Event Image">
                            <div class="card-details">
                                <h2><?php echo $data['name']; ?></h2>
                                <hr>
                                <p><?php echo $data['short_dis']; ?></p>
                                <p>Price: <?php echo $data['price']; ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No results found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
