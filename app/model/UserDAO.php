<?php

namespace app\model;

class UserDAO extends DAO
{
    
    public function Create(User $user)
    {
        $sql = 'INSERT INTO `user`(`name`, `email`, `password`, `is_admin`) VALUES (?, ?, ?, ?)';
        $this->createQuery($sql, [
                $user->GetUserName(),
                $user->GetEmail(),
                $user->GetPassword(),
                $user->GetIsAdmin()
            ]);
    }

    public function Update(User $user)
    {
        $sql = 'UPDATE `user` SET `name`=?,`email`=?,`password`=?, `is_admin`=? WHERE `user_id` = ?';

        $this->createQuery($sql, [
                $user->GetUserName(),
                $user->GetEmail(),
                $user->GetPassword(),
                $user->GetIsAdmin(),
                $user->GetID()
            ]);
    }

    public function Delete(User $user)
    {
        $sql = 'DELETE FROM `user` WHERE user_id = ?';
        $this->createQuery($sql, [$user->GetID()]);
    }

    private function ReadBy($key, $value)
    {
        $sql = 'SELECT `user_id`, `name`, `email`, `password`, `registered`, `is_admin` FROM user WHERE '.$key.' = ?';
        $data = $this->createQuery($sql, [$value]);
        
        $result = $data->fetch();
        if(!$result)
            return null;
        
        $user = new User();
        $user->SetID(           $result['user_id']      );
        $user->SetName(         $result['name']         );
        $user->SetEmail(        $result['email']        );
        $user->SetPassword(     $result['password']     );
        $user->SetRegistered(   $result['registered']   );
        $user->SetIsAdmin(      $result['is_admin']     );

        return $user;
    }

    public function ReadByID($id)
    {
        return $this->ReadBy('user_id', $id);
    }

    public function ReadByName($name)
    {
        return $this->ReadBy('name', $name);
    }

    public function ReadByEmail($email)
    {
        return $this->ReadBy('email', $email);
    }
}

?>