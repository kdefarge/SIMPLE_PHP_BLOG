<?php

namespace app\model;

use DateTime;

class Post
{
    private int $_postID = 0;
    private int $_userID = 0;
    private ?string $_title = null;
    private ?string $_header = null;
    private ?string $_content = null;
    private ?Datetime $_publish = null;
    private ?Datetime $_updated = null;

    public function GetID() : int
    {
        return $this->_postID;
    }

    public function SetID(int $postID) : void
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

    public function GetTitle() : string
    {
        return $this->_title;
    }

    public function SetTitle(string $title) : void
    {
        $this->_title = $title;
    }

    public function GetHeader() : string
    {
        return $this->_header;
    }

    public function SetHeader(string $header) : void
    {
        $this->_header = $header;
    }

    public function GetContent() : string
    {
        return $this->_content;
    }

    public function SetContent(string $content) : void
    {
        $this->_content = $content;
    }

    public function GetPublish() : ?DateTime
    {
        return $this->_publish;
    }

    public function SetPublish(?DateTime $publish) : void
    {
        $this->_publish = $publish;
    }

    public function SetPublishString(string $publish) : void
    {
        $this->_publish = new DateTime($publish);
    }

    public function GetUpdated() : ?DateTime
    {
        return $this->_updated;
    }

    public function SetUpdated(?DateTime $updated) : void
    {
        $this->_updated = $updated;
    }

    public function SetUpdatedString(string $updated) : void
    {
        $this->_updated = new DateTime($updated);
    }
}

?>