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
    <title>Stock Barang</title>
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
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
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
        $result = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $i = 1;
        ?>

        <!-- $namabarang = $data['namaJenisBarang'];
        $gambar = $data['gambar'];
        $ukuran = $data['ukuran'];
        $merk = $data['merk'];
        $deskripsi = $data['keterangan'];
        $stock = $data['qty'];
        $ndate = $data['formatted_enter'];
        $udate = $data['formatted_update'];
        $idb = $data['idmasuk'];
        $idbrg = $data['idbarang']; -->




        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Stock Barang</h1>

                    <div class="mt-4">
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            TAMBAH BARANG
                        </button>
                        <a href="cetak.php" class="btn btn-danger" target="_blank">CETAK<a>
                    </div>

                    <div class="mt-3">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead class="bg-secondary text-white text-center">
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Code Barang</th>
                                        <th class="align-middle">Nama Barang</th>
                                        <th class="align-middle">Gambar</th>
                                        <th class="align-middle">Ukuran</th>
                                        <th class="align-middle">Merk</th>
                                        <th class="align-middle">Stock Awal</th>
                                        <th class="align-middle">Stock Terbaru</th>
                                        <th class="align-middle">Tanggal</th>
                                        <th class="align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result as $r) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $r['code_barang']; ?></td>
                                            <td><?= $r['namaJenisBarang']; ?></td>
                                            <td><img src="img/<?= $r['gambar']; ?>" width=100 title="<?= $r['gambar']; ?>" alt=""></td>
                                            <td><?= $r['ukuran']; ?></td>
                                            <td><?= $r['merk']; ?></td>
                                            <td><?= $r['qty']; ?></td>
                                          
                                            <td><?= $r['qty_akhir']; ?></td>
                                            <td><?= $r['ubah']; ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#edit<?= $r['idmasuk']; ?>"><i class="fas fa-fw fa-edit"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm mt-1" data-toggle="modal" data-target="#delete<?= $r['idmasuk']; ?>"><i class="fas fa-fw fa-trash-alt"></i></button>
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

    <?php foreach ($result as $r) : ?>
        <!-- Edit Modal -->
        <div class="modal fade" id="edit<?= $r['idmasuk']; ?>">
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
                            <input type="hidden" name="idb" value="<?= $r['idmasuk']; ?>">
                            <div class="form-group row">
                                <label for="nama_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                                <div class="col-sm-9">
                                    <select name="nama_barang" class="form-control">
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['idbarang'] == $r['idbarang']) : ?>
                                                <option value="<?= $b['idbarang']; ?>" selected><?= $b['namaJenisBarang']; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $b['idbarang']; ?>"><?= $b['namaJenisBarang']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stock_awal" class="col-sm-3 col-form-label">Stock</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="stock_awal" value="<?= $r['qty']; ?>" required>
                                </div>
                            </div>
                            <div class=" form-group row">
                                <label for="ukuran" class="col-sm-3 col-form-label">Ukuran</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="ukuran" value="<?= $r['ukuran']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="merk" class="col-sm-3 col-form-label">Merk</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="merk" value="<?= $r['merk']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-sm-3 col-form-label">Gambar</label>
                                <div class="col-sm-9">
                                    <?php if ($r['gambar']) : ?>
                                        <img src="img/<?= $r['gambar']; ?>" alt="Current Image" style="max-width: 200px; margin-top: 15px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="update_barang">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>




    <!-- Delete Modal -->
    <?php foreach ($result as $r) : ?>
        <div class="modal fade" id="delete<?= $r['idmasuk'] ?>">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus barang?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <form method="post">
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus <?= $r['namaJenisBarang']; ?>?
                            <input type="hidden" name="idmasuk" value="<?= $r['idmasuk'] ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger text-white" name="hapusbarang">Hapus</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Add Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <?php
                $query = "SELECT * FROM jenis_barang";
                $data = mysqli_query($conn, $query);
                $barang = mysqli_fetch_all($data, MYSQLI_ASSOC);
                ?>
                
                <!-- Modal body -->
                <form method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="idmasuk" value="<?= $fa['idmasuk']; ?>">
                        <div class="form-group row">
                            <label for="nama_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                            <div class="col-sm-9">
                                <select name="nama_barang" class="form-control">
                                    <option></option>
                                    <?php foreach ($barang as $b) : ?>
                                        <option value="<?= $b['idbarang']; ?>"><?= $b['namaJenisBarang']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="stock_awal" class="col-sm-3 col-form-label">Stock</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="stock_awal" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ukuran" class="col-sm-3 col-form-label">Ukuran</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="ukuran" maxlength="30" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="merk" class="col-sm-3 col-form-label">Merk</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="merk" maxlength="30" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label">Pilih Gambar</label>
                            <div class="col-sm-9">
                                <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png" maxlength="30" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="tambah_stock">Tambah</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
</body>

</html>