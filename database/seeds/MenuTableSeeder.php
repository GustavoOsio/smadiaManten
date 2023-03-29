<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        Menu::create(['name' => 'Usuarios', 'slug' => 'users', 'type' => 'config']);
        Menu::create(['name' => 'Roles', 'slug' => 'roles', 'type' => 'config']);
        Menu::create(['name' => 'Cuentas de banco', 'slug' => 'accounts', 'type' => 'config']);
        Menu::create(['name' => 'Bancos', 'slug' => 'banks', 'type' => 'config']);
        Menu::create(['name' => 'Centros de costo', 'slug' => 'center-costs', 'type' => 'config']);
        Menu::create(['name' => 'Fuentes de contacto', 'slug' => 'contact-sources', 'type' => 'config']);
        Menu::create(['name' => 'Diagnosticos', 'slug' => 'diagnostics', 'type' => 'config']);
        Menu::create(['name' => 'Temas de seguimiento', 'slug' => 'issues', 'type' => 'config']);
        Menu::create(['name' => 'Laboratorios', 'slug' => 'laboratories', 'type' => 'config']);
        Menu::create(['name' => 'Medicamentos biológicos', 'slug' => 'medicines', 'type' => 'config']);
        Menu::create(['name' => 'Proveedores', 'slug' => 'providers', 'type' => 'config']);
        Menu::create(['name' => 'Líneas de servicio', 'slug' => 'services', 'type' => 'config']);
        Menu::create(['name' => 'Centros de compra', 'slug' => 'shopping-centers', 'type' => 'config']);
        Menu::create(['name' => 'Tipos de servicio', 'slug' => 'type-services', 'type' => 'config']);
        Menu::create(['name' => 'Pacientes', 'slug' => 'patients', 'type' => 'dashboard']);
        Menu::create(['name' => 'Agenda', 'slug' => 'schedules', 'type' => 'dashboard']);
        Menu::create(['name' => 'Ingresos', 'slug' => 'incomes', 'type' => 'box']);
        Menu::create(['name' => 'Contratos', 'slug' => 'contracts', 'type' => 'box']);
        Menu::create(['name' => 'Presupuestos', 'slug' => 'budgets', 'type' => 'box']);
        Menu::create(['name' => 'Seguimientos', 'slug' => 'monitorings', 'type' => 'config']);
        Menu::create(['name' => 'Categorias de productos', 'slug' => 'types', 'type' => 'config']);
        Menu::create(['name' => 'Productos', 'slug' => 'products', 'type' => 'inventory']);
        Menu::create(['name' => 'Ordenes de compra', 'slug' => 'purchase-orders', 'type' => 'inventory']);
        Menu::create(['name' => 'Compras', 'slug' => 'purchases', 'type' => 'inventory']);
        Menu::create(['name' => 'Anamnesis', 'slug' => 'anamnesis', 'type' => '']);
        Menu::create(['name' => 'Ventas', 'slug' => 'sales', 'type' => 'box']);
        Menu::create(['name' => 'Bodegas', 'slug' => 'cellars', 'type' => 'inventory']);
        Menu::create(['name' => 'Ordenes de pedido', 'slug' => 'order-purchases', 'type' => 'inventory']);
        Menu::create(['name' => 'Productos por vencer', 'slug' => 'products-expired', 'type' => 'report']);
        Menu::create(['name' => 'Cuentas por cobrar', 'slug' => 'accounts-receivable', 'type' => 'box']);
        Menu::create(['name' => 'Cuentas por pagar', 'slug' => 'debts-to-pay', 'type' => 'box']);
        Menu::create(['name' => 'Presupuesto', 'slug' => 'budget', 'type' => 'config']);
        Menu::create(['name' => 'Egresos', 'slug' => 'expenses', 'type' => 'box']);
        Menu::create(['name' => 'Control de medicamentos', 'slug' => 'medication_control', 'type' => '']);
        Menu::create(['name' => 'Control de liquidos', 'slug' => 'liquid_control', 'type' => '']);
        Menu::create(['name' => 'Ayudas Diagnosticas', 'slug' => 'diagnostic_aids', 'type' => 'config']);

        Menu::create(['name' => 'Revisión por Sistema','slug'=>'system-review', 'type' => '']);
        Menu::create(['name' => 'Exámen físico','slug'=>'physical-exams', 'type' => '']);
        Menu::create(['name' => 'Tabla de medidas','slug'=>'measurements', 'type' => '']);
        Menu::create(['name' => 'Diagnostico clínico','slug'=>'clinical-diagnostics', 'type' => '']);
        Menu::create(['name' => 'Plan de Tratamiento','slug'=>'treatment-plan', 'type' => '']);
        Menu::create(['name' => 'Plan de Medicina Biologica','slug'=>'biological-medicine-plan', 'type' => '']);
        Menu::create(['name' => 'Ayudas Diagnosticas','slug'=>'laboratory-exams', 'type' => '']);
        Menu::create(['name' => 'Evolución médica','slug'=>'medical-evolutions', 'type' => '']);
        Menu::create(['name' => 'Evolución Cosmetológica','slug'=>'cosmetological-evolution', 'type' => '']);
        Menu::create(['name' => 'Evolución de Enfermería','slug'=>'infirmary-evolution', 'type' => '']);
        Menu::create(['name' => 'Formulación','slug'=>'formulation-appointment', 'type' => '']);
        Menu::create(['name' => 'Hoja de Gastos','slug'=>'expenses-sheet', 'type' => '']);
        Menu::create(['name' => 'Hoja de Gastos de Cirugía','slug'=>'surgery-expenses-sheet', 'type' => '']);
        Menu::create(['name' => 'Notas de Enfermería','slug'=>'infirmary-notes', 'type' => '']);
        Menu::create(['name' => 'Descripción Quirúrgica','slug'=>'surgical-description', 'type' => '']);
        Menu::create(['name' => 'Fotografias','slug'=>'patient-photographs', 'type' => '']);
        Menu::create(['name' => 'Resultados de Laboratorio','slug'=>'lab-results', 'type' => '']);
        Menu::create(['name' => 'Recepcion de pedido','slug'=>'order-receipt', 'type' => 'inventory']);
        Menu::create(['name' => 'Reserva de citas','slug'=>'reservation-date', 'type' => '']);
        Menu::create(['name' => 'Relacion de productos','slug'=>'relation-products', 'type' => 'box']);
        Menu::create(['name' => 'Requisiciones','slug'=>'requisitions', 'type' => 'inventory']);
        Menu::create(['name' => 'Categorías de requisiciones','slug'=>'requisitions-category', 'type' => '']);
        Menu::create(['name' => 'Producto de requisiciones','slug'=>'requisitions-product-category', 'type' => '']);
        */
        //nuevo modulo de pagos
        //Menu::create(['name' => 'Pago a asistenciales','slug'=>'payment-assistance', 'type' => 'pay']);
        //nuevo modulo de saldo de coaja
        //Menu::create(['name' => 'Saldo de caja','slug'=>'balance-box', 'type' => 'box']);
        Menu::create(['name' => 'Correo Confirmacion de cita','slug'=>'email-confirmation', 'type' => 'config']);
        Menu::create(['name' => 'Campañas y Promociones','slug'=>'campaign', 'type' => 'config']);
        Menu::create(['name' => 'Tareas','slug'=>'tasks', 'type' => '']);
        Menu::create(['name' => 'Equipos','slug'=>'electronic-equipment', 'type' => 'config']);
        Menu::create(['name' => 'Archivos','slug'=>'patients-files', 'type' => '']);
        Menu::create(['name' => 'Inventario Personal','slug'=>'personal-inventory', 'type' => 'inventory']);
        Menu::create(['name' => 'Ajuste de Inventario','slug'=>'inventory-adjustment', 'type' => 'inventory']);
        Menu::create(['name' => 'Areas','slug'=>'areas', 'type' => 'inventory']);
        Menu::create(['name' => 'Salidad por consumo','slug'=>'consumption-output', 'type' => 'inventory']);
        Menu::create(['name' => 'Tranferencia a bodega','slug'=>'transfer-winery', 'type' => 'inventory']);
        Menu::create(['name' => 'Pago por venta','slug'=>'sales-comisiones', 'type' => 'pay']);
        Menu::create(['name' => 'Pago por Ingresos','slug'=>'incomes-comisiones', 'type' => 'pay']);
        Menu::create(['name' => 'Pago a Doctores','slug'=>'pay-doctors', 'type' => 'pay']);
        Menu::create(['name' => 'Consentimientos Informados','slug'=>'informed_consents', 'type' => 'report']);
        Menu::create(['name' => 'Textos Consentimientos','slug'=>'text-informed-consents', 'type' => 'report']);
        Menu::create(['name' => 'Polizas','slug'=>'policies', 'type' => 'report']);
    }


}
