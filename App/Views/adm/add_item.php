<?php include_once __DIR__ . '/dash.php'; ?>
<link rel=stylesheet type="text/css" href="./css/adm/add_item.css">
<main>
    <div class="main_box">
        <div class="rightside">
        <div>
        <h2><?php if($update==false){echo "Add";}else{echo "Edit";};?> Item</h2>
        <p><?php if($update==false){echo "Add";}else{echo "Modify";};?> the details below to update the item.</p>
        <?php if (isset($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        </div>
        <form action="index.php?url=process_add_item" method="post" enctype="multipart/form-data">
            <input type="hidden" name="no" value="<?php echo isset($itemData['no']) ? htmlspecialchars($itemData['no']) : ''; ?>">
            <table class="table">
            <tr>
                <td class="label-cell"><label for="item_name">Item Name</label></td>
                <td class="input-cell"><input type="text" id="item_name" name="item_name" value="<?php echo isset($itemData['name']) ? htmlspecialchars($itemData['name']) : ''; ?>" required></td>
            </tr>
            <tr>
                <td class="label-cell"><label for="item_short_description">Short Description</label></td>
                <td class="input-cell"><textarea id="item_short_description" name="item_short_description" rows="2" class="myTextarea" required><?php echo isset($itemData['short_dis']) ? htmlspecialchars($itemData['short_dis']) : ''; ?></textarea></td>
            </tr>
            <tr>
                <td class="label-cell"><label for="item_long_description">Description</label></td>
                <td class="input-cell"><textarea id="item_long_description" name="item_long_description" rows="4" class="myTextarea" required><?php echo isset($itemData['long_dis']) ? htmlspecialchars($itemData['long_dis']) : ''; ?></textarea></td>
            </tr>
            <tr>
                <td class="label-cell"><label for="item_type">Item Type</label></td>
                <td class="input-cell">
                <select id="item_type" name="item_type" required>
                    <option value="">Select item type</option>
                    <?php if (isset($typeList)): ?>
                    <?php foreach ($typeList as $type): ?>
                    <option value="<?php echo $type['no']; ?>" <?php echo isset($itemData['itno']) && $type['no'] == $itemData['itno'] ? 'selected' : ''; ?>>
                        <?php echo $type['name']; ?>
                    </option>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </select> 
                </td>
            </tr>
            <tr>
                <td class="label-cell"><label for="item_contents">Contents</label></td>
                <td class="input-cell"><textarea id="item_contents" name="item_contents" rows="3" class="myTextarea" required><?php echo isset($itemData['content']) ? htmlspecialchars($itemData['content']) : ''; ?></textarea></td>
            </tr>
            <tr>
                <td class="label-cell"><label for="item_benefits">Benefits</label></td>
                <td class="input-cell"><textarea id="item_benefits" name="item_benefits" rows="3" class="myTextarea" required><?php echo isset($itemData['benefits']) ? htmlspecialchars($itemData['benefits']) : ''; ?></textarea></td>
            </tr>
            <tr>
                <td class="label-cell"><label for="item_trademark">Trademark</label></td>
                <td class="input-cell"><input type="text" id="item_trademark" name="item_trademark" value="<?php echo isset($itemData['trademark']) ? htmlspecialchars($itemData['trademark']) : ''; ?>"></td>
            </tr>
            <tr>
                <td colspan=2>
                <div class="trademark">
                    Gemini™ is a product of Google LLC. (If it's an unregistered trademark) <br>
                    Gemini® is a registered trademark of Google LLC. (If it's officially registered)
                </div>
                </td>
            </tr>
            <tr>
                <td class="label-cell"><label for="item_price">Price</label></td>
                <td class="input-cell"><input type="number" id="item_price" name="item_price" step="0.01" value="<?php echo isset($itemData['price']) ? htmlspecialchars($itemData['price']) : ''; ?>" required></td>
            </tr>
            <tr>
                <td class="label-cell"><label for="item_image">Item Image</label></td>
                <td class="input-cell">
                <input type="file" id="item_image" name="item_image[]" accept="image/*" multiple>
                <div id="image_preview" style="margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                    <?php if (isset($itemData['images']) && !empty($itemData['images'])): ?>
                    <?php foreach ($itemData['images'] as $image): ?>
                        <img src="<?php echo is_string($image['image']) ? htmlspecialchars($image['image']) : ''; ?>" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ccc; border-radius: 5px;">
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                </td>
            </tr>
            <tr class="formbutton">
                <td colspan="2">
                    <div style="text-align: center;">
                        <?php if ($update==false): ?>
                            <button type="submit" name="submit" style="margin-right: 10px;">Add Item</button>
                        <?php else: ?>
                            <button type="submit" name="update" style="margin-right: 10px;">Update Item</button>
                        <?php endif; ?>
                        <button type="reset">Clear Form</button>
                    </div>
                </td>
            </tr>
            </table>
        </form>
        </div>
    </div>
    </div>
</main>
<script>
    const dataTransfer = new DataTransfer();

    document.getElementById('item_image').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('image_preview');
        previewContainer.innerHTML = '';
        const files = event.target.files;

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.src = e.target.result;
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    const size = Math.min(img.width, img.height);

                    canvas.width = 1200;
                    canvas.height = 1200;

                    ctx.drawImage(img, (img.width - size) / 2, (img.height - size) / 2, size, size, 0, 0, canvas.width, canvas.height);

                    canvas.toBlob(function(blob) {
                        const croppedFile = new File([blob], file.name, { type: file.type });
                        dataTransfer.items.add(croppedFile);
                        document.getElementById('item_image').files = dataTransfer.files;

                        const previewImg = document.createElement('img');
                        previewImg.src = URL.createObjectURL(blob);
                        previewImg.style.width = '100px';
                        previewImg.style.height = '100px';
                        previewImg.style.objectFit = 'cover';
                        previewImg.style.border = '1px solid #ccc';
                        previewImg.style.borderRadius = '5px';
                        previewContainer.appendChild(previewImg);
                    }, file.type);
                };
            };
            reader.readAsDataURL(file);
        });
    });
</script>
