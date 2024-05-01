<?php
require_once 'ReferenceBook.php';

class Library
{
    private $books = [];
    private $maxBooksPerUser = 3; // Batasan peminjaman buku per pengguna
    private $lateFeePerDay = 0.5; // Denda keterlambatan per hari

    public function addBook($book)
    {
        $this->books[] = $book;
    }
    public function getBooks()
    {
        return $this->books;
    }

    public function borrowBook($bookId)
    {
        foreach ($this->books as $book) {
            if ($book->getStatus() === "available") {
                $book->setStatus("borrowed");
                return $book;
            }
        }
        return null;
    }

    public function returnBook($bookId)
    {
        foreach ($this->books as $book) {
            if ($book->getStatus() === "borrowed") {
                $book->setStatus("available");
                return $book;
            }
        }
        return null;
    }

    public function printAvailableBooks()
    {
        // Mengurutkan daftar buku berdasarkan tahun terbit
        usort($this->books, function ($a, $b) {
            return $a->getYear() - $b->getYear();
        });

        foreach ($this->books as $book) {
            if ($book->getStatus() === "available") {
                echo "Title: " . $book->getTitle() . ", Author: " . $book->getAuthor() . ", Year: " . $book->getYear() . "\n";
            }
        }
    }

    public function searchBook($keyword)
    {
        $foundBooks = [];
        foreach ($this->books as $book) {
            // Cek apakah judul atau penulis mengandung kata kunci
            if (stripos($book->getTitle(), $keyword) !== false || stripos($book->getAuthor(), $keyword) !== false) {
                $foundBooks[] = $book;
            }
        }
        return $foundBooks;
    }

    public function setMaxBooksPerUser($maxBooks)
    {
        $this->maxBooksPerUser = $maxBooks;
    }

    public function setLateFeePerDay($lateFee)
    {
        $this->lateFeePerDay = $lateFee;
    }

    public function removeBook($bookId)
    {
        if (isset($this->books[$bookId])) {
            unset($this->books[$bookId]);
            return true;
        } else {
            return false; // Buku tidak ditemukan dalam library
        }
    }
}
