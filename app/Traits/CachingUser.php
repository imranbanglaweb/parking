<?php


namespace App\Traits;



trait CachingUser
{
    public function cacheUser()
    {
        return sprintf(
            "%s/%s-%s",
            $this->getTable(),
            $this->getKey(),
            $this->updated_at->timestamp
        );
    }
}
