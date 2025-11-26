<?php

namespace App\Entities;

/**
 * Post entity
 *
 * Represents a blog post with all its properties
 */
final class PostEntity
{
    private int $id;
    private string $title;
    private string $content;
    private string $category;
    private int $view;
    private string $image;
    private string $date;

    public function __construct(array $item)
    {
        $this->id = (int)$item['id'];
        $this->title = (string)$item['title'];
        $this->content = (string)$item['content'];
        $this->category = (string)$item['category'];
        $this->view = (int)$item['view'];
        $this->image = (string)$item['image'];
        $this->date = (string)$item['date'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category,
            'view' => $this->view,
            'image' => $this->image,
            'date' => $this->date,
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getExcerpt(int $count = 200): string
    {
        return substr($this->content, 0, $count) . '...';
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getView(): int
    {
        return $this->view;
    }

    public function setView(int $view): void
    {
        $this->view = $view;
    }

    public function incrementView(): void
    {
        $this->view++;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getTimestamp(): int
    {
        return strtotime($this->date);
    }
}