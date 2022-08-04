<?php

namespace App\Authentication;

class Passwords
{
    /**
     * Hashes a given password
     *
     * @param string $password
     * @return boolean
     */
    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Verifies a password against a previously hashed password.
     *
     * @param string $password
     * @param string $hash
     * @return boolean
     */
    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
