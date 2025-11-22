<?php

namespace App\Entities;

/**
 * Setting entity
 *
 * Represents application settings and metadata
 */
final class SettingEntity
{
    private int $id;
    private string $title;
    private string $keywords;
    private string $description;
    private string $author;
    private string $logo;
    private string $footer;

    public function __construct(array $item)
    {
        $this->id = (int)$item['id'];
        $this->title = (string)$item['title'];
        $this->keywords = (string)$item['keywords'];
        $this->description = (string)$item['description'];
        $this->author = (string)$item['author'];
        $this->logo = (string)$item['logo'];
        $this->footer = (string)$item['footer'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'keywords' => $this->keywords,
            'description' => $this->description,
            'author' => $this->author,
            'logo' => $this->logo,
            'footer' => $this->footer,
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getKeywords(): string
    {
        return $this->keywords;
    }

    public function setKeywords(string $keywords): void
    {
        $this->keywords = $keywords;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): void
    {
        $this->logo = $logo;
    }

    public function getFooter(): string
    {
        return $this->footer;
    }

    public function setFooter(string $footer): void
    {
        $this->footer = $footer;
    }
}