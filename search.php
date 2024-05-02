<?php
require_once 'book.php';
require_once 'ReferenceBook.php';
require_once 'Library.php';
// Pastikan session dimulai
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Buku</title>
    <!-- Sisipkan tautan ke file CSS Bootstrap -->
    <link href="path/to/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Hasil Pencarian Buku</h1>
        <?php
        // Cek apakah ada input pencarian
        if (isset($_GET['keyword'])) {
            // Tangkap keyword pencarian
            $keyword = $_GET['keyword'];

            // Lakukan pencarian menggunakan keyword
            $searchResults = $_SESSION['library']->searchBook($keyword);

            // Tampilkan hasil pencarian
            if (sizeof($searchResults) > 0) {
                foreach ($searchResults as $book) {
                    echo "<div class='list-group-item'>";
                    echo "<div class='d-flex'>";
                    echo "<div class='left text-start flex-grow-1'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>Title: " . $book->getTitle() . "</h5>";
                    echo "<h6 class='card-subtitle mb-2 text-body-secondary'>Author: " . $book->getAuthor()  . " - Years: " . $book->getYear() . "</h6>";
                    echo "<h6 class='card-subtitle mb-2 text-body-secondary'>Publisher: " . $book->getPublisher() . "</h6>";
                    echo "<h6 class='card-subtitle mb-2 text-body-secondary'>Status: " . $book->getStatus() . "</h6>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='right d-flex gap-2 align-items-center'>";
                    // Periksa apakah buku bisa dipinjam
                    if ($book instanceof NormalBook && !$book->borrowBook()) {
                        echo "<a type='button' class='btn btn-success btn-pinjam' data-bs-toggle='modal' data-bs-target='#modalPinjam' data-isbn='" . $book->getIsbn() . "'><i class='bi bi-bookmark-plus'></i></a>";
                    }
                    echo "<a type='button' class='btn btn-danger btn-hapus' data-bs-toggle='modal' data-bs-target='#modalHapus' data-isbn='" . $book->getIsbn() . "'><i class='bi bi-file-x'></i></a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "Tidak ada hasil yang ditemukan.";
            }
        } else {
            echo "Masukkan kata kunci pencarian.";
        }
        ?>
        <!-- Tombol Kembali -->
        <button onclick="window.location.href='index.php'" class="btn btn-success">Kembali ke Halaman Utama</button>


    </div>


</body>

</html>