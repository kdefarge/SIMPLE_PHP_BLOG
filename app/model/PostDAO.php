<?php

namespace app\model;

use PDO;

class PostDAO extends DAO
{
    public function Create(Post $post) : void
    {
        $sql = 'INSERT INTO `spb_article`'
            .  '(`user_id`, `title`, `header`, `content`, `publish`)'
            .  ' VALUES (?, ?, ?, ?, ?)';

        self::createQuery($sql, [
                $post->GetUser() === null ? null : $post->GetUser()->GetID(),
                $post->GetTitle(),
                $post->GetHeader(),
                $post->GetContent(),
                $post->GetPublish() === null ? null : $post->GetPublish()->format('Y-m-d H:i:s')
            ]);
    }

    public function Update(Post $post) : void
    {
        $sql = 'UPDATE `spb_article` SET '
            .  '`user_id`=?, `title`=?, `header`=?, `content`=?, `publish`=?'
            .  ' WHERE `post_id` = ?';

        self::createQuery($sql, [
                $post->GetUser() === null ? null : $post->GetUser()->GetID(),
                $post->GetTitle(),
                $post->GetHeader(),
                $post->GetContent(),
                $post->GetPublish() === null ? null : $post->GetPublish()->format('Y-m-d H:i:s'),
                $post->GetID()
            ]);
    }

    public function Delete(int $postid) : void
    {
        $sql = 'DELETE FROM `spb_article` WHERE post_id = ?';
        self::createQuery($sql, [$postid]);
    }

    public function ReadList(int $offset = 0, int $limit = 10, bool $only_published = true) : array
    {
        $sql = 'SELECT p.`post_id`, p.`user_id`, p.`title`, p.`header`, p.`content`, '
            .  'p.`publish`, p.`updated`, u.`name` FROM spb_article p '
            .  'LEFT JOIN spb_user u ON u.`user_id` = p.`user_id` '
            .  ( $only_published ? 'WHERE `publish` <= NOW() ' : '' )
            .  'ORDER BY `updated` DESC'
            .  ' LIMIT '.$offset.', '.$limit;
        $data = self::createQuery($sql);
        
        $posts = [];

        while ($array = $data->fetch(PDO::FETCH_ASSOC))
            $posts[] = $this->DataArrayToPost($array);
        
        return $posts;
    }

    public function ReadByID(int $id) : ?Post
    {
        $sql = 'SELECT p.`post_id`, p.`user_id`, p.`title`, p.`header`, p.`content`, '
            .  'p.`publish`, p.`updated`, u.`name` FROM spb_article p '
            .  'LEFT JOIN spb_user u ON u.`user_id` = p.`user_id` '
            .  'WHERE `post_id` = ?';
        $data = self::createQuery($sql, [$id]);

        $result = $data->fetch(PDO::FETCH_ASSOC);

        if($result)
            return $this->DataArrayToPost($result);
        return null;     
    }

    private function DataArrayToPost(array $array) : Post
    {
        if($array['user_id'] === null)
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

        if($array['publish'] !== null)
            $post->SetPublishString($array['publish']);
        
        return $post;
    }
}

?>