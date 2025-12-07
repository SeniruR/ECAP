<?php include_once __DIR__ . '/dash.php'; ?>
<link rel=stylesheet type="text/css" href="/css/adm/add_item.css">
<main>
    <div class="main_box">
        <div class="rightside">
        <div>
        <h2><?php if($update==false){echo "Add";}else{echo "Edit";};?> Category</h2>
        <p><?php if($update==false){echo "Add";}else{echo "Edit";};?> the details below to <?php if($update==false){echo "Add New";}else{echo "Edit the";};?> category.</p>
        <?php if (isset($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        </div>
        <form action="index.php?url=process_add_type" method="post" enctype="multipart/form-data">
            <input type="hidden" name="no" value="<?php echo isset($categoryData['no']) ? htmlspecialchars($categoryData['no']) : ''; ?>">
            <table class="table">
            <tr>
                <td class="label-cell"><label for="category_name">Category Name</label></td>
                <td class="input-cell"><input type="text" id="name" name="name" value="<?php echo isset($categoryData['name']) ? htmlspecialchars($categoryData['name']) : ''; ?>" required></td>
            </tr>
            <tr>
                <td class="label-cell"><label for="category_short_description">Short Description</label></td>
                <td class="input-cell"><textarea id="short_description" name="short_description" rows="2" class="myTextarea" required><?php echo isset($categoryData['short_discription']) ? htmlspecialchars($categoryData['short_discription']) : ''; ?></textarea></td>
            </tr>
            <tr>
                <td class="label-cell"><label for="category_description">Description</label></td>
                <td class="input-cell"><textarea id="description" name="description" rows="4" class="myTextarea" required><?php echo isset($categoryData['discription']) ? htmlspecialchars($categoryData['discription']) : ''; ?></textarea></td>
            </tr>
            <tr class="formbutton">
                <td colspan="2">
                    <div style="text-align: center;">
                        <?php if ($update==false): ?>
                            <button type="submit" name="submit" style="margin-right: 10px;">Add Category</button>
                            <button type="reset">Clear Form</button>
                        <?php else: ?>
                            <button type="submit" name="update" style="margin-right: 10px;">Update Category</button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            </table>
        </form>
        </div>
    </div>
    </div>
</main>
