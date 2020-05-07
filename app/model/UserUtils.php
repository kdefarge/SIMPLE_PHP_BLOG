<?php

namespace app\model;

class UserUtils extends Utils
{
    private const PW_PREFIX = "%3*";
    private const PW_SUFFIX = "@";

    public function PasswordHash(string $password) : string
    {
        return password_hash(self::PW_PREFIX.$password.Self::PW_SUFFIX, PASSWORD_BCRYPT);
    }

    public function UserPasswordVerify(User $user, String $password) : bool
    {
        if(password_verify(self::PW_PREFIX.$password.self::PW_SUFFIX, $user->GetPassword()))
            return true;
        
        $this->AddError('Le mot de passe n\'est pas identique');
        return false;
    }

    public function UserNameValid(string $value) : bool
    {
        $name = 'nom d\'utilisateur';

        if(!$this->NotBlank($name, $value))
            return false;
        
        if(!$this->MinLength($name, $value, 3))
            return false;
        
        return $this->MaxLength($name, $value, 32);
    }
    
    public function PasswordValid(string $value) : bool
    {
        $name = 'mot de passe';

        if(!$this->NotBlank($name, $value))
            return false;
        
        if(!$this->MinLength($name, $value, 8))
            return false;
        
        return $this->MaxLength($name, $value, 20);
    }
}