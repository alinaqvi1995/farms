<?php

namespace Tests\Feature;

use App\Models\Farm;
use App\Models\GlobalSetting;
use App\Models\MilkSale;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MilkSaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_vendor_shared_across_farms_if_exists()
    {
        $farm1 = Farm::create(['name' => 'Farm 1']);
        $farm2 = Farm::create(['name' => 'Farm 2']);

        // Farm 1 adds a vendor
        $vendorData = [
            'name' => 'John Doe',
            'phone' => '555-1234',
            'address' => '123 Lane',
        ];

        // Simulate logic to find or create
        $vendor1 = Vendor::firstOrCreate(
            ['phone' => $vendorData['phone']],
            ['name' => $vendorData['name'], 'address' => $vendorData['address']]
        );
        $farm1->vendors()->syncWithoutDetaching($vendor1);

        $this->assertDatabaseHas('vendors', ['phone' => '555-1234']);
        $this->assertDatabaseHas('farm_vendor', ['farm_id' => $farm1->id, 'vendor_id' => $vendor1->id]);

        // Farm 2 adds SAME vendor
        $vendor2 = Vendor::where('phone', $vendorData['phone'])->where('name', $vendorData['name'])->first();
        if ($vendor2) {
            $farm2->vendors()->syncWithoutDetaching($vendor2);
        } else {
            $vendor2 = Vendor::create($vendorData);
            $farm2->vendors()->attach($vendor2);
        }

        $this->assertEquals($vendor1->id, $vendor2->id);
        $this->assertDatabaseCount('vendors', 1);
        $this->assertDatabaseHas('farm_vendor', ['farm_id' => $farm2->id, 'vendor_id' => $vendor1->id]);
    }

    public function test_milk_sale_uses_admin_price()
    {
        $farm = Farm::create(['name' => 'Farm Test']);
        $vendor = Vendor::create(['name' => 'V1', 'phone' => '111']);
        $farm->vendors()->attach($vendor);

        GlobalSetting::create(['key' => 'milk_default_price', 'value' => '100']);

        $quantity = 10;
        $price = GlobalSetting::where('key', 'milk_default_price')->value('value');

        $sale = MilkSale::create([
            'farm_id' => $farm->id,
            'vendor_id' => $vendor->id,
            'quantity' => $quantity,
            'price_type' => 'admin',
            'price_per_unit' => $price,
            'total_amount' => $quantity * $price,
            'sold_at' => now(),
        ]);

        $this->assertDatabaseHas('milk_sales', [
            'price_type' => 'admin',
            'price_per_unit' => 100,
            'total_amount' => 1000,
        ]);
    }

    public function test_milk_sale_uses_custom_price()
    {
        $farm = Farm::create(['name' => 'Farm Test 2']);
        $vendor = Vendor::create(['name' => 'V1', 'phone' => '111']);
        $farm->vendors()->attach($vendor);

        $quantity = 10;
        $customPrice = 120;

        $sale = MilkSale::create([
            'farm_id' => $farm->id,
            'vendor_id' => $vendor->id,
            'quantity' => $quantity,
            'price_type' => 'custom',
            'price_per_unit' => $customPrice,
            'total_amount' => $quantity * $customPrice,
            'sold_at' => now(),
        ]);

        $this->assertDatabaseHas('milk_sales', [
            'price_type' => 'custom',
            'price_per_unit' => 120,
            'total_amount' => 1200,
        ]);
    }
}
