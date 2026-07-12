<?php

include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_array(
mysqli_query(
$conn,
"SELECT * FROM buku_anak WHERE id='$id'"
)
);

if(isset($_POST['update'])){

mysqli_query(
$conn,

"UPDATE buku_anak SET

judul='$_POST[judul]',
penulis='$_POST[penulis]',
kategori='$_POST[kategori]',
usia='$_POST[usia]',
deskripsi='$_POST[deskripsi]'

WHERE id='$id'"
);

header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

<div class="card">

<h2>Edit Buku</h2>

<form method="POST">

<input type="text" name="judul"
value="<?= $data['judul']; ?>">

<input type="text" name="penulis"
value="<?= $data['penulis']; ?>">

<input type="text" name="kategori"
value="<?= $data['kategori']; ?>">

<input type="text" name="usia"
value="<?= $data['usia']; ?>">

<textarea name="deskripsi"><?= $data['deskripsi']; ?></textarea>

<button type="submit" name="update">
Update
</button>

</form>

</div>

</div>

</body>
</html>