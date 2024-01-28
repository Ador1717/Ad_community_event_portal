<?php

namespace model;

class event
{
    public $event_id;
    public $title;
    public $description;
    public $picture_path;
    public $user_id;
    public $post_time;

    public function __construct() {
    }

    public function getEventId()
    {
        return $this->event_id;
    }

    public function setEventId($event_id)
    {
        $this->event_id = $event_id;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getPicturePath()
    {
        return $this->picture_path;
    }

    public function setPicturePath($picture_path)
    {
        $this->picture_path = $picture_path;
        return $this;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getPostTime()
    {
        return $this->post_time;
    }

    public function setPostTime($post_time)
    {
        $this->post_time = $post_time;
        return $this;
    }





}