<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Status::factory()->create(['name' => 'Processing']);
        // Status::factory()->create(['name' => 'Shipped']);
        // Status::factory()->create(['name' => 'Delivered']);
        // Status::factory()->create(['name' => 'Cancelled']);

        Order::factory(20)->create();
    }
}
