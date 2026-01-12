<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class WatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $watches = [
            [
                'brand' => 'Rolex',
                'model' => 'Submariner',
                'product_code' => 'RX-SUB-1001',
                'diameter' => '41mm',
                'type' => 'men',
                'material' => 'steel',
                'strap' => 'steel',
                'water_resistance' => '300m',
                'caliber' => 'Rolex 3235',
                'price' => 12500,
                'quantity' => 5,
                'image' => 'products/rolex_submariner.jpg', 
            ],
            [
                'brand' => 'Omega',
                'model' => 'Seamaster Diver',
                'product_code' => 'OM-SMD-1002',
                'diameter' => '42mm',
                'type' => 'men',
                'material' => 'steel',
                'strap' => 'steel',
                'water_resistance' => '300m',
                'caliber' => 'Omega 8800',
                'price' => 9800,
                'quantity' => 8,
                'image' => 'products/rolex_submariner.jpg', 
            ],
            [
                'brand' => 'Tag Heuer',
                'model' => 'Carrera',
                'product_code' => 'TH-CAR-1003',
                'diameter' => '40mm',
                'type' => 'men',
                'material' => 'steel',
                'strap' => 'leather',
                'water_resistance' => '100m',
                'caliber' => 'Heuer 02',
                'price' => 7200,
                'quantity' => 10,
                'image' => 'products/rolex_submariner.jpg', 
            ],
            [
                'brand' => 'Tissot',
                'model' => 'PRX',
                'product_code' => 'TS-PRX-1004',
                'diameter' => '40mm',
                'type' => 'men',
                'material' => 'steel',
                'strap' => 'steel',
                'water_resistance' => '100m',
                'caliber' => 'Powermatic 80',
                'price' => 650,
                'quantity' => 15,
                'image' => 'products/rolex_submariner.jpg', 
            ],
            [
                'brand' => 'Casio',
                'model' => 'G-Shock GA2100',
                'product_code' => 'CS-GS-1005',
                'diameter' => '45mm',
                'type' => 'men',
                'material' => 'plastic',
                'strap' => 'leather',
                'water_resistance' => '200m',
                'caliber' => 'Quartz',
                'price' => 150,
                'quantity' => 20,
                'image' => 'products/rolex_submariner.jpg', 
            ],
            [
                'brand' => 'Michael Kors',
                'model' => 'Parker',
                'product_code' => 'MK-PAR-1006',
                'diameter' => '39mm',
                'type' => 'women',
                'material' => 'steel',
                'strap' => 'steel',
                'water_resistance' => '50m',
                'caliber' => 'Quartz',
                'price' => 280,
                'quantity' => 12,
                'image' => 'products/rolex_submariner.jpg', 
            ],
            [
                'brand' => 'Fossil',
                'model' => 'Jacqueline',
                'product_code' => 'FS-JAC-1007',
                'diameter' => '36mm',
                'type' => 'women',
                'material' => 'steel',
                'strap' => 'leather',
                'water_resistance' => '30m',
                'caliber' => 'Quartz',
                'price' => 220,
                'quantity' => 18,
                'image' => 'products/rolex_submariner.jpg', 
            ],
            [
                'brand' => 'Seiko',
                'model' => 'Presage',
                'product_code' => 'SK-PRE-1008',
                'diameter' => '40.5mm',
                'type' => 'men',
                'material' => 'steel',
                'strap' => 'leather',
                'water_resistance' => '100m',
                'caliber' => '4R35 Automatic',
                'price' => 520,
                'quantity' => 14,
                'image' => 'products/rolex_submariner.jpg', 
            ],
            [
                'brand' => 'Citizen',
                'model' => 'Eco-Drive',
                'product_code' => 'CT-ECO-1009',
                'diameter' => '42mm',
                'type' => 'men',
                'material' => 'steel',
                'strap' => 'steel',
                'water_resistance' => '200m',
                'caliber' => 'Eco-Drive',
                'price' => 480,
                'quantity' => 16,
                'image' => 'products/rolex_submariner.jpg', 
            ],
            [
                'brand' => 'Swatch',
                'model' => 'Skin Classic',
                'product_code' => 'SW-SKC-1010',
                'diameter' => '38mm',
                'type' => 'women',
                'material' => 'plastic',
                'strap' => 'leather',
                'water_resistance' => '30m',
                'caliber' => 'Quartz',
                'price' => 120,
                'quantity' => 25,
                'image' => 'products/rolex_submariner.jpg', 
            ],
        ];

        foreach ($watches as $watch) {
            Product::create($watch);
        }
    }
    
}
