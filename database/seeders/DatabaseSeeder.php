<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Owner;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        \App\Models\User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        foreach (['Gudang 1', 'Gudang 2'] as $warehouse) {
            Warehouse::create([
                'name' => $warehouse,
                'type' => Warehouse::TYPE_WAREHOUSE,
            ]);
        }

        Warehouse::create([
            'name' => 'Bengkulangan',
            'type' => Warehouse::TYPE_BENGKULANGAN,
        ]);

        foreach (['Edo', 'Yusi'] as $name) {
            Owner::create([
                'name' => $name,
            ]);
        }
    }
}
