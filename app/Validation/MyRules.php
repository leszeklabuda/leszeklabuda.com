<?php

namespace App\Validation;

/**
 * My Validation Rules.
 */
class MyRules
{
    public function ci_not_equals(?string $str, string $val): bool
    {
        return strtolower($str) !== strtolower($val);
    }

    public function ci_in_list(?string $value, string $list): bool
    {
        $list = array_map('trim', explode(',', strtolower($list)));

        return in_array(strtolower($value), $list, true);
    }

    public function ci_not_in_list(?string $value, string $list): bool
    {
        return ! $this->ci_in_list($value, $list);
    }

    public function recaptcha(?string $value): bool
    {
        $status = validateRecaptcha($value);

        return $status['success'];
    }
}
