<!DOCTYPE html>
<html>

<head>
    <title>CETAK PRINT DATA</title>
</head>

<body>

    <center>

        <h2>BARANG MASUK</h2>

    </center>

    <?php
    include 'function.php';
    ?>

<?php
    $queryBarang = "SELECT `masuk`.*, `jenis_barang`.`namaJenisBarang`
    FROM `masuk` JOIN `jenis_barang`
    ON `masuk`.`idbarang` = `jenis_barang`.`idbarang`
                            ";
    $data = mysqli_query($conn, $queryBarang);
    $result = mysqli_fetch_all($data, MYSQLI_ASSOC);
    $i = 1;
    ?>

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" border="1" style="width:100%">
        <thead>
            <tr>
                <th class="align-middle">No</th>
                <th class="align-middle">Nama Barang</th>
                <th class="align-middle">Gambar</th>
                <th class="align-middle">Ukuran</th>
                <th class="align-middle">Merk</th>
                <th class="align-middle">Stock Awal</th>
                <th class="align-middle">Stock Terbaru</th>
                <th class="align-middle">Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $r) : ?>
                <tr>
                <td><?= $i++; ?></td>
                <td><?= $r['namaJenisBarang']; ?></td>
                <td><img src="img/<?= $r['gambar']; ?>" width=100 title="<?= $r['gambar']; ?>" alt=""></td>
                <td><?= $r['ukuran']; ?></td>
                <td><?= $r['merk']; ?></td>
                <td><?= $r['qty'] ?></td>
                <td><?= $r['qty_akhir'] ?></td>
                <td><?= $r['ubah']; ?></td>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        window.print();
    </script>

</body>

</html>