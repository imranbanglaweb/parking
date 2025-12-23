<?php


namespace App\Policies;


use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class WithoutBreadCustomPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        /** @var \App\Models\User $user */
        if ($user->status != 1) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    protected function preCheck($user, $model)
    {
        /** @var \App\Models\User $user */
        /** @var Model $model */
        $companyIdExists = Schema::hasColumn($model->getTable(), 'company_id');
        $branchIdExists = Schema::hasColumn($model->getTable(), 'branch_id');
        $departmentIdExists = Schema::hasColumn($model->getTable(), 'department_id');
        $employeeIdExists = Schema::hasColumn($model->getTable(), 'employee_id');

        if ($user->isCompanyUser()) {
            return ($companyIdExists ? $user->company_id == $model->company_id : true);
        } else if ($user->isBranchUser() || $user->isHrUser() || $user->isAdminOfficeUser()) {
            return ($companyIdExists ? $user->company_id == $model->company_id : true)
                && ($branchIdExists ? $user->branch_id == $model->branch_id : true);
        } else if ($user->isDepartmentUser()) {
            return ($companyIdExists ? $user->company_id == $model->company_id : true)
                && ($branchIdExists ? $user->branch_id == $model->branch_id : true)
                && ($departmentIdExists ? $user->department_id == $model->department_id : true);
        } else if ($user->isEmployeeUser()) {
            return ($companyIdExists ? $user->company_id == $model->company_id : true)
                && ($branchIdExists ? $user->branch_id == $model->branch_id : true)
                && ($departmentIdExists ? $user->department_id == $model->department_id : true)
                && ($employeeIdExists ? $user->employee_id == $model->employee_id : true);
        } else {
            return $user->isSuperUser();
        }
    }
}
