<?php
include 'koneksi.php';

$query = "SELECT * FROM produk";
$result = mysqli_query($conn, $query);

?>

<h1>Produk</h1>

<ul>
<?php while ($row = mysqli_fetch_assoc($result)) : ?>
 <li>
 <a href="tambah_keranjang.php?id=<?php echo $row['id']; ?>">
 <?php echo $row['nama_produk']; ?> (Rp <?php echo $row['harga']; ?>)
 </a>
 </li>
<?php endwhile; ?>
</ul>