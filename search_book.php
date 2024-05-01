<?php
// Include class definitions
require_once 'book.php';
require_once 'ReferenceBook.php';
require_once 'Library.php';

// Mulai sesi
session_start();

// Inisialisasi variabel pencarian
$searchResults = [];

// Memeriksa apakah kata kunci pencarian tersedia
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    // Buat objek Library
    $library = new Library();

    // Lakukan pencarian buku berdasarkan kata kunci
    $searchResults = $library->searchBook($keyword);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>

<body>
    <h2>Search Results</h2>

    <?php
    if (!empty($searchResults)) {
        // Jika buku ditemukan, tampilkan hasil pencarian
        foreach ($searchResults as $book) {
            echo "<p>Title: " . $book->getTitle() . "</p>";
            echo "<p>Author: " . $book->getAuthor() . "</p>";
            echo "<p>Year: " . $book->getYear() . "</p>";
            echo "<p>ISBN: " . $book->getIsbn() . "</p>";
            echo "<p>Publisher: " . $book->getPublisher() . "</p>";
            echo "<hr>";
        }
    } else {
        // Jika tidak ada hasil pencarian
        echo "<p>No results found for '$keyword'.</p>";
    }
    ?>

    <a href="index.php">Back to Home</a>
</body>

</html>