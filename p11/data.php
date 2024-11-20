
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Data Anggota</h2>
        <a href="tambah.php" class="btn btn-primary mb-3">Tambah Data</a>
        <table id="myTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('koneksi.php');

                $query = "SELECT * FROM anggota ORDER BY id DESC";
                $stmt = mysqli_prepare($koneksi, $query);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['no_telp']; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm edit-data"><i class="fa fa-edit"></i> Edit</a>
                                <a href="proses.php?aksi=hapus&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm hapus-data" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i> Hapus</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6">Tidak ada data ditemukan</td>
                    </tr>
                    <?php
                }
                mysqli_close($koneksi);
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script type="text/javascript">
$(document).ready(function() {
    $("#example").DataTable();
});

function reset() {
    document.getElementById("err_nama").innerHTML = "";
    document.getElementById("err_jenis_kelamin").innerHTML = "";
    document.getElementById("err_alamat").innerHTML = "";
    document.getElementById("err_no_telp").innerHTML = "";
}

$(document).on('click', '.edit_data', function() {
    $('html, body').animate({ scrollTop: 0 }, 'slow');
    var id = $(this).attr('id');

    $.ajax({
        type: "POST",
        url: "get_data.php",
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            reset();
            $('html, body').animate({ scrollTop: 30 }, 'slow');
            document.getElementById("id").value = response.id;
            document.getElementById("nama").value = response.nama;
            document.getElementById("alamat").value = response.alamat;
            document.getElementById("no_telp").value = response.no_telp;

            if (response.jenis_kelamin == "L") {
                document.getElementById("jenkel1").checked = true;
            } else {
                document.getElementById("jenkel2").checked = true;
            }
        },
        error: function(response) {
            console.log(response.responseText);
        }
    });
});

$(document).on('click', '.hapus_data', function() {
    var id = $(this).attr('id');

    $.ajax({
        type: 'POST',
        url: "hapus_data.php",
        data: { id: id },
        success: function() {
            $('.data').load("data.php");
        },
        error: function (response) {
            console.log(response.responseText);
        }
    });
});
</script>
</body>
</html>