<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ItemType;

$types = ItemType::all()->map(function($t){ return ['no'=>$t->no,'name'=>$t->name,'inactive_status'=> (int)$t->inactive_status];});
echo json_encode($types->toArray(), JSON_PRETTY_PRINT);
