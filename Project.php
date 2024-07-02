<?php

class Project
{

    public function __construct(protected string $title)
    {
        //
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function user()
    {

    }
}
