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

    public function Delete(int $userid) : void
    {
        $sql = 'DELETE FROM `user` WHERE user_id = ?';
        self::createQuery($sql, [$userid]);
    }

    public function ReadByID(int $id) : ?User
    {
        $sql = 'SELECT `user_id`, `name`, `password`, `registered`, `is_admin` FROM user WHERE `user_id` = ?';
        $data = self::createQuery($sql, [$id]);
        if($result = $data->fetch(PDO::FETCH_ASSOC))
            return $this->DataArrayToUser($result);
        return null;
    }

    public function ReadByName(string $name) : ?User
    {
        $sql = 'SELECT `user_id`, `name`, `password`, `registered`, `is_admin` FROM user WHERE `name` = ?';
        $data = self::createQuery($sql, [$name]);
        if($result = $data->fetch(PDO::FETCH_ASSOC))
            return $this->DataArrayToUser($result);
        return null;
    }

    public function ReadAdminList() : array
    {
        $sql = 'SELECT `user_id`, `name`, `password`, `registered`, `is_admin` FROM user WHERE `is_admin` = 1';
        $data = self::createQuery($sql);
        $users = [];
        while ($result = $data->fetch(PDO::FETCH_ASSOC))
            $users[] = $this->DataArrayToUser($result);
        return $users;
    }

    public function ReadList(int $offset = 0, int $limit = 10, string $orderBy = 'user_id', bool $desc = true) : array
    {
        $sql = 'SELECT `user_id`, `name`, `password`, `registered`, `is_admin` FROM user '
            .  'ORDER BY ? '.($desc?' DESC':'')
            .  ' LIMIT '.$offset.', '.$limit;
        $data = self::createQuery($sql, [$orderBy]);
        
        $users = [];

        while ($result = $data->fetch(PDO::FETCH_ASSOC))
            $users[] = $this->DataArrayToUser($result);
        
        return $users;
    }

    private function DataArrayToUser(array $array) : User
    {
        $user = new User();
        $user->SetID(                   $array['user_id']      );
        $user->SetName(                 $array['name']         );
        $user->SetPassword(             $array['password']     );
        $user->SetRegisteredString(     $array['registered']   );
        $user->SetIsAdmin(              $array['is_admin']     );

        return $user;
    }
}

?>