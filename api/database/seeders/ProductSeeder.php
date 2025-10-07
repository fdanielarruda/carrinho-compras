<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultImage = "https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg";
        $now = now();

        $productsData = [
            [
                'image' => $defaultImage,
                'name' => 'Smartphone Samsung Galaxy S24',
                'unit_price' => 4999.90,
                'categories' => ['Celulares', 'Eletrônicos']
            ],
            [
                'image' => $defaultImage,
                'name' => 'iPhone 15 128GB',
                'unit_price' => 6499.00,
                'categories' => ['Celulares', 'Eletrônicos']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Notebook Dell Inspiron 15',
                'unit_price' => 3899.90,
                'categories' => ['Informática', 'Notebooks']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Smart TV LG 55” 4K',
                'unit_price' => 3299.00,
                'categories' => ['TV e Vídeo', 'Eletrônicos']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Fone de Ouvido Bluetooth JBL Tune 520BT',
                'unit_price' => 279.90,
                'categories' => ['Áudio', 'Acessórios']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Caixa de Som Alexa Echo Dot 5ª Geração',
                'unit_price' => 379.00,
                'categories' => ['Smart Home', 'Áudio']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Tablet Samsung Galaxy Tab A9',
                'unit_price' => 1399.90,
                'categories' => ['Tablets', 'Eletrônicos']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Monitor Gamer AOC 24” 144Hz',
                'unit_price' => 1099.00,
                'categories' => ['Informática', 'Monitores', 'Gamer']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Teclado Mecânico Redragon Kumara RGB',
                'unit_price' => 289.90,
                'categories' => ['Periféricos', 'Gamer']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Mouse Gamer Logitech G203',
                'unit_price' => 189.90,
                'categories' => ['Periféricos', 'Gamer']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Câmera de Segurança Intelbras Full HD',
                'unit_price' => 249.00,
                'categories' => ['Smart Home', 'Segurança']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Carregador Portátil Power Bank 20.000mAh',
                'unit_price' => 199.00,
                'categories' => ['Acessórios', 'Celulares']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Headset Gamer HyperX Cloud Stinger',
                'unit_price' => 459.00,
                'categories' => ['Áudio', 'Gamer']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Roteador Wi-Fi 6 TP-Link AX1800',
                'unit_price' => 499.00,
                'categories' => ['Informática', 'Rede']
            ],
            [
                'image' => $defaultImage,
                'name' => 'SSD Kingston NV2 1TB M.2 NVMe',
                'unit_price' => 499.90,
                'categories' => ['Informática', 'Hardware']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Placa de Vídeo RTX 4060 8GB',
                'unit_price' => 2499.00,
                'categories' => ['Informática', 'Hardware', 'Gamer']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Impressora Multifuncional Epson EcoTank L3250',
                'unit_price' => 1199.00,
                'categories' => ['Informática', 'Periféricos']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Smartwatch Xiaomi Redmi Watch 4',
                'unit_price' => 699.90,
                'categories' => ['Wearable', 'Acessórios']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Controle DualSense PS5',
                'unit_price' => 449.00,
                'categories' => ['Gamer', 'Consoles']
            ],
            [
                'image' => $defaultImage,
                'name' => 'Cabo HDMI 2.1 2m',
                'unit_price' => 69.90,
                'categories' => ['Acessórios']
            ],
        ];

        $preparedData = array_map(function ($product) use ($now) {
            return [
                'image' => $product['image'],
                'name' => $product['name'],
                'unit_price' => $product['unit_price'],
                'categories' => json_encode($product['categories']),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $productsData);

        DB::table('products')->insert($preparedData);
    }
}
