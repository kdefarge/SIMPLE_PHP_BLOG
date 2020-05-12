<?php

namespace app\model;

use DateTime;

class Comment
{
    private int $_commentID = 0;
    private ?Post $_post = null;
    private ?User $_user = null;
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

    public function GetPost() : ?Post
    {
        return $this->_post;
    }

    public function SetPost(?Post $post) : void
    {
        $this->_post = $post;
    }

    public function GetUser() : ?User
    {
        return $this->_user;
    }

    public function SetUser(?User $user) : void
    {
        $this->_user = $user;
    }

    public function GetText() : ?string
    {
        return $this->_text;
    }

    public function SetText(?string $text) : void
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