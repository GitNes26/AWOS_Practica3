<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comentarios')->insert([
            'comentario' => 'La laptop cuenta con R7?',
            'usuario_id' => 2,
            'producto_id' => 1
        ]);

        factory(App\Models\Comentario::class,10)->create();
    }
}
