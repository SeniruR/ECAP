<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="./css/listall.css">
    <script src="./js/index.js" defer></script>
</head>
<body>
    <main class="listall-main">
    <div class="topic">
        <h2><?php echo $typeData['0']['name'];?></h2>
        <div class="topic-discription">
            <p><?php echo $typeData['0']['discription'];?></p>
        </div>
    </div>
    <div class="card-container-wrapper">
        <div class="card-container" id="card-container">
            <?php if (!empty($ItemData)): ?>
                <?php foreach ($ItemData as $data): ?>
                    <a href="item?no=<?php echo $data['no']; ?>" data-type="<?php echo $data['type']; ?>">
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
