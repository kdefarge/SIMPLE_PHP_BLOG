<?php

namespace app\model;

class UserUtils 
{
    private const PW_PREFIX = "%3*";
    private const PW_SUFFIX = "@";

    private function PasswordHash($password)
    {
        return password_hash(self::PW_PREFIX.$password.Self::PW_SUFFIX, PASSWORD_BCRYPT);
    }

    private function PasswordVerify($password,$hash) 
    {
        return password_verify(self::PW_PREFIX.$password.Self::PW_SUFFIX,$hash);
    }
}