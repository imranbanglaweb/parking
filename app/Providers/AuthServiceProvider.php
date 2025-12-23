<?php

namespace App\Providers;

use App\Models\AppraisalCriteria;
use App\Models\AppraisalForm;
use App\Models\DutyRoistering;
use App\Models\DutyRoisteringException;
use App\Models\EmployeeAdvance;
use App\Models\EmployeeAppraisal;
use App\Models\EmployeeLeaveRequisition;
use App\Models\EmployeeLoan;
use App\Models\EmployeeLoanPayment;
use App\Models\GeneratedBonusHistory;
use App\Models\GeneratedSalary;
use App\Models\GeneratedSalaryHistory;
use App\Models\MenuItem;
use App\Models\ProvidentFundBalance;
use App\Models\SalaryHeadConfig;
use App\Models\User;
use App\Policies\AppraisalCriteriaPolicy;
use App\Policies\AppraisalFormPolicy;
use App\Policies\DutyRoisteringExceptionPolicy;
use App\Policies\DutyRoisteringPolicy;
use App\Policies\EmployeeAdvancePolicy;
use App\Policies\EmployeeAppraisalPolicy;
use App\Policies\EmployeeLeaveRequisitionPolicy;
use App\Policies\EmployeeLoanPaymentPolicy;
use App\Policies\EmployeeLoanPolicy;
use App\Policies\GeneratedBonusHistoryPolicy;
use App\Policies\GeneratedSalaryHistoryPolicy;
use App\Policies\GeneratedSalaryPolicy;
use App\Policies\MenuItemPolicy;
use App\Policies\ProvidentFundBalancePolicy;
use App\Policies\SalaryHeadConfigPolicy;
use App\Services\Auth\CustomSessionGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        MenuItem::class => MenuItemPolicy::class,
    ];

    protected $gates = [

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if(count($this->gates) > 0){
            // Gates
            foreach ($this->gates as $gate) {
                Gate::define($gate, function (User $user) use ($gate) {
                    return !$user->isSuperUser() && !$user->isSuperAdmin() && $user->hasPermission($gate);
                });
            }
        }

    }
}
