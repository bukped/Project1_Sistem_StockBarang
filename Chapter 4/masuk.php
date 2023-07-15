<?php
require 'function.php';
require 'cek.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Barang Masuk</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-warning">
        <a class="navbar-brand" href="index.php">STOCK BARANG</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>

    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-fw fa-tachometer-alt"></i></div>
                            Stock Barang
                        </a>
                        <a class="nav-link" href="data.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-fw fa-server"></i></div>
                            Data Barang
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-fw fa-cloud-download-alt"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-fw fa-cloud-upload-alt"></i></i></div>
                            Barang Keluar
                        </a>
                        <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-fw fa-sign-out-alt"></i></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <?php
        $queryBarang = "SELECT `masuk`.*, `jenis_barang`.`namaJenisBarang`
                        FROM `masuk` JOIN `jenis_barang`
                        ON `masuk`.`idbarang` = `jenis_barang`.`idbarang`
                            ";
        $data = mysqli_query($conn, $queryBarang);
        $forAll = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $i = 1;
        ?>

        <!-- $namabarang = $row['namaJenisBarang'];
        $gambar = $row['gambar'];
        $deskripsi = $row['keterangan_baru'];
        $stock = $row['qty'];
        $ndate = $row['formatted_enter'];
        $udate = $row['formatted_update'];
        $idb = $row['idmasuk'];
        $idbrg = $row['idbarang']; -->

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Barang Masuk</h1>

                    <!-- Button to Open the Modal -->
                    <div class="mt-5">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            TAMBAH BARANG MASUK +
                        </button>
                        <a href="cetak.php" class="btn btn-danger" target="_blank">CETAK<a>
                    </div>

                    <div class="mt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead class="bg-secondary text-white text-center">
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Nama Barang</th>
                                        <th class="align-middle">Gambar</th>
                                        <th class="align-middle">Ukuran</th>
                                        <th class="align-middle">Merk</th>
                                        <th class="align-middle">Stock Awal</th>
                                        <th class="align-middle">Stock Terbaru</th>
                                        <th class="align-middle">Tanggal Masuk</th>
                                        <th class="align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($forAll as $fa) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $fa['namaJenisBarang']; ?></td>
                                            <td><img src="img/<?= $fa['gambar']; ?>" width=100 title="<?= $fa['gambar']; ?>" alt=""></td>
                                            <td><?= $fa['ukuran']; ?></td>
                                            <td><?= $fa['merk']; ?></td>
                                            <td><?= $fa['qty'] ?></td>
                                            <td><?= $fa['qty_akhir'] ?></td>
                                            <td><?= $fa['ubah']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#edit<?= $fa['idmasuk']; ?>"><i class="fas fa-fw fa-edit"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm text-white" data-toggle="modal" data-target="#delete<?= $fa['idmasuk']; ?>"><i class="fas fa-fw fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>




    <!-- Edit Modal -->
    <?php foreach ($forAll as $fa) : ?>
        <div class="modal fade" id="edit<?= $fa['idmasuk']; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Barang</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <?php
                    $query = "SELECT * FROM jenis_barang";
                    $data = mysqli_query($conn, $query);
                    $barang = mysqli_fetch_all($data, MYSQLI_ASSOC);
                    ?>

                    <!-- Modal body -->
                    <form method="post">
                        <div class="modal-body">
                            <input type="hidden" name="idmasuk" value="<?= $fa['idmasuk']; ?>">
                            <div class="form-group row">
                                <label for="idmasuk" class="col-sm-3 col-form-label">Nama Barang</label>
                                <div class="col-sm-9">
                                    <select name="idmasuk" class="form-control">
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['idbarang'] == $fa['idbarang']) : ?>
                                                <option value="<?= $b['idbarang']; ?>" selected><?= $b['namaJenisBarang']; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $b['idbarang']; ?>"><?= $b['namaJenisBarang']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ukuran" class="col-sm-3 col-form-label">Ukuran</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="ukuran" id="ukuran" required disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="merk" class="col-sm-3 col-form-label">Merk</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="merk" id="merk" required disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input_stock" class="col-sm-3 col-form-label">Stock</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="input_stock" value="<?= $fa['update_qty']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="update_typo_stock">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>




    <!-- Delete Modal -->
    <?php foreach ($forAll as $fa) : ?>
        <div class="modal fade" id="delete<?= $fa['idmasuk'] ?>">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus barang?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <form method="post">
                        <input type="hidden" name="idmasuk" value="<?= $fa['idmasuk'] ?>">
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus penambahan stock yang berjumlah <?= $fa['update_qty'] ?> pada <?= $fa['namaJenisBarang']; ?>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger text-white" name="hapus_update_stock">Hapus</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    <?php endforeach; ?>




    <!-- Modal Tambah -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <?php
                $queryBarang = "SELECT `masuk`.*, `jenis_barang`.`namaJenisBarang`
                                  FROM `masuk` JOIN `jenis_barang`
                                    ON `masuk`.`idbarang` = `jenis_barang`.`idbarang`
                                    ";
                $data = mysqli_query($conn, $queryBarang);
                $result = mysqli_fetch_all($data, MYSQLI_ASSOC);
                ?>

                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="idmasuk" class="col-sm-3 col-form-label">Nama Barang</label>
                            <div class="col-sm-9">
                                <select name="idmasuk" class="form-control">
                                    <option></option>
                                    <?php foreach ($result as $r) : ?>
                                        <option value="<?= $r['idmasuk']; ?>" data-ukuran="<?= $r['ukuran']; ?>" data-merk="<?= $r['merk']; ?>"><?= $r['namaJenisBarang']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ukuran" class="col-sm-3 col-form-label">Ukuran</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="ukuran" id="ukuran" required disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="merk" class="col-sm-3 col-form-label">Merk</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="merk" id="merk" required disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="stock" class="col-sm-3 col-form-label">Stock</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="stock" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="stock_masuk">Tambah</button>
                    </div>
                </form>

            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            // Mendeteksi perubahan pada dropdown "Nama Barang"
            $('select[name="idmasuk"]').change(function() {
                // Mendapatkan nilai idmasuk terpilih
                var idmasuk = $(this).val();

                // Mencari data yang sesuai berdasarkan idmasuk terpilih
                var data = <?= json_encode($result); ?>;
                var selectedData = data.find(function(item) {
                    return item.idmasuk == idmasuk;
                });

                // Mengisi nilai ukuran dan merk
                $('#ukuran').val(selectedData.ukuran);
                $('#merk').val(selectedData.merk);
            });
        });
    </script>















    <a href="cetak3.php" target="_blank">CETAK</a>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>

</html>