<?php


namespace App\Policies;

use Illuminate\Support\Facades\Log;
use App\Facades\Voyager;
use App\Models\User;
use App\Models\RequisitionLog;
use App\Models\Requisition;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class CustomBasePolicy
{
    use HandlesAuthorization;
    protected static $datatypes = [];

    public function before($user, $ability)
    {
        /** @var \App\Models\User $user */
        if ($user->status != 1) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    protected function preCheck(User $user, $model)
    {
        /** @var \App\Models\User $user */
        /** @var Model $model */

        return $user->isSuperUser();

    }
    protected function logCheck($user, $model)
    {
        /** @var \App\Models\User $user */
        /** @var Model $model */
        $receive_log=0;
        $receive_log=  RequisitionLog::where('requisition_id',$model->id)->where('status','Received')->where('user_id',$user->id)->get();
        if(count($receive_log)<1){
            return true;
        }else{
            return false;
        }

    }
    protected function completeCheck($user, $model)
    {
        /** @var \App\Models\User $user */
        /** @var Model $model */
        $receive_log=[];
        $complete_log=[];
        $receive_log=  RequisitionLog::where('requisition_id',$model->id)->where('status','Received')->where('user_id',$user->id)->get();
        $complete_log= RequisitionLog::where('requisition_id',$model->id)->where('status','Completed')->where('user_id',$user->id)->get();
        if(count($receive_log)>0 && count($complete_log)<1 ){
            return true;
        }else{
            return false;
        }

    }
     protected function holdCheck($user, $model)
    {
        /** @var \App\Models\User $user */
        /** @var Model $model */
        $receive_log=[];
        $complete_log=[];
        $receive_log=[];
        $receive_log=  RequisitionLog::where('requisition_id',$model->id)->where('status','Received')->where('user_id',$user->id)->get();
        $complete_log=  RequisitionLog::where('requisition_id',$model->id)->where('status','Completed')->where('user_id',$user->id)->get();
        $hold_log= RequisitionLog::where('requisition_id',$model->id)->where('status','Hold')->where('user_id',$user->id)->get();
        if(count($receive_log)>0 && count($hold_log)<1 && count($complete_log)<1 ){
            return true;
        }else{
            return false;
        }

    }

    /**
     * Handle all requested permission checks.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return bool
     */
    public function __call($name, $arguments)
    {
        if (count($arguments) < 2) {
            throw new \InvalidArgumentException('not enough arguments');
        }
        /** @var \App\Voyager\Contracts\User $user */
        $user = $arguments[0];

        /** @var $model */
        $model = $arguments[1];

        return $this->checkPermission($user, $model, $name);
    }

    /**
     * Check if user has an associated permission.
     * @param \App\Models\User $user
     * @param object $model
     * @param string $action
     * @return bool
     */
    protected function checkPermission(User $user, $model, $action)
    {
        if (!isset(self::$datatypes[get_class($model)])) {
            $dataType = Voyager::model('DataType');
            self::$datatypes[get_class($model)] = $dataType->where('model_name', get_class($model))->first();
        }

        $dataType = self::$datatypes[get_class($model)];
        return $user->hasPermission($action . '_' . $dataType->name);
    }

}
