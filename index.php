<?php
// Mulai sesi
require_once 'book.php';
require_once 'ReferenceBook.php';
require_once 'Library.php';
session_start();



// Jika formulir telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari formulir
    $titles = $_POST['title'];
    $authors = $_POST['author'];
    $years = $_POST['year'];
    $isbns = $_POST['isbn'];
    $publishers = $_POST['publisher'];

    // Membuat atau mendapatkan objek Library dari sesi
    if (isset($_SESSION['library'])) {
        $library = $_SESSION['library'];
    } else {
        $library = new Library();
    }

    // Loop melalui setiap buku yang disubmit
    foreach ($titles as $key => $title) {
        // Buat objek buku
        $book = new ReferenceBook($title, $authors[$key], $years[$key], $isbns[$key], $publishers[$key]);

        // Tambahkan buku ke dalam library
        $library->addBook($book);
    }

    // Simpan objek Library ke dalam sesi
    $_SESSION['library'] = $library;

    // Redirect ke halaman ini lagi untuk menghindari resubmission saat merefresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
</head>

<body class="container">
    <h1>Perpustakaan</h1>
    <div class="card">
        <div class="card-body">

            <h2>Add Book</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="add-book-form">
                <div id="book-inputs">
                    <!-- Input untuk buku pertama -->
                    <div class="book-input">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" name="title[]" required><br>
                        <label for="author" class="form-label">Author:</label>
                        <input type="text" name="author[]" required><br>
                        <label for="year" class="form-label">Year:</label>
                        <input type="number" name="year[]" min="1000" max="9999" required><br>
                        <label for="isbn" class="form-label">ISBN:</label>
                        <input type="text" name="isbn[]" required><br>
                        <label for="publisher" class="form-label">Publisher:</label>
                        <input type="text" name="publisher[]" required><br>
                    </div>
                </div>
                <!-- Tombol "Tambah Buku" -->
                <input type="submit" value="Simpan Buku" class="btn btn-success">
            </form>
        </div>
    </div>
    <form method="GET" action="search.php">
        <input type="text" name="keyword" placeholder="Masukkan kata kunci pencarian">
        <button type="submit" class="btn btn-success">Cari</button>
    </form>


    <?php
    if (isset($_SESSION['library'])) {
        $library = $_SESSION['library'];
        $books = $library->getBooks();
        foreach ($books as $key => $book) {
            echo "<p>Title: " . $book->getTitle() . "</p>";
            echo "<p>Author: " . $book->getAuthor() . "</p>";
            echo "<p>Year: " . $book->getYear() . "</p>";
            echo "<p>ISBN: " . $book->getIsbn() . "</p>";
            echo "<p>Publisher: " . $book->getPublisher() . "</p>";
            echo "<p>Status: " . $book->getStatus() . "</p>";
            // Tambahkan tombol hapus dengan mengirimkan id buku ke skrip remove_book.php
            echo "<form action='remove_book.php' method='post'>";
            echo "<input type='hidden' name='book_id' value='$key'>";
            echo "<input type='submit' value='Delete'class='btn btn-danger'>";
            echo "</form>";
            // Tambahkan formulir untuk meminjam buku
            echo "<form action='borrow_book.php' method='post'>";
            echo "<input type='hidden' name='book_id' value='$key'>";
            echo "<input type='submit' value='Borrow'class='btn btn-primary'>";
            echo "</form>";

            // Tambahkan formulir untuk mengembalikan buku
            echo "<form action='return_book.php' method='post'>";
            echo "<input type='hidden' name='book_id' value='$key'>";
            echo "<input type='submit' value='return'class='btn btn-warning'>";
            echo "</form>";
            echo "<hr>";
        }
    } else {
        echo "<p>No books available</p>";
    }
    ?>