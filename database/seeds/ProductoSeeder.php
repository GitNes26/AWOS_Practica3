<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productos')->insert([
            'producto' => 'Laptop Huawei MateBook X',
            'cantidad' => '97',
            'vendedor_id' => 2
        ]);

        factory(App\Models\Producto::class,2)->create();
    }
}
