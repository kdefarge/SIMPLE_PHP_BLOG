<?php

namespace app\model;

class UserDAO extends DAO
{
    const PW_PREFIX = "%3*";
    const PW_SUFFIX = "@";

    private function Password_hash($password)
    {
        return password_hash(self::PW_PREFIX.$password.Self::PW_SUFFIX, PASSWORD_BCRYPT);
    }

    private function Password_verify($password,$hash) 
    {
        return password_verify(self::PW_PREFIX.$password.Self::PW_SUFFIX,$hash);
    }

    public function create(User $user, $password)
    {
        $password = $this->Password_hash($password);

        $sql = 'INSERT INTO `user`(`user_name`,`email`,`password`) VALUES (?, ?, ?)';
        
        $this->createQuery($sql, [$user->GetUserName(), $user->GetEmail(), $password]);
    }

    public function update(User $user, $password = null)
    {
        if(is_null($password))
        {
            $sql = 'UPDATE `user` SET `user_name`=?,`email`=? WHERE user_id=?';

            $this->createQuery($sql, [$user->GetUserName(), $user->GetEmail(), $user->GetID()]);
        }
        else
        {
            $sql = 'UPDATE `user` SET `user_name`=?,`email`=?,`password`=? WHERE user_id=?';
            
            $password = $this->Password_hash($password);

            $this->createQuery($sql, [$user->GetUserName(), $user->GetEmail(), $password, $user->GetID()]);
        }
        
    }

    public function delete(User $user)
    {
        $sql = 'DELETE FROM `user` WHERE user_id = ?';
        $this->createQuery($sql, [$user->GetID()]);
    }

    public function read_login(User $user, $password)
    {
        $sql = 'SELECT `id`, `user_name`, `email`, `password`, `is_admin` FROM user WHERE pseudo = ?';
        $password = $this->password($password);

        $data = $this->createQuery($sql, [$post->get('pseudo')]);
        $result = $data->fetch();
        $isPasswordValid = password_verify($post->get('password'), $result['password']);
    }
}

?>