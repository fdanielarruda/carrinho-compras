<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Smartphone Samsung Galaxy S24', 'unit_price' => 4999.90],
            ['name' => 'iPhone 15 128GB', 'unit_price' => 6499.00],
            ['name' => 'Notebook Dell Inspiron 15', 'unit_price' => 3899.90],
            ['name' => 'Smart TV LG 55” 4K', 'unit_price' => 3299.00],
            ['name' => 'Fone de Ouvido Bluetooth JBL Tune 520BT', 'unit_price' => 279.90],
            ['name' => 'Caixa de Som Alexa Echo Dot 5ª Geração', 'unit_price' => 379.00],
            ['name' => 'Tablet Samsung Galaxy Tab A9', 'unit_price' => 1399.90],
            ['name' => 'Monitor Gamer AOC 24” 144Hz', 'unit_price' => 1099.00],
            ['name' => 'Teclado Mecânico Redragon Kumara RGB', 'unit_price' => 289.90],
            ['name' => 'Mouse Gamer Logitech G203', 'unit_price' => 189.90],
            ['name' => 'Câmera de Segurança Intelbras Full HD', 'unit_price' => 249.00],
            ['name' => 'Carregador Portátil Power Bank 20.000mAh', 'unit_price' => 199.00],
            ['name' => 'Headset Gamer HyperX Cloud Stinger', 'unit_price' => 459.00],
            ['name' => 'Roteador Wi-Fi 6 TP-Link AX1800', 'unit_price' => 499.00],
            ['name' => 'SSD Kingston NV2 1TB M.2 NVMe', 'unit_price' => 499.90],
            ['name' => 'Placa de Vídeo RTX 4060 8GB', 'unit_price' => 2499.00],
            ['name' => 'Impressora Multifuncional Epson EcoTank L3250', 'unit_price' => 1199.00],
            ['name' => 'Smartwatch Xiaomi Redmi Watch 4', 'unit_price' => 699.90],
            ['name' => 'Controle DualSense PS5', 'unit_price' => 449.00],
            ['name' => 'Cabo HDMI 2.1 2m', 'unit_price' => 69.90],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
