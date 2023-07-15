<?php
session_start();
//Membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

// File index.php
// Menambah Barang
if (isset($_POST['tambah_stock'])) {
    $nama_barang = $_POST['nama_barang'];
    $qty_awal = $_POST['stock_awal'];
    $ukuran = $_POST['ukuran'];
    $merk = $_POST['merk'];
    $code = $nama_barang . date("Ymd");
    $id = $_POST['idmasuk'];

    $query = "SELECT * FROM masuk WHERE ukuran = ? AND idbarang = ? AND merk = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sis", $ukuran, $nama_barang, $merk);
    $stmt->execute();
    $result = $stmt->get_result();

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM masuk WHERE idbarang='$nama_barang' AND ukuran='$ukuran'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['qty'];
    $stock_terbaru = $stocksekarang + $qty_awal;

    if ($_FILES["image"]["error"] === 4) {
        echo
        "<script> alert ('Image Does Not Exist'); </script>";
    }

    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));

    if ($result->num_rows > 0) {
        echo "Data is unique"; // Data unik
    } else {
        if (!in_array($imageExtension, $validImageExtension)) {
            echo
            "<script> alert ('Image Does Not Exist'); </script>";
        } else if ($fileSize > 1000000) {
            echo
            "<script> alert ('Image Size is Too Large'); </script>";
        } else {
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, 'img/' . $newImageName);

            $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, tanggal, gambar, ukuran, merk, code_barang, qty, qty_akhir) VALUES ('$nama_barang', CURRENT_TIMESTAMP(), '$newImageName', '$ukuran', '$merk', '$code', '$qty_awal', '$stock_terbaru')");
        }
    }

    if ($addtomasuk) {
        header('location:index.php');
    } else {
        echo "<script> alert ('Gagal'); </script>";
        header('location:index.php');
    }
};




// File index.php
//  Update Barang
if (isset($_POST['update_barang'])) {
    $idb = $_POST['idb'];
    $nama_barang = $_POST['nama_barang'];
    $qty_awal = $_POST['stock_awal'];
    $ukuran = $_POST['ukuran'];
    $merk = $_POST['merk'];

    $a = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idb'");
    $get_some = mysqli_fetch_array($a);
    $ukuran = $get_some['ukuran'];

    // Perbarui data barang termasuk gambar
    $update = mysqli_query($conn, "UPDATE masuk SET idbarang='$nama_barang', qty='$qty_awal', ukuran='$ukuran', merk='$merk' WHERE idmasuk='$idb' AND ukuran='$ukuran'");

    if ($update) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}




// File index.php
// Menghapus Barang
if (isset($_POST['hapusbarang'])) {
    $idmasuk = $_POST['idmasuk'];

    $a = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idmasuk'");
    $get_some = mysqli_fetch_array($a);
    $ukuran = $get_some['ukuran'];

    $hapus = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idmasuk' AND ukuran='$ukuran'");
    if ($hapus) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
};




