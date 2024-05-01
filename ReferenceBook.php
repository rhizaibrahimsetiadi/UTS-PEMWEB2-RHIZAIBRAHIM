<?php
require_once 'book.php';

class ReferenceBook extends Book
{
    private $isbn;
    private $publisher;

    public function __construct($title, $author, $year, $isbn, $publisher)
    {
        parent::__construct($title, $author, $year);
        $this->isbn = $isbn;
        $this->publisher = $publisher;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function getPublisher()
    {
        return $this->publisher;
    }
}
