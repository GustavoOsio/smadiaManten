<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('account', 'AccountEditController', ['name' => 'account']);
    Route::resource('roles', 'RoleController', ['name' => ['index' => 'roles']]);
    Route::resource('users', 'UserController');
    Route::resource('accounts', 'AccountController');
    Route::resource('areas', 'AreasController');
    Route::resource('electronic-equipments', 'ElectronicEquipmentController');
    Route::resource('banks', 'BankController');
    Route::resource('center-costs', 'CenterCostController');
    Route::resource('contact-sources', 'ContactSourceController');
    Route::resource('diagnostics', 'DiagnosticController');
    Route::resource('issues', 'IssueController');
    Route::resource('laboratories', 'LaboratoryController');
    Route::resource('providers', 'ProviderController');
    Route::resource('services', 'ServiceController');
    Route::resource('medicines', 'MedicineController');
    Route::resource('shopping-centers', 'ShoppingCenterController');
    Route::resource('type-services', 'TypeServiceController');
    Route::resource('patients', 'PatientController');
    Route::resource('schedules', 'ScheduleController');
    Route::resource('types', 'TypeController');
    Route::resource('products', 'ProductController');
    Route::post('products/searchHistorial', 'ProductController@searchHistory');
    //Route::resource('lote-products', 'LoteProductController');
    Route::resource('/order-receipt', 'OrderReceiptController');
    Route::post('order-receipt/store', 'OrderReceiptController@store');
    Route::get('order-receipt/index/listar', 'OrderReceiptController@index_2');
    Route::get('order-receipt/edit_2/{id}', 'OrderReceiptController@edit_2');
    Route::post('order-receipt/update', 'OrderReceiptController@update');
    Route::post('order-receipt/do', 'OrderReceiptController@do');

    Route::resource('reservation-date', 'ReservationDateController');
    Route::resource('relation-products', 'RelationProductsController');
    Route::resource('tasks', 'TasksController');
    Route::resource('electronic-equipment', 'ElectronicEquipmentController');

    Route::resource('requisitions', 'RequisitionsController');
    Route::get('requisitions/cumplir/{id}', 'RequisitionsController@cumplir')->where(['id' => '[0-9-]+']);
    Route::resource('requisitions-category', 'RequisitionsCategoryController');
    Route::resource('requisitions-product-category', 'RequisitionsProductCategoryController');

    //comisiones ventas /contrato, producto, cita rutas nuevas
    Route::get('comision','comision2Controller@index')->name('comisionIndex');
    Route::get('comisionServicio','comision2Controller@servicio')->name('comisionServicio');
    Route::post('comision','comision2Controller@show')->name('comisionBuscar');
    Route::post('comisionServicio','comision2Controller@showServicio')->name('servicioBuscar');
    Route::get('detalleComision/{id}/{fehaIni}/{fechaFin}/{total}','comision2Controller@detalle')->name('comisionDetalle');
    Route::get('detalleComision2/{id}/{total}','comision2Controller@detalle2')->name('comisionDetalle2');
    Route::get('detalleServicio/{id}/{fehaIni}/{fechaFin}/{total}','comision2Controller@detalleServicio')->name('detalle.servicio');
    Route::get('detalleServicio2/{id}/{total}','comision2Controller@detalleServicio2')->name('detalle.servicio2');
    Route::get('comisionPago/{id_user}/{fechaIni}/{fechaFin}','comision2Controller@storePago')->name('comision.pago');
    Route::get('comisionDescartar/{id_user}/{fechaIni}/{fechaFin}','comision2Controller@storeDescartar')->name('comision.descartar');
    Route::get('comisionPagoServicio/{id_user}/{fechaIni}/{fechaFin}','comision2Controller@storePagoServicio')->name('comision.pagarServ');
    Route::get('comisionDescartarServicio/{id_user}/{fechaIni}/{fechaFin}','comision2Controller@storeDescartarServicio')->name('comision.descartarServ');
    Route::get('agregarServicio/{id_user}','comision2Controller@indexServiciosBono')->name('comision.agregarServ');
    Route::post('guardarServicio','comision2Controller@storeServiciosBono')->name('comision.storeServ');
    Route::get('deleteServicio/{id}/{id_d}','comision2Controller@deleteServiciosBono')->name('delete.servicio');
    //nuevas rutas
    Route::post('adicionalStore','comision2Controller@storeAdicional')->name('comision.adicional');
    Route::get('adicionalForm/{id}','comision2Controller@indexAdicional')->name('comision.adicionalForm');
    Route::get('adicionalDelete/{id}/{id_date}','comision2Controller@deleteAdicional')->name('comision.deleteForm');
    Route::get('parametro','comision2Controller@indexParametro')->name('index.parametro');
    Route::post('parametroUpdate','comision2Controller@updateParametro')->name('editar.parametro');

    //finaliza el componente de rutas
    Route::get('schedules/create/patient/{id}', 'ScheduleController@create')->where(['id' => '[0-9-]+']);
    Route::get('schedules/index/citas', 'ScheduleController@viewBlade');
    Route::resource('budgets', 'BudgetController');
    Route::post('budget/convert', 'BudgetController@convert');
    Route::get('budgets/create/patient/{id}', 'BudgetController@create')->where(['id' => '[0-9-]+']);
    Route::resource('budget', 'BudgetDashboardController');
    Route::resource('monitorings', 'MonitoringController');
    Route::resource('campaign', 'CampaignController');
    Route::resource('sucess', 'SucessController');
    Route::resource('incidents', 'IncidentController');
    Route::resource('incomes', 'IncomeController');
    Route::post('anulateIncome', 'IncomeController@anulate');
    Route::post('anulateExpense', 'ExpensesController@anulate');
    Route::post('anulateOrderForm', 'PurchaseOrderController@anulate');
    Route::post('anulateFaltantesOrderForm', 'PurchaseOrderController@anulateFaltantes');
    Route::post('anulateConsumptionOutput', 'ConsumptionOutputController@anulate');
    Route::post('anulateInventoryAdjustment', 'InventoryAdjustmentController@anulate');
    Route::get('inventory-adjustment/index/historial', 'InventoryAdjustmentController@historial');
    Route::post('anulateTransferWinery', 'TransferWineryController@anulate');
    Route::post('incomes/update', 'IncomeController@update');
    Route::post('incomes/updateMoneyBox', 'IncomeController@updateMoneyBox');
    Route::resource('anamnesis', 'AnamnesiController');
    Route::resource('physical-exams', 'PhysicalExamController');
    Route::resource('measurements', 'MeasurementController');
    Route::resource('clinical-diagnostics', 'ClinicalDiagnosticController');
    Route::resource('medical-evolutions', 'MedicalEvolutionController');
    Route::resource('surgical-description', 'SurgicalDescriptionController');
    Route::resource('patient-photographs', 'PatientPhotographsController');
    Route::resource('system-review', 'SystemReviewController');
    Route::resource('treatment-plan', 'TreatmentPlanController');
    Route::resource('biological-medicine-plan', 'BiologicalMedicinePlanController');
    Route::resource('laboratory-exams', 'LaboratoryExamsController');
    Route::resource('cosmetological-evolution', 'CosmetologicalEvolutionController');
    Route::resource('infirmary-evolution', 'InfirmaryEvolutionController');
    Route::resource('formulation-appointment', 'FormulationAppointmentController');
    Route::resource('expenses-sheet', 'ExpensesSheetController');
    Route::resource('surgery-expenses-sheet', 'SurgeryExpensesSheetController');
    Route::resource('infirmary-notes', 'InfirmaryNotesController');
    Route::resource('lab-results', 'LabResultsController');
    Route::resource('medication-control', 'MedicationControlController');
    Route::resource('liquid-control', 'LiquidControlController');
    Route::resource('sales', 'SaleController');
    Route::resource('cellars', 'CellarController');
    Route::resource('comisionesMedicas', 'comisionesMedicasController');
    Route::post('comisionesMedicas/medico', 'comisionesMedicasController@medico');
    Route::resource('comisionesDepartamentos', 'comisionesDepartamentosController');
    Route::resource('productosComisiones', 'productosComisionesController');

    //presupuesto de venta
    Route::resource('PresupuestoVenta', 'PresupuestoVentaController');
    Route::post('/savebudget/store', 'PresupuestoVentaController@store');
    Route::get('/savebudget/getPresuspuesto', 'PresupuestoVentaController@getPresupuesto');
    Route::post('/savebudget/update', 'PresupuestoVentaController@update');

    Route::resource('expenses', 'ExpensesController');
    Route::resource('payment-assistance', 'PaymentAssistanceController');
    Route::get('/payment-assistance/pay/{name}', 'PaymentAssistanceController@pay');
    Route::post('/payment-assistance/pay_go', 'PaymentAssistanceController@payGo');
    Route::resource('balance-box', 'BalanceBoxController');
    Route::resource('email-confirmation', 'EmailConfirmationController');
    Route::resource('personal-inventory', 'PersonalInventoryController');
    Route::post('/personal-inventory/update', 'PersonalInventoryController@update');
    Route::post('/email-confirmation-update', 'EmailConfirmationController@update')->name('email-confirmation-update');
    Route::post('/cities', 'GeneralController@cities');
    Route::get('/schedule/search', 'ScheduleController@search');
    Route::post('/schedule/status', 'ScheduleController@status');
    Route::post('/schedule/searchHistorialSchedule', 'ScheduleController@searchHistorialSchedule');
    Route::post('/schedule/room', 'ScheduleController@room');
    Route::post('/schedule/search/services', 'ScheduleController@services');
    Route::get('/schedule/today', 'ScheduleController@today');
    Route::post('/service', 'ServiceController@search');
    Route::post('/product', 'ProductController@search');


    /* Rutas de pacientes*/
    Route::post('/patients/search', 'PatientController@search');
    Route::post('/patients/search_2', 'PatientController@search_2');
    Route::post('/patients/modalHistoryClinic', 'PatientController@modalHistoryClinic');
    Route::post('/patients/uploadFiles', 'PatientController@uploadFiles')->name('patientsUploadFiles');
    Route::get('/patients/show/{id}', 'PatientController@patientShow');



    /* Rutas de Contratos*/
    Route::get('contract/pdf/{id}', 'ContractController@generatePDF')->where(['id' => '[0-9-]+']);
    Route::get('service/contracts', 'ServiceController@contracts');
    Route::get('service/contracts_2', 'ServiceController@contracts_2');
    Route::get('contract/pdf_2/{id}', 'ContractController@generatePDF_2')->where(['id' => '[0-9-]+']);
    Route::post('/schedule/contract', 'ScheduleController@contract');
    Route::resource('contracts', 'ContractController');
    Route::get('contracts/create/patient/{id}', 'ContractController@create')->where(['id' => '[0-9-]+']);
    Route::post('contract/approved/', 'ContractController@approved');
    Route::post('contract/liquid/', 'ContractController@liquid');


    Route::post('/expenses/getPurchaseOrders', 'ExpensesController@GetPurchaseOrders');
    Route::get('service/users', 'ServiceController@users_rol');
    Route::get('service/serviceListPatients', 'ServiceController@serviceListPatients');
    Route::post('/schedule/search/professional', 'ScheduleController@profession');
    Route::post('/schedule/search/roles', 'ScheduleController@roles');

    Route::get('sales/pdf/{id}', 'SaleController@generatePDF')->where(['id' => '[0-9-]+']);
    Route::get('incomes/pdf/{id}', 'IncomeController@generatePDF')->where(['id' => '[0-9-]+']);
    Route::get('budget/pdf/{id}', 'BudgetController@generatePDF')->where(['id' => '[0-9-]+']);
    Route::get('expense/pdf/{id}', 'ExpensesController@generatePDF')->where(['id' => '[0-9-]+']);
    Route::get('purchase/pdf-in/{id}', 'PurchaseController@generatePDFIn')->where(['id' =>  '[0-9-a-z-A-Z]+']);
    Route::get('purchase/pdf-inComplet/{id}', 'PurchaseController@generatePDFInComplet')
        ->where(['id' =>  '[0-9-a-z-A-Z]+']);
    Route::get('purchase/pdf/{id}', 'PurchaseController@generatePDF')->where(['id' =>  '[0-9-a-z-A-Z]+']);
    Route::get('patients/pdf/{id}', 'PatientController@generatePDF')->where(['id' => '[0-9-]+']);
    Route::get('patients/DescripQuiru/pdf/{id}', 'PatientController@generateDescripQuiruPDF');
    Route::get('laboratory-exams/pdf/{id}', 'LaboratoryExamsController@generatePDF')->where(['id' => '[0-9-]+']);
    Route::get('formulation-appointment/pdf/{id}', 'FormulationAppointmentController@generatePDF')->where(['id' => '[0-9-]+']);
    Route::resource('purchase-orders', 'PurchaseOrderController');
    Route::get('purchase-orders/create/{id}', 'PurchaseOrderController@create')->where(['id' => '[0-9-]+']);
    Route::get('purchase-orders/create/{id}/{date}', 'PurchaseOrderController@create')->where(['id' => '[0-9-]+']);
    Route::get('purchase-orders/do/{id}', 'PurchaseOrderController@doStatus')->where(['id' => '[0-9-]+']);
    Route::get('consumption-output/do/{id}', 'ConsumptionOutputController@doStatus')->where(['id' => '[0-9-]+']);
    Route::get('inventory-adjustment/do/{id}', 'InventoryAdjustmentController@doStatus')->where(['id' => '[0-9-]+']);;
    Route::get('transfer-winery/do/{id}', 'TransferWineryController@doStatus')->where(['id' => '[0-9-]+']);
    Route::post('purchase-orders/update', 'PurchaseOrderController@update');
    Route::post('purchase-orders/searchHistorialOrder', 'PurchaseOrderController@searchHistory');
    Route::post('purchase-orders/inventory', 'PurchaseOrderController@inventory');
    Route::get('purchase-orders/pdf/{id}', 'PurchaseOrderController@generatePDF')->where(['id' =>  '[0-9-a-z-A-Z]+']);
    Route::get('purchase-orders/pdf-fault/{id}', 'PurchaseOrderController@generatePDFfault')->where(['id' =>  '[0-9-a-z-A-Z]+']);
    Route::get('order-receipt/pdf/{id}', 'OrderReceiptController@generatePDF')->where(['id' =>  '[0-9-a-z-A-Z]+']);
    Route::get('purchase-orders/lotes/get', 'PurchaseOrderController@lotes');
    Route::resource('order-purchases', 'OrderPurchaseController');
    Route::resource('purchases', 'PurchaseController');
    Route::resource('inventory-adjustment', 'InventoryAdjustmentController');
    Route::resource('consumption-output', 'ConsumptionOutputController');
    Route::resource('transfer-winery', 'TransferWineryController');
    Route::post('update_purchase_products', 'PurchaseController@update_p_p');
    //Route::post('purchases/store', 'PurchaseController@store');

    Route::get('purchases/create/{id}', 'PurchaseController@create')->where(['id' => '[0-9-]+']);
    Route::get('exports/incomes', 'IncomeController@export');
    Route::get('exports/contracts', 'ContractController@export');
    Route::get('exports/patients', 'PatientController@export');
    Route::get('exports/monitorings', 'MonitoringController@export');
    Route::get('exports/budgets', 'BudgetController@export');
    Route::get('exports/expenses', 'ExpensesController@export');
    Route::get('exports/product', 'ProductController@export');
    Route::get('exports/loteproduct', 'LoteProductController@export');
    Route::get('exports/schedules', 'ScheduleController@export');
    Route::get('exports/SaleProduct', 'RelationProductsController@export');
    Route::get('exports/comision_sale', 'SaleController@exportComision');
    Route::get('exports/sales_comision', 'SalesComisionesController@exportComision');
    Route::get('exports/incomes_comision', 'IncomeComisionesController@exportComision');
    Route::get('exports/payment_assitance', 'PaymentAssistanceController@export');
    Route::get('exports/pay_doctors', 'PayDoctorController@export');
    Route::get('exports/sales', 'SaleController@exportSale');
    Route::get('exports/exportComisiones', 'comisionesMedicasController@export');
    Route::get('exports/exportComisionesDpto', 'comisionesDepartamentosController@export');
    Route::post('task', 'TaskController@store');
    Route::post('monitoring/close', 'MonitoringController@close');
    Route::post('payment', 'PurchaseController@payment');
    Route::post('purchase/cancel', 'PurchaseController@cancel');
    Route::post('purchase/inventory', 'PurchaseController@Inventory');
    Route::get('sales/search/product', 'PurchaseController@search');
    Route::get('sales/anulate/{id}', 'SaleController@anulate');
    Route::post('sales/anulate', 'SaleController@anulatePost');
    Route::post('update_inventory_adjustment', 'InventoryAdjustmentController@adjustment');
    Route::post('update_consumption_output', 'ConsumptionOutputController@adjustment');
    Route::post('add_inventory_adjustment', 'InventoryAdjustmentController@add');
    Route::get('sales/create/patient/{id}', 'SaleController@patient');
    Route::get('sales/view/anuladas', 'SaleController@anuladas');
    Route::get('sales/view/comisiones', 'SaleController@comisiones');
    Route::get('schedule/datatable', 'ScheduleController@datatable')->name('datatable/schedule');
    Route::resource('diagnostic_aids', 'DiagnosticAidsController');
    Route::resource('sales-comisiones', 'SalesComisionesController');
    Route::resource('incomes-comisiones', 'IncomeComisionesController');
    Route::get('diagnostic_aids/{id}/edit', 'DiagnosticAidsController@edit')->where(['id' => '[0-9-]+']);
    Route::post('diagnostic_aids/delete/{id}', 'DiagnosticAidsController@delete')->where(['id' => '[0-9-]+']);
    Route::get('reservation-date/delete/{id}', 'ReservationDateController@delete')->where(['id' => '[0-9-]+']);
    Route::get('campaign/delete/{id}', 'CampaignController@delete')->where(['id' => '[0-9-]+']);
    Route::get('areas/delete/{id}', 'AreasController@delete')->where(['id' => '[0-9-]+']);
    Route::get('order-purchases/delete/{id}', 'OrderPurchaseController@destroy')->where(['id' => '[0-9-]+']);
    Route::get('tasks/delete/{id}', 'TasksController@delete')->where(['id' => '[0-9-]+']);
    Route::get('services/delete/{id}', 'ServiceController@delete')->where(['id' => '[0-9-]+']);
    Route::post('order-purchases/approved', 'OrderPurchaseController@approved');
    Route::get('accounts-receivable', 'ContractController@receivable');
    Route::get('products-expired', 'PurchaseController@expired');
    Route::get('/email', function () {
        return view('emails.incomes.income_2');
    });
    Route::resource('pay-doctors', 'PayDoctorController');
    Route::get('/informed_consents/services', 'InformedConsentsController@services');
    Route::post('/informed_consents/store', 'InformedConsentsController@store');
    //Route::get('/informed_consents/{id}','InformedConsentsController@show');
    Route::get('/informed_consents', 'InformedConsentsController@index');
    Route::resource('text-informed-consents', 'TextInformedConsentsController');
    Route::get('text-informed-consents/delete/{id}', 'TextInformedConsentsController@delete')->where(['id' => '[0-9-]+']);
    Route::get('/informed_consents/pdf/{id}', 'InformedConsentsController@generatePDF')->where(['id' => '[0-9-]+']);
    //POLIZAS
    Route::get('/policies', 'PoliciesPatientController@index');
    Route::get('/policies/pdf/{id}', 'PoliciesPatientController@generatePDF')->where(['id' => '[0-9-]+']);;
    Route::get('/policies/services', 'PoliciesPatientController@services');
    Route::post('/policies/store', 'PoliciesPatientController@store');

    //nueva historia clinica
    Route::POST('print/patients/newHc', 'PatientController@newHcPdf');
    Route::get('print/patients/print/{id}', 'PatientController@printNhc')->where(['id' => '[0-9-]+']);


    //metas medicas
    Route::POST('metasMedicas/create', 'comisionesMedicasController@store');
    Route::get('metasMedicas/getMeta', 'comisionesMedicasController@show');
    Route::get('metasMedicas/update', 'comisionesMedicasController@update');

    //Metas por servicio
    Route::resource('MetaLineaServicio', 'MetaservicioController');
    Route::get('/metaServiceCreate', 'MetaservicioController@create');
    Route::get('/metasServico/save', 'MetaservicioController@store');
    Route::get('/metasServico/show/{id}', 'MetaservicioController@show');
    Route::get('/metasServico/update', 'MetaservicioController@update');

    #nueva comision medica
    Route::resource('NuevaComisionMedica', 'nuevaComisionMedicasController');
    Route::get('/NuevaComision/Create', 'nuevaComisionMedicasController@create');

    });

