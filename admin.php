<?php
include 'backend/cek.php';
require 'backend/koneksi.php';
include 'backend/tambahjob.php';
include 'backend/update.php';
include 'backend/tambahmateri.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern at Richard's Lab</title>

    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css" />
    </noscript>
</head>



<body class="is-preload">

    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Header -->
        <header id="header" class="alt">
            <h1>Richard's Lab <br> Admin Dashboard</h1>
        </header>

        <!-- Main -->
        <div id="main">

            <!-- First Section -->
            <section id="first" class="main special">
                <div align="right"><a href="logout.php" class="btn btn-danger">Logout</a></div>
                <header class="major">
                    <h2>Kelola Pendaftar</h2>
                </header>


                <table id="table2" class="display" width="100%">
                    <thead style="background-color:#2b2b2b;color:#fff">
                        <tr>
                            <th>Register</th>
                            <th>Posisi</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $getregistrant = mysqli_query($conn, "select * from registrant r, job j where r.idjob=j.id");

                        while ($reg = mysqli_fetch_array($getregistrant)) {
                            //main
                            $id = $reg['idreg'];
                            $date = $reg['date'];
                            $posisi = $reg['jobname'];
                            $nama = $reg['name'];
                            $email = $reg['email'];
                            $gender = $reg['gender'];
                            $dob = $reg['dob'];

                            $alamat = $reg['alamat'];
                            $telepon = $reg['telepon'];
                            $motivational = $reg['motivational'];
                            $linkedin = $reg['linkedin'];
                            $portfolio = $reg['portfolio'];

                            $bday = new DateTime($dob);
                            $today = new Datetime(date('m.d.y'));
                            $diff = $today->diff($bday);

                        ?>
                            <tr>
                                <td><?= $date; ?></td>
                                <td><?= $posisi; ?></td>
                                <td><?= $nama; ?></td>
                                <td><button type="button" class="button primary small" data-toggle="modal" data-target="#view<?= $id; ?>">Tampilkan</button></td>
                            </tr>

                            <!-- The Modal -->
                            <div class="modal fade" id="view<?= $id; ?>">
                                <form method="post">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title"><?= $posisi; ?></h4>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <h2><?= $nama; ?>, <?= $gender[0]; ?>, <?= $diff->y; ?></h2>
                                                <br>
                                                <p><?= $motivational; ?></p>
                                                <br><a href="<?= $linkedin; ?>" class="button primary" target="_blank">LinkedIn</a> &nbsp <a href="<?= $portfolio; ?>" class="button primary" target="blank">Portfolio</a>

                                                <br><br>
                                                <p><?= $alamat; ?></p>
                                                <a href="mailto:<?= $email; ?>" class="btn btn-success">Send Email</a> <a target="_blank" href="https://wa.me/<?= $telepon; ?>" class="btn btn-success">Send Whatsapp</a>
                                            </div>

                                            <input type="hidden" name="idpendaftar" value="<?= $id; ?>">

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit" name="delete" class="btn btn-danger" style="background-color:red">
                                                    <font color="white">Delete</font>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>

                        <?php
                        };

                        if (isset($_POST['delete'])) {
                            $lihatid = $_POST['idpendaftar'];
                            $hapus = mysqli_query($conn, "delete from registrant where idreg='$lihatid'");
                            if ($hapus) {
                                echo 'Berhasil <meta http-equiv="refresh" content="1;url=admin.php" />';
                            } else {
                                echo 'Gagal menghapus <meta http-equiv="refresh" content="1;url=admin.php" />';
                            };
                        }

                        ?>
                    </tbody>
                </table>
            </section>

            <section class="main special">
                <header class="major">
                    <h2>Kelola Job</h2>
                </header>
                <br>
                <div align="right"><button type="button" class="primary" data-toggle="modal" data-target="#modalTambahJob">Tambah Job Baru</button></div>
                <br>
                <div class="data-tables datatable-dark">
                    <table id="table1" class="display" width="100%">
                        <thead style="background-color:#2b2b2b;color:#fff">
                            <tr>
                                <th>Posisi Tersedia</th>
                                <th>Periode</th>
                                <th>Maks Pendaftaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getdata = mysqli_query($conn, "select * from job");
                            while ($data = mysqli_fetch_array($getdata)) {
                                $idjob = $data['id'];
                                $namajob = $data['jobname'];
                                $descjob = $data['jobdesc'];
                                $mulai = date_format(date_create($data['jobstart']), "d M Y");
                                $selesai = date_format(date_create($data['jobend']), "d M Y");
                                $periode = $mulai . " - " . $selesai;
                                $deadline = date_format(date_create($data['registerend']), "d M Y");
                                $jobloc = $data['jobloc'];
                                $workingtype = $data['workingtype'];

                            ?>

                                <tr>
                                    <form method="post">
                                        <input type="hidden" name="idj" value="<?= $idjob; ?>">
                                        <td><?= $namajob; ?></td>
                                        <td><?= $periode; ?></td>
                                        <td><?= $deadline; ?></td>
                                        <td><button type="button" class="button primary small" data-toggle="modal" data-target="#edit<?= $idjob; ?>">Edit</button><button type="submit" class="button small" style="background-color:red;" name="deletejob">
                                                <font color="white">Delete</font>
                                            </button></td>
                                    </form>
                                </tr>


                                <!-- The Modal -->
                                <div class="modal fade" id="edit<?= $idjob; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="post">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit <?= $namajob; ?></h4>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <input type="text" name="updatejobname" class="form-control" value="<?= $namajob; ?>"><br>

                                                    <textarea name="updatedesc"><?= $descjob; ?></textarea><br>

                                                    Start Date: <input type="date" name="updatestart" class="form-control" value="<?= $data['jobstart']; ?>"><br>

                                                    End Date: <input type="date" name="updateend" class="form-control" value="<?= $data['jobend']; ?>"><br>

                                                    End Registration: <input type="date" name="updatedeadline" class="form-control" value="<?= $data['registerend']; ?>"><br>

                                                    <input type="text" name="updatejobloc" class="form-control" value="<?= $jobloc; ?>"><br>

                                                    <select name="updateworkingtype">
                                                        <option selected values="WFH">WFH</option>
                                                        <option value="WFO">WFO</option>
                                                        <option value="Mix">MIX WFH-WFO / Rolling</option>
                                                    </select>
                                                    <input type="hidden" name="updateid" value="<?= $idjob; ?>">
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            };

                            if (isset($_POST['deletejob'])) {
                                $idj = $_POST['idj'];
                                $querydelete = mysqli_query($conn, "delete from job where id='$idj'");

                                if ($querydelete) {
                                    echo 'Berhasil
                            <meta http-equiv="refresh" content="1;url=admin.php" />';
                                } else {
                                    echo 'Gagal
                            <meta http-equiv="refresh" content="3;url=submit.php" />';
                                };
                            };

                            ?>
                        </tbody>
                    </table>
            </section>

            <section class="main special">
                <header class="major">
                    <h2>Kelola Materi</h2>
                </header>
                <br>
                <div align="right"><button type="button" class="primary" data-toggle="modal" data-target="#modalTambahMateri">Tambah Materi Baru</button></div>
                <br>
                <div class="data-tables datatable-dark">
                    <table id="table1" class="display" width="100%">
                        <thead style="background-color:#2b2b2b;color:#fff">
                            <tr>
                                <th>Nama Materi</th>
                                <th>Kategori</th>
                                <th>Link Materi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getdata = mysqli_query($conn, "select * from materi");
                            while ($data = mysqli_fetch_array($getdata)) {
                                $id_materi = $data['id_materi'];
                                $id_job = $data['id_job'];
                                $nama_materi = $data['nama_materi'];
                                $link_materi = $data['link_materi'];

                            ?>

                                <tr>
                                    <form method="post">
                                        <input type="hidden" name="idj" value="<?= $id_materi; ?>">
                                        <td><?= $id_materi; ?></td>
                                        <td><?= $id_job; ?></td>
                                        <td><?= $nama_materi; ?></td>
                                        <td><?= $link_materi; ?></td>
                                        <td><button type="button" class="button primary small" data-toggle="modal" data-target="#edit<?= $id_materi; ?>">Edit</button><button type="submit" class="button small" style="background-color:red;" name="deletejob">
                                                <font color="white">Delete</font>
                                            </button></td>
                                    </form>
                                </tr>


                                <!-- The Modal -->
                                <div class="modal fade" id="edit<?= $idjob; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="post">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit <?= $namajob; ?></h4>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <input type="text" name="updatejobname" class="form-control" value="<?= $namajob; ?>"><br>

                                                    <textarea name="updatedesc"><?= $descjob; ?></textarea><br>

                                                    Start Date: <input type="date" name="updatestart" class="form-control" value="<?= $data['jobstart']; ?>"><br>

                                                    End Date: <input type="date" name="updateend" class="form-control" value="<?= $data['jobend']; ?>"><br>

                                                    End Registration: <input type="date" name="updatedeadline" class="form-control" value="<?= $data['registerend']; ?>"><br>

                                                    <input type="text" name="updatejobloc" class="form-control" value="<?= $jobloc; ?>"><br>

                                                    <select name="updateworkingtype">
                                                        <option selected values="WFH">WFH</option>
                                                        <option value="WFO">WFO</option>
                                                        <option value="Mix">MIX WFH-WFO / Rolling</option>
                                                    </select>
                                                    <input type="hidden" name="updateid" value="<?= $idjob; ?>">
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            };

                            if (isset($_POST['deletejob'])) {
                                $idj = $_POST['idj'];
                                $querydelete = mysqli_query($conn, "delete from job where id='$idj'");

                                if ($querydelete) {
                                    echo 'Berhasil
                            <meta http-equiv="refresh" content="1;url=admin.php" />';
                                } else {
                                    echo 'Gagal
                            <meta http-equiv="refresh" content="3;url=submit.php" />';
                                };
                            };

                            ?>
                        </tbody>
                    </table>
            </section>


        </div>

        <!-- Footer -->
        <footer id="footer">
            <p class="copyright">Richard's Lab 2020</p>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

