<?php
require_once 'Library.php';

session_start();

// Include class definitions
require_once 'Library.php';

// Check if book_id is set in POST data
if (isset($_POST['book_id'])) {
    // Retrieve the book_id from POST data
    $bookId = $_POST['book_id'];

    // Retrieve library from session
    if (isset($_SESSION['library'])) {
        $library = $_SESSION['library'];

        // Borrow the book
        $borrowedBook = $library->returnBook($bookId);

        if ($borrowedBook) {
            echo "<p>Book return successfully.</p>";
            header("Location: index.php");
        } else {
            echo "<p>Failed to return the book.</p>";
            header("Location: index.php");
        }
    } else {
        echo "<p>Library not found.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
