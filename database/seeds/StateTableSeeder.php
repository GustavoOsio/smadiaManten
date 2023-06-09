<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $query = "INSERT INTO `states` (`id`, `name`)
                    VALUES
                      (5,'ANTIOQUIA'),
                      (8,'ATLÁNTICO'),
                      (11,'BOGOTÁ, D.C.'),
                      (13,'BOLÍVAR'),
                      (15,'BOYACÁ'),
                      (17,'CALDAS'),
                      (18,'CAQUETÁ'),
                      (19,'CAUCA'),
                      (20,'CESAR'),
                      (23,'CÓRDOBA'),
                      (25,'CUNDINAMARCA'),
                      (27,'CHOCÓ'),
                      (41,'HUILA'),
                      (44,'LA GUAJIRA'),
                      (47,'MAGDALENA'),
                      (50,'META'),
                      (52,'NARIÑO'),
                      (54,'NORTE DE SANTANDER'),
                      (63,'QUINDIO'),
                      (66,'RISARALDA'),
                      (68,'SANTANDER'),
                      (70,'SUCRE'),
                      (73,'TOLIMA'),
                      (76,'VALLE DEL CAUCA'),
                      (81,'ARAUCA'),
                      (85,'CASANARE'),
                      (86,'PUTUMAYO'),
                      (88,'SAN ANDRÉS'),
                      (91,'AMAZONAS'),
                      (94,'GUAINÍA'),
                      (95,'GUAVIARE'),
                      (97,'VAUPÉS'),
                      (99,'VICHADA');";
        DB::statement($query);
    }
}
