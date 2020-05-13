<?php

namespace app\model;

use PDO;

class PostDAO extends DAO
{
    public function Create(Post $post) : void
    {
        $sql = 'INSERT INTO `post`'
            .  '(`user_id`, `title`, `header`, `content`, `publish`)'
            .  ' VALUES (?, ?, ?, ?, ?)';

        self::createQuery($sql, [
                is_null($post->GetUser())?null:$post->GetUser()->GetID(),
                $post->GetTitle(),
                $post->GetHeader(),
                $post->GetContent(),
                is_null($post->GetPublish())?null:$post->GetPublish()->format('Y-m-d H:i:s')
            ]);
    }

    public function Update(Post $post) : void
    {
        $sql = 'UPDATE `post` SET '
            .  '`user_id`=?, `title`=?, `header`=?, `content`=?, `publish`=?'
            .  ' WHERE `post_id` = ?';

        self::createQuery($sql, [
                is_null($post->GetUser())?null:$post->GetUser()->GetID(),
                $post->GetTitle(),
                $post->GetHeader(),
                $post->GetContent(),
                is_null($post->GetPublish())?null:$post->GetPublish()->format('Y-m-d H:i:s'),
                $post->GetID()
            ]);
    }

    public function Delete(int $postid) : void
    {
        $sql = 'DELETE FROM `post` WHERE post_id = ?';
        self::createQuery($sql, [$postid]);
    }

    public function ReadList(int $offset = 0, int $limit = 10) : array
    {
        $sql = 'SELECT p.`post_id`, p.`user_id`, p.`title`, p.`header`, p.`content`, '
            .  'p.`publish`, p.`updated`, u.`name` FROM post p '
            .  'LEFT JOIN user u ON u.`user_id` = p.`user_id` '
            .  'ORDER BY `updated` DESC'
            .  ' LIMIT '.$offset.', '.$limit;
        $data = self::createQuery($sql);
        
        $posts = [];

        while ($array = $data->fetch(PDO::FETCH_ASSOC))
            $posts[] = $this->DataArrayToUser($array);
        
        return $posts;
    }

    public function ReadByID(int $id) : ?Post
    {
        $sql = 'SELECT p.`post_id`, p.`user_id`, p.`title`, p.`header`, p.`content`, '
            .  'p.`publish`, p.`updated`, u.`name` FROM post p '
            .  'LEFT JOIN user u ON u.`user_id` = p.`user_id` '
            .  'WHERE `post_id` = ?';
        $data = self::createQuery($sql, [$id]);

        $result = $data->fetch(PDO::FETCH_ASSOC);

        if($result)
            return $this->DataArrayToUser($result);
        return null;     
    }

    private function DataArrayToUser(array $array) : Post
    {
        if(is_null($array['user_id']))
        {
            $user = null;
        }
        else
        {
            $user = new User();
            $user->SetID(           $array['user_id']       );
            $user->SetName(         $array['name']          );
        }
        
        $post = new Post();
        $post->SetID(               $array['post_id']       );
        $post->SetUser(             $user                   );
        $post->SetTitle(            $array['title']         );
        $post->SetHeader(           $array['header']        );
        $post->SetContent(          $array['content']       );
        $post->SetUpdatedString(    $array['updated']       );

        if(!is_null($array['publish']))
            $post->SetPublishString($array['publish']);
        
        return $post;
    }
}

?>