<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "hasil_tangkapan";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nama                = "";
$tanggal_pergi       = "";
$tanggal_pulang      = "";
$hasil_tangkapan     = "";
$berat_tangkapan     = "";
$sukses              = "";
$error               = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $ID         = $_GET['ID'];
    $sql1       = "delete from nelayan where id = '$ID'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $ID         = $_GET['ID'];
    $sql1       = "select * from nelayan where id = '$ID'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nama                = $r1['nama'];
    $tanggal_pergi       = $r1['tanggal_pergi'];
    $tanggal_pulang      = $r1['tanggal_pulang'];
    $hasil_tangkapan     = $r1['hasil_tangkapan'];
    $berat_tangkapan     = $r1['berat_tangkapan'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nama                = $_POST['nama'];
    $tanggal_pergi       = $_POST['tanggal_pergi'];
    $tanggal_pulang      = $_POST['tanggal_pulang'];
    $hasil_tangkapan     = $_POST['hasil_tangkapan'];
    $berat_tangkapan     = $_POST['berat_tangkapan'];


    if ($nama && $tanggal_pergi && $tanggal_pulang && $hasil_tangkapan && $berat_tangkapan) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update nelayan set nama = '$nama',tanggal_pergi='$tanggal_pergi',tanggal_pulang = '$tanggal_pulang',hasil_tangkapan='$hasil_tangkapan' ,berat_tangkapan='$berat_tangkapan' where id = '$ID'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into nelayan(nama, tanggal_pergi, tanggal_pulang, hasil_tangkapan, berat_tangkapan) values ('$nama','$tanggal_pergi','$tanggal_pulang','$hasil_tangkapan','$berat_tangkapan')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nelayan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_pergi" class="col-sm-2 col-form-label">Tanggal Pergi</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggal_pergi" name="tanggal_pergi" value="<?php echo $tanggal_pergi ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal_pulang" class="col-sm-2 col-form-label">Tangga Pulang</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggal_pulang" name="tanggal_pulang" value="<?php echo $tanggal_pulang ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="hasil_tangkapan" class="col-sm-2 col-form-label">Hasil Tangkapan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="hasil_tangkapan" id="hasil_tangkapan">
                                <option value="">- Pilih -</option>
                                <option value="pelagis kecil" <?php if ($hasil_tangkapan == "pelagis kecil") echo "selected" ?>>pelagis kecil</option>
                                <option value="pelagis besar" <?php if ($hasil_tangkapan == "pelagis besar") echo "selected" ?>>pelagi besar</option>
                                <option value="karang" <?php if ($hasil_tangkapan == "karang") echo "selected" ?>>karang</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="berat_tangkapan" class="col-sm-2 col-form-label">Berat Tangkapan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="berat_tangkapan" name="berat_tangkapan" value="<?php echo $berat_tangkapan ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Nelayan
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Tanggal Pergi</th>
                            <th scope="col">Tanggal Pulang</th>
                            <th scope="col">Hasil tangkapan</th>
                            <th scope="col">Berat tangkapan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from nelayan order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) 
                        {
                            $ID                = $r2['ID'];
                            $nama              = $r2['nama'];
                            $tanggal_pergi     = $r2['tanggal_pergi'];
                            $tanggal_pulang    = $r2['tanggal_pulang'];
                            $hasil_tangkapan   = $r2['hasil_tangkapan'];
                            $berat_tangkapan   = $r2['berat_tangkapan'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $tanggal_pergi ?></td>
                                <td scope="row"><?php echo $tanggal_pulang ?></td>
                                <td scope="row"><?php echo $hasil_tangkapan ?></td>
                                <td scope="row"><?php echo $berat_tangkapan ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&ID=<?php echo $ID?>"><button type="button" class="btn btn-warning">edit</button></a>
                                    <a href="index.php?op=delete&ID=<?php echo $ID?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>