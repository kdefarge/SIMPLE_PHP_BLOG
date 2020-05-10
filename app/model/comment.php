<?php

namespace app\model;

use DateTime;

class Post
{
    private int $_commentID = 0;
    private int $_postID = 0;
    private int $_userID = 0;
    private ?string $_text = null;
    private ?Datetime $_posted = null;
    private bool $_isValid = false;

    public function GetID() : int
    {
        return $this->_commentID;
    }

    public function SetID(int $commentID) : void
    {
        $this->_commentID = $commentID;
    }

    public function GetPostID() : int
    {
        return $this->_postID;
    }

    public function SetPostID(int $postID) : void
    {
        $this->_postID = $postID;
    }

    public function GetUserID() : int
    {
        return $this->_userID;
    }

    public function SetUserID(int $userID) : void
    {
        $this->_userID = $userID;
    }

    public function GetText() : string
    {
        return $this->_text;
    }

    public function SetText(string $text) : void
    {
        $this->_text = $text;
    }

    public function GetPosted() : ?DateTime
    {
        return $this->_posted;
    }

    public function SetPosted(?DateTime $posted) : void
    {
        $this->_posted = $posted;
    }

    public function SetPostedString(string $posted) : void
    {
        $this->_posted = new DateTime($posted);
    }

    public function GetIsValid() : bool
    {
        return $this->_isValid;
    }

    public function SetIsValid(bool $isValid) : void
    {
        $this->_isValid = $isValid;
    }
}

?>