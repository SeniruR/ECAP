<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ItemType;
use App\Models\Item;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Http\Request;

// Create a test category
$cat = ItemType::create(['name' => 'tmp-cat-for-test','short_discription'=>'t','discription'=>'t','inactive_status'=>0]);
// Create an item linked to it
$item = Item::create(['name'=>'tmp-item','short_dis'=>'s','long_dis'=>'l','type'=>$cat->no,'price'=>0]);

echo "Created category {$cat->no} and item {$item->no}\n";

$ctrl = new CategoryController();
$response = $ctrl->destroy(new Request(), $cat->no);

$exists = ItemType::find($cat->no) ? 'yes' : 'no';

echo "After controller destroy, category exists? {$exists}\n";

// Cleanup: delete item
Item::find($item->no)->delete();
// Try delete again using controller
$response2 = $ctrl->destroy(new Request(), $cat->no);
$exists2 = ItemType::find($cat->no) ? 'yes' : 'no';

echo "After removing item and calling destroy again, category exists? {$exists2}\n";
