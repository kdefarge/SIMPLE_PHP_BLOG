<?php

namespace app\model;

use PDO;

class CommentDAO extends DAO
{
    public function Create(Comment $comment) : void
    {
        $sql = 'INSERT INTO `comment`'
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
        $sql = 'UPDATE `comment` SET '
            .  '`is_valid`=?'
            .  ' WHERE `comment_id` = ?';

        self::createQuery($sql, [
                $isValid,
                $commentID
            ]);
    }

    public function Delete(int $commentID) : void
    {
        $sql = 'DELETE FROM `comment` WHERE comment_id = ?';
        self::createQuery($sql, [$commentID]);
    }

    public function ReadList(int $postID, int $offset = 0, int $limit = 10, bool $isValid = true) : array
    {
        $sql = 'SELECT c.`comment_id`, c.`user_id`, c.`post_id`, c.`text`, c.`posted`, c.`is_valid`, '
            .  'u.`name`, u.`is_admin` FROM comment c '
            .  'LEFT JOIN user u ON u.`user_id` = c.`user_id` '
            .  'WHERE `post_id` = ? '
            .  ( $isValid ? 'AND `is_valid` == 1 ' : '' )
            .  'ORDER BY `comment_id` DESC '
            .  'LIMIT '.$offset.', '.$limit;
        $data = self::createQuery($sql, [$postID]);
        
        $comments = [];

        while ($array = $data->fetch(PDO::FETCH_ASSOC))
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
            $comment->SetUser(          $user                   );
            $comment->SetPost(          $post                   );
            $comment->SetText(          $array['text']          );
            $comment->SetPostedString(  $array['posted']        );
            $comment->SetIsValid(       $array['is_valid']      );
            
            $comments[] = $comment;
        }

        return $comments;
    }
}