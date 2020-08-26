<!DOCTYPE html>
<html>
<head>
    <title>Pendataan Santri</title>
    <link rel="icon" href="htdocs/pemweb/m6/icons8-squared-menu-25.png"/>
    <link rel="stylesheet" href="modul6.css">
</head>
<body>
    <br>
    <center><h2>APLIKASI PENDATAAN SANTRI TPQ MIFTAKHUL ULUM</h2></center>
<?php
// --- koneksi ke database
$koneksi = mysqli_connect("localhost","root","","webtpq7") or die (mysqli_error());

// --- Fngsi tambah data (Create)
function tambah($koneksi){
    
    if (isset($_POST['btn_simpan'])){
        $id_santri = time();
        $nm_santri = $_POST['nm_santri'];
        $jk = $_POST['jk'];
        $tingkat = $_POST['tingkat'];
        $tgl_lahir = $_POST['tgl_lahir'];
        
        if(!empty($nm_santri) && !empty($jk) && !empty($tingkat) && !empty($tgl_lahir)){
            $sql = "INSERT INTO data_santri (id_santri,nama_santri,jenis_kelamin, tingkat_santri, tanggal_lahir) VALUES (".$id_santri.",'".$nm_santri."','".$jk."','".$tingkat."','".$tgl_lahir."')";
            $simpan = mysqli_query($koneksi, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: indexx.php');
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
        <form action="" method="POST">
            <fieldset>
                <legend><h2>Tambah data</h2></legend>
                <label>Nama Santri <input type="text" name="nm_santri" /></label> <br>
                <label>Jenis Kelamin <input type="text" name="jk" /></label><br>
                <label>Tingkat Santri <input type="text" name="tingkat" /></label> <br>
                <label>Tanggal Lahir <input type="date" name="tgl_lahir" /></label> <br>
                <br>
                <label>
                    <input type="submit" name="btn_simpan" value="Simpan"/>
                    <input type="reset" name="reset" value="Besihkan"/>
                </label>
                <br>
                <p><?php echo isset($pesan) ? $pesan : "" ?></p>
            </fieldset>
        </form>
    <?php
}
// --- Tutup Fngsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($koneksi){
    $sql = "SELECT * FROM data_santri";
    $query = mysqli_query($koneksi, $sql);
    
    echo "<fieldset>";
    echo "<legend><h2>Data Santri</h2></legend>";
    
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>Id Santri</th>
            <th>Nama Santri</th>
            <th>Jenis Kelamin</th>
            <th>Tingkat Santri</th>
            <th>Tanggal Lahir</th>
            <th>Akses</th>
          </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['id_santri']; ?></td>
                <td><?php echo $data['nama_santri']; ?></td>
                <td><?php echo $data['jenis_kelamin']; ?></td>
                <td><?php echo $data['tingkat_santri']; ?></td>
                <td><?php echo $data['tanggal_lahir']; ?></td>
                <td>
                    <a href="indexx.php?aksi=update&id_santri=<?php echo $data['id_santri']; ?>&nama=<?php echo $data['nama_santri']; ?>&jenkel=<?php echo $data['jenis_kelamin']; ?>&tingkat=<?php echo $data['tingkat_santri']; ?>&tanggal=<?php echo $data['tanggal_lahir']; ?>">Ubah</a> |
                    <a href="indexx.php?aksi=delete&id_santri=<?php echo $data['id_santri']; ?>">Hapus</a>
                </td>
            </tr>
        <?php
    }
    echo "</table>";
    echo "</fieldset>";
}
// --- Tutup Fungsi Baca Data (Read)

// --- Fungsi Ubah Data (Update)
function ubah($koneksi){
    // ubah data
    if(isset($_POST['btn_ubah'])){
        $id_santri = $_POST['id_santri'];
        $nm_santri = $_POST['nm_santri'];
        $jk = $_POST['jk'];
        $tingkat = $_POST['tingkat'];
        $tgl_lahir = $_POST['tgl_lahir'];
        
        if(!empty($nm_santri) && !empty($jk) && !empty($tingkat) && !empty($tgl_lahir)){
            $perubahan = "nama_santri=".$nm_santri.",jenis_kelamin=".$jk.",tingkat_santri=".$tingkat.",tanggal_lahir='".$tgl_lahir."'";
            $sql_update = "UPDATE data_santri SET ".$perubahan." WHERE id_santri=$id_santri";
            $update = mysqli_query($koneksi, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('location: indexx.php');
                }
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    
    // tampilkan form ubah
    if(isset($_GET['id_santri'])){
        ?>
            <a href="indexx.php"> &laquo; Home</a> | 
            <a href="indexx.php?aksi=create"> (+) Tambah Data</a>
            <hr>
            
            <form action="" method="POST">
            <fieldset>
                <legend><h2>Ubah data</h2></legend>
                <input type="hidden" name="id_santri" value="<?php echo $_GET['id_santri'] ?>"/>
                <label>Nama Santri <input type="text" name="nm_santri" value="<?php echo $_GET['nama'] ?>"/></label> <br>
                <label>Jenis Kelamin <input type="text" name="jk" value="<?php echo $_GET['jenkel'] ?>"/></label><br>
                <label>Tingkat Santri <input type="text" name="tingkat" value="<?php echo $_GET['tingkat'] ?>"/></label> <br>
                <label>Tanggal Lahir <input type="date" name="tgl_lahir" value="<?php echo $_GET['tanggal'] ?>"/></label> <br>
                <br>
                <label>
                    <input type="submit" name="btn_ubah" value="Simpan Perubahan"/> atau <a href="indexx.php?aksi=delete&id_santri=<?php echo $_GET['id_santri'] ?>"> (x) Hapus data ini</a>!
                </label>
                <br>
                <p><?php echo isset($pesan) ? $pesan : "" ?></p>
                
            </fieldset>
            </form>
        <?php
    }
    
}
// --- Tutup Fungsi Update

// --- Fungsi Delete
function hapus($koneksi){
    if(isset($_GET['id_santri']) && isset($_GET['aksi'])){
        $id_santri = $_GET['id_santri'];
        $sql_hapus = "DELETE FROM data_santri WHERE id_santri=" . $id_santri;
        $hapus = mysqli_query($koneksi, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                header('location: indexx.php');
            }
        }
    }
    
}
// --- Tutup Fungsi Hapus
// ===================================================================
// --- Program Utama
if (isset($_GET['aksi'])){
    switch($_GET['aksi']){
        case "create":
            echo '<a href="indexx.php"> &laquo; Home</a>';
            tambah($koneksi);
            break;
        case "read":
            tampil_data($koneksi);
            break;
        case "update":
            ubah($koneksi);
            tampil_data($koneksi);
            break;
        case "delete":
            hapus($koneksi);
            break;
        default:
            echo "<h3>Aksi <i>".$_GET['aksi']."</i> tidak ada!</h3>";
            tambah($koneksi);
            tampil_data($koneksi);
    }
} else {
    tambah($koneksi);
    tampil_data($koneksi);
}
?>
</body>
</html>