// File masuk.php
// Menambah Stock
if (isset($_POST['stock_masuk'])) {
    $idmasuk = $_POST['idmasuk'];
    $stock = $_POST['stock'];

    $a = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idmasuk'");
    $get_some = mysqli_fetch_array($a, MYSQLI_ASSOC);
    $ukuran = $get_some['ukuran'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idmasuk' AND ukuran='$ukuran'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['qty_akhir'];
    $tambah_stock = $stocksekarang + $stock;

    $addtomasuk = mysqli_query($conn, "UPDATE masuk SET ubah=CURRENT_TIME(), update_qty='$stock', qty_akhir='$tambah_stock' WHERE idmasuk='$idmasuk'");

    if ($addtomasuk) {
        header('location: masuk.php');
    } else {
        echo "<script> alert('Gagal melakukan update barang baru'); </script>";
        header('location: masuk.php');
    }
}




// File masuk.php
// Merubah Typo Penambahan Stock
if (isset($_POST['update_typo_stock'])) {
    $idm = $_POST['idmasuk'];
    $goods = $_POST['nama_barang'];
    $stock = $_POST['input_stock'];

    $a = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $get_some = mysqli_fetch_array($a, MYSQLI_ASSOC);
    $ukuran = $get_some['ukuran'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm' AND ukuran='$ukuran'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['qty_akhir'];
    $tambah_stock = $stocksekarang + $stock;

    $addtomasuk = mysqli_query($conn, "UPDATE masuk SET ubah=CURRENT_TIME(), update_qty='$stock', qty_akhir='$tambah_stock' WHERE idmasuk='$idm' ");

    if ($addtomasuk) {
        header('location:masuk.php');
    } else {
        echo "<script> alert('Gagal melakukan update barang baru'); </script>";
        header('location:masuk.php');
    }
};




// File masuk.php
// Menghapus Penambahan Stock
if (isset($_POST['hapus_update_stock'])) {
    $idm = $_POST['idmasuk'];

    $a = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $get_some = mysqli_fetch_array($a, MYSQLI_ASSOC);
    $ukuran = $get_some['ukuran'];

    $getdatastock = mysqli_query($conn, "SELECT * from masuk where idmasuk='$idm' AND ukuran='$ukuran'");
    $data = mysqli_fetch_array($getdatastock);
    $stock_akhir = $data['qty_akhir'];
    $update_stock = $data['update_qty'];

    $selisih = $stock_akhir - $update_stock;

    $update_akhir = mysqli_query($conn, "UPDATE masuk SET ubah=CURRENT_TIME(), update_qty=0, qty_akhir='$selisih' WHERE idmasuk='$idm'");

    if ($update_akhir) {
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
}




// File keluar.php
// Menambah barang keluar
if (isset($_POST['tambah_barang_keluar'])) {
    $idmasuk = $_POST['idmasuk'];
    $idbarang = $_POST['idbarang'];
    $input_stock_ambil = $_POST['stock_ambil'];
    $nama_pengambil = $_POST['nama_pengambil'];

    $a = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idmasuk'");
    $get_some = mysqli_fetch_array($a, MYSQLI_ASSOC);
    $ukuran = $get_some['ukuran'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idmasuk' AND ukuran='$ukuran'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['qty_akhir'];

    $ambil_stock = $stocksekarang - $input_stock_ambil;

    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if (!in_array($imageExtension, $validImageExtension)) {
        echo "<script> alert('Image Does Not Exist'); </script>";
    } else if ($fileSize > 1000000) {
        echo "<script> alert('Image Size is Too Large'); </script>";
    } else {
        $buktiPengambilan = uniqid();
        $buktiPengambilan .= '.' . $imageExtension;
        move_uploaded_file($tmpName, 'penerima/' . $buktiPengambilan);

        $updatestockmasuk = mysqli_query($conn, "UPDATE masuk SET qty_akhir='$ambil_stock' WHERE idmasuk='$idmasuk'");
        $addtokeluar = mysqli_query($conn, "INSERT INTO barang_keluar (idmasuk, idbarang, keluar, penerima, gambarPenerima, tanggalKeluar) VALUES ('$idmasuk', '$idbarang', '$input_stock_ambil', '$nama_pengambil', '$buktiPengambilan', CURRENT_TIME())");
    }
    if ($addtokeluar && $updatestockmasuk) {
        header('location: keluar.php');
    } else {
        echo 'Gagal';
        header('location: keluar.php');
    }
}




// File keluar.php
// Merubah Typo Penambahan Stock
if (isset($_POST['ambil_typo_stock'])) {
    $idkeluar = $_POST['idkeluar'];
    $idmasuk = $_POST['idmasuk'];
    $goods = $_POST['nama_barang'];
    $stock = $_POST['input_stock'];
    $nama_pengambil = $_POST['nama_pengambil'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM masuk WHERE idbarang='$goods'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['qty_akhir'];

    $ambil_stock = $stocksekarang - $stock;

    $addtokeluar = mysqli_query($conn, "UPDATE barang_keluar SET tanggalKeluar=CURRENT_TIME(), keluar='$stock', penerima='$nama_pengambil' WHERE idbarang='$goods' ");

    $addtomasuk = mysqli_query($conn, "UPDATE masuk SET ubah=CURRENT_TIME(), qty_akhir='$ambil_stock' WHERE idbarang='$goods'");

    if ($addtokeluar && $addtomasuk) {
        header('location:keluar.php');
    } else {
        echo "<script> alert('Gagal melakukan update barang baru'); </script>";
        header('location:keluar.php');
    }
};




// File keluar.php
// Menghapus Pengambilan Stock
if (isset($_POST['hapus_ambil_stock'])) {
    $idm = $_POST['idmasuk'];
    $idk = $_POST['idkeluar'];

    $getdatastockmasuk = mysqli_query($conn, "SELECT * from masuk where idmasuk='$idm'");
    $datamasuk = mysqli_fetch_array($getdatastockmasuk);
    $getdatastockkeluar = mysqli_query($conn, "SELECT * from barang_keluar where idkeluar='$idk'");
    $datakeluar = mysqli_fetch_array($getdatastockkeluar);

    $stock_akhir = $datamasuk['qty_akhir'];
    $update_stock = $datakeluar['keluar'];

    $selisih = $stock_akhir + $update_stock;

    $update_akhir = mysqli_query($conn, "UPDATE masuk SET ubah=CURRENT_TIME(), qty_akhir='$selisih' WHERE idmasuk='$idm'");
    $hapus_data = mysqli_query($conn, "DELETE FROM barang_keluar WHERE idkeluar='$idk'");

    if ($update_akhir && $hapus_data) {
        header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
}


//Mengubah data barang keluar
if (isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select *from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
        if ($kurangistocknya && $updatenya) {
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
        if ($kurangistocknya && $updatenya) {
            header('location:keluar.php');
        } else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    }
}

//Menghapus barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok + $qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

    if ($update && $hapusdata) {
        header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
}

//Menambah barang baru pada data barang
if (isset($_POST['databarang'])) {
    $idbarang = $_POST['idbarang'];
    $namaJenisBarang = $_POST['namaJenisBarang'];

    $addtotable = mysqli_query($conn, "insert into jenis_barang (idbarang, namaJenisBarang) values( '$idbarang','$namaJenisBarang')");
    if ($addtotable) {
        header('location:data.php');
    } else {
        echo 'Gagal';
        header('location:data.php');
    }
};


// Menghapus barang masuk
// if (isset($_POST['hapusbarangmasuk'])) {
//     $idb = $_POST['idb'];
//     $qty = $_POST['kty'];
//     $idm = $_POST['idm'];

//     $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
//     $data = mysqli_fetch_array($getdatastock);
//     $stok = $data['stock'];

//     $selisih = $stok - $qty;

//     $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
//     $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

//     if ($update && $hapusdata) {
//         header('location:masuk.php');
//     } else {
//         header('location:masuk.php');
//     }
// }


// if (isset($_POST['index'])) {
    //     $idmasuk = $_POST['idmasuk'];
    //     $idbarang = $_POST['idbarang'];
    
    //     $penerima = $_POST['penerima'];
    
    //     $sisa = $_POST['sisa'];
    //     $out = $_POST['keluar'];
    
    //     if ($_FILES["image"]["error"] === 4) {
    //         echo
    //         "<script> alert ('Image Does Not Exist'); </script>";
    //     }
    //     $fileName = $_FILES["image"]["name"];
    //     $fileSize = $_FILES["image"]["size"];
    //     $tmpName = $_FILES["image"]["tmp_name"];
    
    //     $validImageExtension = ['jpg', 'jpeg', 'png'];
    //     $imageExtension = explode('.', $fileName);
    //     $imageExtension = strtolower(end($imageExtension));
    //     if (!in_array($imageExtension, $validImageExtension)) {
    //         echo
    //         "<script> alert ('Image Does Not Exist'); </script>";
    //     } else if ($fileSize > 1000000) {
    //         echo
    //         "<script> alert ('Image Size is Too Large'); </script>";
    //     } else {
    //         $newImageName = uniqid();
    //         $newImageName .= '.' . $imageExtension;
    //         move_uploaded_file($tmpName, 'penerima/' . $newImageName);
    
    //         $update = mysqli_query($conn, "update masuk set qty = qty - $out where idbarang='$idbarang'");
    //         $ambilki = mysqli_query($conn, "insert into barang_keluar (idmasuk, idbarang, keluar, penerima, gambarPenerima, tanggalKeluar) values('$idmasuk', '$idbarang', '$out','$penerima','$newImageName', '$complete')");
    //     }
    //     if ($update && $ambilki) {
    //         header('location:index.php');
    //     } else {
    //         echo 'Gagal';
    //         header('location:index.php');
    //     }
    // }
    
    // if (isset($_POST['updatebarangkeluar'])) {
    //     $idmasuk = $_POST['idmasuk'];
    //     $idbarang = $_POST['idbarang'];
    //     $idkeluar = $_POST['idkeluar'];
    
    //     $penerima = $_POST['penerima'];
    
    //     $sisa = $_POST['sisa'];
    //     $out = $_POST['keluar'];
    
    //     $update = mysqli_query($conn, "update masuk set qty = qty - $out where idbarang='$idbarang'");
    //     $ambilki = mysqli_query($conn, "update barang_keluar set idbarang='$idbarang',idmasuk='$idmasuk', keluar='$out', penerima='$penerima', tanggalKeluar='$complete' where idkeluar='$idkeluar'");
    //     if ($update && $ambilki) {
    //         header('location:index.php');
    //     } else {
    //         echo 'Gagal';
    //         header('location:index.php');
    //     }
    // }
    
    // #Mengubah data barang masuk
    // if (isset($_POST['updatebarangmasuk'])) {
    //     $idb = $_POST['idb'];
    //     $idm = $_POST['idm'];
    //     $deskripsi = $_POST['keterangan'];
    //     $qty = $_POST['qty'];
    
    //     $lihatstock = mysqli_query($conn, "select *from stock where idbarang='$idb'");
    //     $stocknya = mysqli_fetch_array($lihatstock);
    //     $stockskrng = $stocknya['stock'];
    
    //     $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    //     $qtynya = mysqli_fetch_array($qtyskrg);
    //     $qtyskrg = $qtynya['qty'];
    
    //     if ($qty > $qtyskrg) {
    //         $selisih = $qty - $qtyskrg;
    //         $kurangin = $stockskrg + $selisih;
    //         $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
    //         $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
    //         if ($kurangistocknya && $updatenya) {
    //             header('location:masuk.php');
    //         } else {
    //             echo 'Gagal';
    //             header('location:masuk.php');
    //         }
    //     } else {
    //         $selisih = $qtyskrg - $qty;
    //         $kurangin = $stockskrg - $selisih;
    //         $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
    //         $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
    //         if ($kurangistocknya && $updatenya) {
    //             header('location:masuk.php');
    //         } else {
    //             echo 'Gagal';
    //             header('location:masuk.php');
    //         }
    //     }
    // }