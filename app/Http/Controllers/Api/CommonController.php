<?php


namespace App\Http\Controllers\Api;


class CommonController extends BaseApiController
{

    public function helpDeskNumber()
    {
        return $this->sendResponse(setting('admin.help_desk_number'), 'success');
    }
}
