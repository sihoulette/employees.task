<?php

/*
 * Prevent duplicate definition of the same name function.
 */
if (! function_exists('env')) {
    /**
     * Get a value from environment variable.
     *
     * @param string                 $name
     * @param array|bool|string|null $default
     *
     * @return array|bool|string|null
     */
    function env(string $name, $default = null)
    {
        return $_ENV[$name] ?? $default;
    }
}
