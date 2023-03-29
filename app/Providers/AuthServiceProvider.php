<?php

namespace App\Providers;

use App\Models\PaymentAssistance;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Role' => 'App\Policies\RolePolicy',
        'App\Models\Account' => 'App\Policies\AccountPolicy',
        'App\Models\Bank' => 'App\Policies\BankPolicy',
        'App\Models\CenterCost' => 'App\Policies\CenterCostPolicy',
        'App\Models\ContactSource' => 'App\Policies\ContactSourcePolicy',
        'App\Models\Diagnostic' => 'App\Policies\DiagnosticPolicy',
        'App\Models\Issue' => 'App\Policies\IssuePolicy',
        'App\Models\Laboratory' => 'App\Policies\LaboratoryPolicy',
        'App\Models\Provider' => 'App\Policies\ProviderPolicy',
        'App\Models\Service' => 'App\Policies\ServicePolicy',
        'App\Models\Medicine' => 'App\Policies\MedicinePolicy',
        'App\Models\ShoppingCenter' => 'App\Policies\ShoppingCenterPolicy',
        'App\Models\TypeService' => 'App\Policies\TypeServicePolicy',
        'App\Models\Patient' => 'App\Policies\PatientPolicy',
        'App\Models\Schedule' => 'App\Policies\SchedulePolicy',
        'App\Models\Contract' => 'App\Policies\ContractPolicy',
        'App\Models\Budget' => 'App\Policies\BudgetPolicy',
        'App\Models\Income' => 'App\Policies\IncomePolicy',
        'App\Models\Monitoring' => 'App\Policies\MonitoringPolicy',
        'App\Models\Type' => 'App\Policies\TypePolicy',
        'App\Models\Product' => 'App\Policies\ProductPolicy',
        'App\Models\PurchaseOrder' => 'App\Policies\PurchaseOrderPolicy',
        'App\Models\Purchase' => 'App\Policies\PurchasePolicy',
        'App\Models\Sale' => 'App\Policies\SalePolicy',
        'App\Models\Cellar' => 'App\Policies\CellarPolicy',
        'App\Models\OrderPurchase' => 'App\Policies\OrderPurchasePolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Models\BudgetDashboard' => 'App\Policies\BudgetDashboardPolicy',
        'App\Models\Expenses' => 'App\Policies\ExpensesPolicy',
        'App\Models\MedicationControl' => 'App\Policies\MedicationControlPolicy',
        'App\Models\LiquidControl' => 'App\Policies\LiquidControlPolicy',
        'App\Models\DiagnosticAids' => 'App\Policies\DiagnosticAidsPolicy',
        //Nuevos policies y validaciones ...
        'App\Models\Anamnesis' => 'App\Policies\AnamnesisPolicy',
        'App\Models\SystemReview' => 'App\Policies\SystemReviewPolicy',
        'App\Models\PhysicalExam' => 'App\Policies\PhysicalExamPolicy',
        'App\Models\Measurements' => 'App\Policies\MeasurementsPolicy',
        'App\Models\ClinicalDiagnostics' => 'App\Policies\ClinicalDiagnosticsPolicy',
        'App\Models\TreatmentPlan' => 'App\Policies\TreatmentPlanPolicy',
        'App\Models\BiologicalMedicinePlan' => 'App\Policies\BiologicalMedicinePlanPolicy',
        'App\Models\LaboratoryExams' => 'App\Policies\LaboratoryExamsPolicy',
        'App\Models\MedicalEvolutions' => 'App\Policies\MedicalEvolutionsPolicy',
        'App\Models\CosmetologicalEvolution' => 'App\Policies\CosmetologicalEvolutionPolicy',
        'App\Models\InfirmaryEvolution' => 'App\Policies\InfirmaryEvolutionPolicy',
        'App\Models\FormulationAppointment' => 'App\Policies\FormulationAppointmentPolicy',
        'App\Models\ExpensesSheet' => 'App\Policies\ExpensesSheetPolicy',
        'App\Models\SurgeryExpensesSheet' => 'App\Policies\SurgeryExpensesSheetPolicy',
        'App\Models\InfirmaryNotes' => 'App\Policies\InfirmaryNotesPolicy',
        'App\Models\SurgicalDescription' => 'App\Policies\SurgicalDescriptionPolicy',
        'App\Models\PatientPhotographs' => 'App\Policies\PatientPhotographsPolicy',
        'App\Models\LabResults' => 'App\Policies\LabResultsPolicy',
        'App\Models\LoteProducts' => 'App\Policies\LoteProductsPolicy',
        'App\Models\ReservationDate' => 'App\Policies\ReservationDatePolicy',
        'App\Models\SaleProduct' => 'App\Policies\RelationProductsPolicy',
        'App\Models\Requisitions' => 'App\Policies\RequisitionsPolicy',
        'App\Models\RequisitionsCategory' => 'App\Policies\RequisitionsCategoryPolicy',
        'App\Models\RequisitionsProductCategory' => 'App\Policies\RequisitionsProductCategoryPolicy',
        'App\Models\PaymentAssistance' => 'App\Policies\PaymentAssistancePolicy',
        'App\Models\BalanceBox' => 'App\Policies\BalanceBoxPolicy',
        'App\Models\EmailConfirmation' => 'App\Policies\EmailConfirmationPolicy',
        'App\Models\Campaign' => 'App\Policies\CampaignPolicy',
        'App\Models\Task' => 'App\Policies\TasksPolicy',
        'App\Models\ElectronicEquipment' => 'App\Policies\ElectronicEquipmentPolicy',
        'App\Models\PatientsFiles' => 'App\Policies\PatientsFilesPolicy',
        'App\Models\PersonalInventory' => 'App\Policies\PersonalInventoryPolicy',
        'App\Models\InventoryAdjustment' => 'App\Policies\InventoryAdjustmentPolicy',
        'App\Models\Areas' => 'App\Policies\AreasPolicy',
        'App\Models\ConsumptionOutput' => 'App\Policies\ConsumptionOutputPolicy',
        'App\Models\TransferWinery' => 'App\Policies\TransferWineryPolicy',
        'App\Models\SalesComisiones' => 'App\Policies\SalesComisionesPolicy',
        'App\Models\IncomesComisiones' => 'App\Policies\IncomesComisionesPolicy',
        'App\Models\PayDoctors' => 'App\Policies\PayDoctorsPolicy',
        'App\Models\InformedConsents' => 'App\Policies\InformedConsentsPolicy',
        'App\Models\TextInformedConsents' => 'App\Policies\TextInformedConsentsPolicy',
        'App\Models\PoliciesPatients' => 'App\Policies\PoliciesPatientsPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
