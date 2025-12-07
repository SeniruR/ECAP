<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\ItemImage;
use App\Models\ItemType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $type = ItemType::factory()->create();
        Item::factory()->has(ItemImage::factory())->create(['type' => $type->no]);

        $this->get('/')
            ->assertOk()
            ->assertSee($type->name);
    }

    public function test_listall_page_loads(): void
    {
        $type = ItemType::factory()->create();
        Item::factory()->has(ItemImage::factory())->create(['type' => $type->no]);

        $this->get('/listall?type='.$type->no)
            ->assertOk()
            ->assertSee($type->name);
    }

    public function test_item_detail_page_loads(): void
    {
        $type = ItemType::factory()->create();
        $item = Item::factory()->has(ItemImage::factory())->create(['type' => $type->no]);

        $this->get('/item/'.$item->no)
            ->assertOk()
            ->assertSee($item->name);
    }
}