</body>


<!-- The Modal Tambah Job -->
<div class="modal fade" id="modalTambahJob">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:#2b2b2b;">
            <form method="post">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Job Baru</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" name="jobname" placeholder="Nama Posisi" class="form-control"><br>

                    <textarea name="desc" placeholder="Job Description"></textarea><br>

                    Start Date: <input type="date" name="start" class="form-control"><br>

                    End Date: <input type="date" name="end" class="form-control"><br>

                    End Registration: <input type="date" name="endregist" class="form-control"><br>

                    <input type="text" placeholder="Job Location" name="jobloc" class="form-control"><br>

                    <select name="workingtype">
                        <option selected values="WFH">WFH</option>
                        <option value="WFO">WFO</option>
                        <option value="Mix">MIX WFH-WFO / Rolling</option>
                    </select>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="addjob">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- The Modal Tambah Materi -->
<div class="modal fade" id="modalTambahMateri">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:#2b2b2b;">
            <form method="post">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Materi Baru</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" name="nama_materi" placeholder="Nama Materi" class="form-control"><br>

                    <select name="kategori">
                        <?php
                        $getdata = mysqli_query($conn, "select * from job");
                        while ($data = mysqli_fetch_array($getdata)) {
                            $idjob = $data['id'];
                            $namajob = $data['jobname'];
                            $kategori = array($idjob => $namajob);
                        ?>
                            <option value="<?= $idjob; ?>"><?= $namajob; ?></option>
                            <?php foreach ($job_array as $var => $kategori) : ?>
                                <option value="<?php echo $var ?>" <?php if ($var == $result['kategori']) : ?> selected="selected" <?php endif; ?>><?php echo $kategori ?></option>
                        <?php endforeach;
                        } ?>
                    </select>
                    <br>
                    <input type="text" name="link_materi" placeholder="Link Materi" class="form-control"><br>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="add_materi">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>




<script>
    $(document).ready(function() {
        $('#table1').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print'
            ]
        });
    });

    $(document).ready(function() {
        $('#table2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print'
            ]
        });
    });
</script><!-- jquery latest version -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- Start datatable js -->
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

</html>