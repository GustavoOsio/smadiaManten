<?php

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create(['name' => 'Aceites', 'type' => 'presentation']);
        Type::create(['name' => 'Ampolla', 'type' => 'presentation']);
        Type::create(['name' => 'Crema', 'type' => 'presentation']);
        Type::create(['name' => 'Emulsion', 'type' => 'presentation']);
        Type::create(['name' => 'Frasco', 'type' => 'presentation']);
        Type::create(['name' => 'Galon', 'type' => 'presentation']);
        Type::create(['name' => 'Gel', 'type' => 'presentation']);
        Type::create(['name' => 'Gotas', 'type' => 'presentation']);
        Type::create(['name' => 'Jeringa prellenada', 'type' => 'presentation']);
        Type::create(['name' => 'Paquete', 'type' => 'presentation']);
        Type::create(['name' => 'Rollo', 'type' => 'presentation']);
        Type::create(['name' => 'Shampoo', 'type' => 'presentation']);
        Type::create(['name' => 'Sobre', 'type' => 'presentation']);
        Type::create(['name' => 'Soluciones', 'type' => 'presentation']);
        Type::create(['name' => 'Spray', 'type' => 'presentation']);
        Type::create(['name' => 'Tabletas', 'type' => 'presentation']);
        Type::create(['name' => 'Tubo', 'type' => 'presentation']);
        Type::create(['name' => 'Unguento', 'type' => 'presentation']);
        Type::create(['name' => 'Unidad', 'type' => 'presentation']);
        Type::create(['name' => 'Accesorios C-Ortiz', 'type' => 'category']);
        Type::create(['name' => 'Anestesico', 'type' => 'category']);
        Type::create(['name' => 'Anti-acne', 'type' => 'category']);
        Type::create(['name' => 'Antiedad', 'type' => 'category']);
        Type::create(['name' => 'Antioxidante', 'type' => 'category']);
        Type::create(['name' => 'Aseo', 'type' => 'category']);
        Type::create(['name' => 'Cafetería', 'type' => 'category']);
        Type::create(['name' => 'Capilar', 'type' => 'category']);
        Type::create(['name' => 'Cicatrizante', 'type' => 'category']);
        Type::create(['name' => 'Clarificante', 'type' => 'category']);
        Type::create(['name' => 'Demaquillante', 'type' => 'category']);
        Type::create(['name' => 'Despigmentante', 'type' => 'category']);
        Type::create(['name' => 'Detoxificante', 'type' => 'category']);
        Type::create(['name' => 'Dispositivo Medico', 'type' => 'category']);
        Type::create(['name' => 'Exfoliante', 'type' => 'category']);
        Type::create(['name' => 'Fajas', 'type' => 'category']);
        Type::create(['name' => 'Hidratante', 'type' => 'category']);
        Type::create(['name' => 'Hidratante Piel Grasa', 'type' => 'category']);
        Type::create(['name' => 'Hidratante Piel Seca', 'type' => 'category']);
        Type::create(['name' => 'Insumos de cabina', 'type' => 'category']);
        Type::create(['name' => 'Insumos Medicos', 'type' => 'category']);
        Type::create(['name' => 'Limpiadora', 'type' => 'category']);
        Type::create(['name' => 'Medicamento', 'type' => 'category']);
        Type::create(['name' => 'Medicamento de CE', 'type' => 'category']);
        Type::create(['name' => 'Medicamentos Post', 'type' => 'category']);
        Type::create(['name' => 'Medicina Biologica', 'type' => 'category']);
        Type::create(['name' => 'Papeliería', 'type' => 'category']);
        Type::create(['name' => 'Protector Solar', 'type' => 'category']);
        Type::create(['name' => 'Reafirmante', 'type' => 'category']);
        Type::create(['name' => 'Rellenos Faciales', 'type' => 'category']);
        Type::create(['name' => 'Renovador Cutaneo', 'type' => 'category']);
        Type::create(['name' => 'Restaurador Cutaneo', 'type' => 'category']);
        Type::create(['name' => 'Restaurador Vascular', 'type' => 'category']);
        Type::create(['name' => 'Suplemento Alimentario', 'type' => 'category']);
        Type::create(['name' => 'Toxina Botulinica', 'type' => 'category']);
        Type::create(['name' => 'Productos', 'type' => 'inventory']);
        Type::create(['name' => 'Insumos', 'type' => 'inventory']);
        Type::create(['name' => 'Consumibles', 'type' => 'inventory']);
        Type::create(['name' => 'Miligramos', 'type' => 'unit', 'short' => 'Mg']);
        Type::create(['name' => 'Unidad', 'type' => 'unit', 'short' => 'Und']);
        Type::create(['name' => 'Mililitros', 'type' => 'unit', 'short' => 'Ml']);
        Type::create(['name' => 'Gramos', 'type' => 'unit', 'short' => 'Gr']);
        Type::create(['name' => 'Centimetro', 'type' => 'unit', 'short' => 'Cm']);
        Type::create(['name' => 'Unidades', 'type' => 'unit', 'short' => 'Ui']);
        Type::create(['name' => 'Caja', 'type' => 'unit', 'short' => 'Cj']);
        Type::create(['name' => 'Blister', 'type' => 'unit', 'short' => 'Blister']);

    }
}
