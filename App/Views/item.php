<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            margin: 4%;
        }
        .image-container {
            flex: 1 1 35%;
            box-sizing: border-box;
        }
        .text-container {
            flex: 3 1 65%;
            box-sizing: border-box;
        }
        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 20px;
        }
        .thumbnail-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .thumbnail-container img {
            width: 60px;
            height: 60px;
            margin: 0 5px;
            cursor: pointer;
            border-radius: 10px;
            border: 2px solid transparent;
        }
        .thumbnail-container img:hover {
            border-color: #000;
        }
        .text-container {
            padding: 0px 20px;
            text-align: justify;
        }
        @media (max-width: 768px) {
            .image-container, .text-container {
                flex: 1 1 100%;
            }
        }

        .itemname {
            text-align: center;
            margin: 40px 0;
        }

        .priceline {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .trademark {
            font-size: 12px;
            color: #888;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="itemname">
        <h1><?php echo $ItemData['name']; ?></h1>
    </div>
    <div class="container">
        <div class="image-container">
            <img id="mainImage" src="<?php echo $getItemImages[0]['image']; ?>" alt="Image">
            <?php if (count($getItemImages) > 1): ?>
                <div class="thumbnail-container">
                    <?php foreach ($getItemImages as $image): ?>
                        <img src="<?php echo $image['image']; ?>" alt="Thumbnail" onclick="changeImage('<?php echo $image['image']; ?>')">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="text-container">
            <p><?php echo $ItemData['long_dis']; ?></p>
            <h4>Contents</h4>
            <p><?php echo $ItemData['content']; ?></p>
            <h4>Benefits</h4>
            <p><?php echo $ItemData['benefits']; ?></p>
            <div class="priceline">
                <h4>Price</h4>
                <p>Rs.<?php echo $ItemData['price']; ?></p>
            </div>
            <?php if (!empty($ItemData['trademark'])): ?>
                <p class="trademark"><?php echo $ItemData['trademark']; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function changeImage(imageSrc) {
            document.getElementById('mainImage').src = imageSrc;
        }
    </script>
</body>
</html>
