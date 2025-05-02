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
    <main>
    <div class="notice">
        Attention: This page is currently under maintenance. If you find any mistakes, please reach out to inform us.
    </div>
    <div class="banner">
        <img src="./images/index/index_banner.png" alt="Banner Image">
        <!-- <div class="banner-text">
            <h3>Welcome to ECAP</h3>
            <h5>Discover our exceptional collection of eco-friendly products designed to make a positive impact on the environment.</h5>
        </div> -->
    </div>
    <div class="intro">
        <p>ECAP is dedicated to promoting sustainable living through a diverse range of eco-friendly products. Our mission is to make a positive impact on the environment by offering innovative solutions that help reduce waste and conserve resources. Join us in our journey towards a greener future and discover how you can contribute to a healthier planet.</p>
    </div>
    <?php 
    $countermain = 0; 
    if (!empty($Itemtypes)): ?>
        <?php foreach ($Itemtypes as $type): ?>
            <?php if($countermain>0):?><hr><?php endif;?>
            <div class="topic">
                <h3><a href="Listall?type=<?php echo $type['no']; ?>" ><?php echo $type['name']; ?></a></h3>
                <div class="arrow-btns">
                    <button class="scroll-btn left" onclick="scrollLeft('card-container-<?php echo $type['no']; ?>')">&lt;</button>
                    <button class="scroll-btn right" onclick="scrollRight('card-container-<?php echo $type['no']; ?>')">&gt;</button>
                    <a href="Listall?type=<?php echo $type['no']; ?>" class="all-btn">Show all</a>
                </div>
            </div>
            <div class="card-container-wrapper">
                <div class="card-container" id="card-container-<?php echo $type['no']; ?>">
                    <?php $counter = 0; ?>
                    <?php if (!empty($ItemData)): ?>
                        <?php foreach ($ItemData as $data): ?>
                            <?php if ($data['type'] == $type['no'] && $counter < 8): ?>
                            <a href="item?no=<?php echo $data['no']; ?>">
                                <div class="card">
                                    <?php if (strtotime($data['created']) > time()): ?>
                                        <div class="newcard">
                                            <p>New</p>
                                        </div>
                                    <?php endif; ?>
                                    <img src="<?php echo $data['image']; ?>" alt="Event Image">
                                    <div class="card-details">
                                        <p><?php echo $data['name']; ?></p>
                                        <hr>
                                        <p><?php echo $data['short_dis']; ?></p>
                                        <p>Rs. <?php echo $data['price']; ?></p>
                                    </div>
                                </div>
                            </a>
                            <?php $counter++; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No results found.</p>
                    <?php endif; ?>
                </div>
                
            </div>
            <div class="line"></div>
            <?php $countermain++; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>
    </main>
</body>