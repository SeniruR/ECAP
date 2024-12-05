<html>
    <header>
        <link rel="stylesheet" type="text/css" href="./css/index.css">
        <title>ECAP</title>
        <script src="./js/index.js" defer></script>
    </header>
    <body>
        <!-- <div class="notice">
            Attention: This page is currently under maintanence. So if you found a mistakes, please reach out to inform us.
        </div> -->
        <div class="banner">
            <img src="./images/index/index_banner.png">
            <div class="banner-text"><h4>Welcome to ECAP</h4><h6>Discover our exceptional collection of eco-friendly products designed to make a positive impact on the environment.</h6></div>
        </div>
        <div class="topic">
            <h3>Our Products</h3>
        </div>
        <div class="card-container-wrapper">
        <div class="card-container">
        <?php if (!empty($ItemData)): ?>
            <?php foreach ($ItemData as $data): ?>
                <a href="event.php?no=<?php echo $data['no']; ?>">
                    <div class="card">
                        <img src="<?php echo $data['image']?>">
                        <div class="card-details">
                        <h2><?php echo $data['name']; ?></h2>
                        <hr>
                        <p><?php echo $data['short_dis']; ?></p>
                        <p>
                            Time: <?php echo $data['price']; ?>
                        </p>
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