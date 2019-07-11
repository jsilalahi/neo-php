<?php

if (! function_exists('camelize')) {
    /**
     * Convert snake case into camel case
     *
     * @param mixed $value
     * @param string $delimeter
     * @param bool $capitalizeFirstLetter
     * @return string
     */
    function camelize($value = null, $delimeter = "_", $capitalizeFirstLetter = false)
    {
        $str = str_replace($delimeter, '', ucwords($value, $delimeter));

        if ( ! $capitalizeFirstLetter) {
            $str = lcfirst($str);
        }

        return $str;
    }
}