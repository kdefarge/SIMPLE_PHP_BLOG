<?php

namespace app\model;

use PDO;

class UserDAO extends DAO
{
    public function Create(User $user) : void
    {
        $sql = 'INSERT INTO `user`(`name`, `password`, `is_admin`) VALUES (?, ?, ?)';

        self::createQuery($sql, [
                $user->GetName(),
                $user->GetPassword(),
                $user->GetIsAdmin()
            ]);
    }

    public function Update(User $user) : void
    {
        $sql = 'UPDATE `user` SET `name`=?, `password`=?, `is_admin`=? WHERE `user_id` = ?';

        self::createQuery($sql, [
                $user->GetName(),
                $user->GetPassword(),
                $user->GetIsAdmin(),
                $user->GetID()
            ]);
    }

    public function Delete(User $user) : void
    {
        $sql = 'DELETE FROM `user` WHERE user_id = ?';
        self::createQuery($sql, [$user->GetID()]);
    }

    private function ReadBy(string $key, string $value) : ?User
    {
        $sql = 'SELECT `user_id`, `name`, `password`, `registered`, `is_admin` FROM user WHERE '.$key.' = ?';
        $data = self::createQuery($sql, [$value]);
        
        $result = $data->fetch(PDO::FETCH_ASSOC);
        if(!$result)
            return null;
        
        $user = new User();
        $user->SetID(                   $result['user_id']      );
        $user->SetName(                 $result['name']         );
        $user->SetPassword(             $result['password']     );
        $user->SetRegisteredString(     $result['registered']   );
        $user->SetIsAdmin(              $result['is_admin']     );

        return $user;
    }

    public function ReadByID(int $id) : ?User
    {
        return self::ReadBy('user_id', (string) $id);
    }

    public function ReadByName(string $name) : ?User
    {
        return self::ReadBy('name', $name);
    }
}

?>