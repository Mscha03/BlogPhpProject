<?php

namespace App\Entities;

class SettingEntity
{
    private $id;
    private $title;
    private $keywords;
    private $description;
    private $author;
    private $logo;
    private $footer;

    /**
     * @param $id
     * @param $title
     * @param $keywords
     * @param $description
     * @param $author
     * @param $logo
     * @param $footer
     */
    public function __construct($item)
    {
        $this->id = $item['id'];
        $this->title = $item['title'];
        $this->keywords = $item['keywords'];
        $this->description = $item['description'];
        $this->author = $item['author'];
        $this->logo = $item['logo'];
        $this->footer = $item['footer'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @return mixed
     */
    public function getFooter()
    {
        return $this->footer;
    }


}
