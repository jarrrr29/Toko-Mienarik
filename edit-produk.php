<?php
session_start();
include 'db.php';
if ($_SESSION['status_login'] != true) {
	echo '<script>window.location="login.php"</script>';
}

$produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '" . $_GET['id'] . "' ");
if (mysqli_num_rows($produk) == 0) {
	echo '<script>window.location="data-produk.php"</script>';
}
$p = mysqli_fetch_object($produk);
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Kedaikopi</title>
	<link rel="stylesheet" type="text/css" href="styledash.css">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
</head>

<body>
	<!-- header -->
	<header>
		<div class="flex  w-full justify-around bg-white border-2 text-lg p-2 items-center">
			<div class="navbar-logo font-bold">
				<img src="gambar/LOGOACC.png" alt="logo" width="60px">
				<a class="text" href="dashboard.php">
					<h1 class="px-14">MieNarik</h1>
					<p>---- Sehati----</p>
				</a>
			</div>
			<ul class="flex ">
				<li class="mx-2 hover:text-gray-600"><a href="dashboard.php">Dashboard</a></li>
				<li class="mx-2 hover:text-gray-600"><a href="profil.php">Profil</a></li>
				<li class="mx-2 hover:text-gray-600"><a href="data-kategori.php">Data Kategori</a></li>
				<li class="mx-2 hover:text-gray-600"><a href="data-produk.php">Data Produk</a></li>
			</ul>
			<div class=" p-2 rounded-xl bg-red-600 text-white"><a href="keluar.php">LogOut</a></div>
		</div>
	</header>

	<!-- content -->
	<div class="w-full flex justify-center">
		<div class="w-[80%] mt-10">
			<h3 class="text-4xl font-semibold mb-5">Dashboard</h3>
			<hr>
			<div class="border-b border-gray-900/10 pb-12">
				<h1 class="mt-6 text-2xl font-semibold">Edit Data Produk</h1>
				<form action="" method="POST" enctype="multipart/form-data"
					class="mt-2 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
					<div class="sm:col-span-6">
						<label for="first-name"
							class="block text-sm font-medium leading-6 text-gray-900">Kategori</label>
						<div class="mt-2">
							<select
								class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
								name="kategori" required>
								<option value="">--Pilih--</option>
								<?php
								$kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
								while ($r = mysqli_fetch_array($kategori)) {
									?>
									<option value="<?php echo $r['category_id'] ?>" <?php echo ($r['category_id'] == $p->category_id) ? 'selected' : ''; ?>>
										<?php echo $r['category_name'] ?>
									</option>
								<?php } ?>
							</select>
						</div>

						<label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Nama
							Product</label>
						<div class="mt-2">
							<input type="text" name="nama" placeholder="Nama Produk"
								value="<?php echo $p->product_name ?>" required
								class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
						</div>


						<label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Harga</label>
						<div class="mt-2">
							<input type="text" name="harga" placeholder="Harga" value="<?php echo $p->product_price ?>"
								required
								class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
						</div>

						<div class="mt-2">
							<!-- <input type="file" name="gambar" class="input-control" required> -->
							<img src="produk/<?php echo $p->product_image ?>" width="100px">
							<input type="hidden" name="foto" value="<?php echo $p->product_image ?>">
							<input type="file" name="gambar" class="input-control">
						</div>

						<div class="mt-2">
							<textarea class="input-control" name="deskripsi"
								placeholder="Deskripsi"><?php echo $p->product_description ?></textarea>
						</div>

						<label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Status</label>
						<div class="mt-2">
							<select
								class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
								name="status">
								<option value="">--Pilih--</option>
								<option value="1" <?php echo ($p->product_status == 1) ? 'selected' : ''; ?>>Aktif
								</option>
								<option value="0" <?php echo ($p->product_status == 0) ? 'selected' : ''; ?>>Tidak Aktif
								</option>
							</select>
						</div>
					</div>
					<div
						class="cursor-pointer border bg-indigo-500 hover:bg-indigo-700 py-2 text-white rounded-xl text-center">
						<input type="submit" name="submit" value="Submit" class="btn">
					</div>
				</form>
				<?php
				if (isset($_POST['submit'])) {

					// data inputan dari form
					$kategori = $_POST['kategori'];
					$nama = $_POST['nama'];
					$harga = $_POST['harga'];
					$deskripsi = $_POST['deskripsi'];
					$status = $_POST['status'];
					$foto = $_POST['foto'];

					// data gambar yang baru
					$filename = $_FILES['gambar']['name'];
					$tmp_name = $_FILES['gambar']['tmp_name'];



					// jika admin ganti gambar
					if ($filename != '') {
						$type1 = explode('.', $filename);
						$type2 = $type1[1];

						$newname = 'produk' . time() . '.' . $type2;

						// menampung data format file yang diizinkan
						$tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

						// validasi format file
						if (!in_array($type2, $tipe_diizinkan)) {
							// jika format file tidak ada di dalam tipe diizinkan
							echo '<script>alert("Format file tidak diizinkan")</scrtip>';

						} else {
							unlink('./produk/' . $foto);
							move_uploaded_file($tmp_name, './produk/' . $newname);
							$namagambar = $newname;
						}

					} else {
						// jika admin tidak ganti gambar
						$namagambar = $foto;

					}

					// query update data produk
					$update = mysqli_query($conn, "UPDATE tb_product SET 
												category_id = '" . $kategori . "',
												product_name = '" . $nama . "',
												product_price = '" . $harga . "',
												product_description = '" . $deskripsi . "',
												product_image = '" . $namagambar . "',
												product_status = '" . $status . "'
												WHERE product_id = '" . $p->product_id . "'	");
					if ($update) {
						echo '<script>alert("Ubah data berhasil")</script>';
						echo '<script>window.location="data-produk.php"</script>';
					} else {
						echo 'gagal ' . mysqli_error($conn);
					}

				}
				?>
			</div>
		</div>
	</div>
	<script>
		CKEDITOR.replace('deskripsi');
	</script>
</body>

</html>