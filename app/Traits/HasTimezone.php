<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Traits\HasTimezone
 *
 * Source referenced from github issue here:
 * https://github.com/laravel/framework/issues/21703#issuecomment-379312828
 * Fixes issue where datetime fields on Eloquent are not serialized
 * according to global Carbon serialization format specified in
 * AppServiceProvider.
 *
 * @mixin Model
 */
trait HasTimezone
{
    /**
     * Return a timestamp as DateTime object with a timezone.
     *
     * @param  mixed $value
     * @return \Illuminate\Support\Carbon
     */
    protected function asDateTime($value)
    {
        $carbon = parent::asDateTime($value);//dd($carbon);
        return $carbon->tz(config('app.timezone'));
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->jsonSerialize();
    }
}
