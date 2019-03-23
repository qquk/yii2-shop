<?php


namespace shop\entities\Shop;


class Meta
{
    public $title;

    public $keywords;

    public $description;

    public function __construct($title, $keywords, $description)
    {
        $this->title = $title;
        $this->keywords = $keywords;
        $this->description = $description;
    }

    /**
     * @return Meta
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Meta
     */
    public function setTitle(string $title): Meta
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param $keywords
     * @return Meta
     */
    public function setKeywords(string $keywords): Meta
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return Meta
     */
    public function setDescription(string $description): Meta
    {
        $this->description = $description;
        return $this;
    }



}