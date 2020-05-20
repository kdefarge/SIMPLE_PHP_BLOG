<?php

namespace app\model;

use PDO;

class CommentDAO extends DAO
{
    public function Create(Comment $comment) : void
    {
        $sql = 'INSERT INTO `spb_comment`'
            .  '(`user_id`, `post_id`, `text`, `is_valid`)'
            .  ' VALUES (?, ?, ?, ?)';

        self::createQuery($sql, [
                $comment->GetUser()->GetID(),
                $comment->GetPost()->GetID(),
                $comment->GetText(),
                $comment->GetIsValid()
            ]);
    }

    public function UpdateValid(int $commentID, bool $isValid) : void
    {
        $sql = 'UPDATE `spb_comment` SET '
            .  '`is_valid`=?'
            .  ' WHERE `comment_id` = ?';

        self::createQuery($sql, [
                $isValid,
                $commentID
            ]);
    }

    public function Delete(int $commentID) : void
    {
        $sql = 'DELETE FROM `spb_comment` WHERE comment_id = ?';
        self::createQuery($sql, [$commentID]);
    }

    public function ReadList(int $postID) : array
    {
        $sql = 'SELECT c.`comment_id`, c.`user_id`, c.`post_id`, c.`text`, c.`posted`, c.`is_valid`, '
            .  'u.`name`, u.`is_admin` FROM spb_comment c '
            .  'LEFT JOIN spb_user u ON u.`user_id` = c.`user_id` '
            .  'WHERE `post_id` = ? '
            .  'ORDER BY `comment_id` DESC';
        $data = self::createQuery($sql, [$postID]);
        
        $comments = [];

        while ($array = $data->fetch(PDO::FETCH_ASSOC))
        {
            $comments[] = $this->DataArrayToComment($array);
        }

        return $comments;
    }

    public function ReadByID(int $CommentID) : ?Comment
    {
        $sql = 'SELECT c.`comment_id`, c.`user_id`, c.`post_id`, c.`text`, c.`posted`, c.`is_valid`, '
            .  'u.`name`, u.`is_admin` FROM spb_comment c '
            .  'LEFT JOIN spb_user u ON u.`user_id` = c.`user_id` '
            .  'WHERE `comment_id` = ? ';
        $data = self::createQuery($sql, [$CommentID]);
        if($array = $data->fetch(PDO::FETCH_ASSOC))
            return $this->DataArrayToComment($array);
        return null;
    }

    private function DataArrayToComment(array $array) : Comment
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
            $user->SetIsAdmin(      $array['is_admin']      );
        }
        
        $post = new Post();
        $post->SetID(               $array['post_id']       );

        $comment = new Comment();
        $comment->SetID(            $array['comment_id']    );
        $comment->SetUser(          $user                   );
        $comment->SetPost(          $post                   );
        $comment->SetText(          $array['text']          );
        $comment->SetPostedString(  $array['posted']        );
        $comment->SetIsValid(       $array['is_valid']      );

        return $comment;
    }
}