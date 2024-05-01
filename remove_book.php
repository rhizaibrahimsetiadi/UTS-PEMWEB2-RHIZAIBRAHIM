<?php
require_once 'book.php';
require_once 'ReferenceBook.php';
require_once 'Library.php';

session_start();

if (isset($_POST['book_id'])) {
    $bookId = $_POST['book_id'];

    // Hapus buku dari session
    if (isset($_SESSION['library'])) {
        $library = $_SESSION['library'];
        $library->removeBook($bookId);
        $_SESSION['library'] = $library;
    }
}

// Redirect ke halaman utama
header("Location: index.php");
exit();
