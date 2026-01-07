<!-- Farros Rifantiarno Ramadhani -->
<!-- A11.2024.15694 -->
<!-- LINK YOUTUBE = https://youtu.be/yidPRHuCSbk?si=HQXzOeqxCx5aGPAV -->
<!-- LINK VIDEO DRIVE = https://drive.google.com/file/d/1HLII3Eps4nHR-iv1gsKNb4AtoGsKbH56/view?usp=sharing -->
<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Daily Journal</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="icon" href="./img/logo.png" />

    <style>
        .photo-profile {
            border: 5px solid;
            transition: transform 0.3s ease;
        }

        .photo-profile:hover {
            transform: scale(1.05);
        }

        .navbar-brand span {
            animation: teksPelangi 5s alternate infinite;
        }

        #footer .text-footer div span{
            animation: teksPelangi 5s alternate infinite;
        }

        .card {
            transition: transform 0.4s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .header-schedule {
            animation: bgPelangi 15s 3ms alternate ease-in-out infinite;
        }

        .border-schedule {
            animation: borderPelangi 15s 3ms alternate infinite;
        }

        .header-schedule1 {
            background-color: #6c757d;
            animation: bgPelangi 15s 3ms alternate infinite;
            animation-delay: 2s;
        }

        .border-schedule1 {
            border-color: #6c757d;
            animation: borderPelangi 15s 3ms alternate infinite;
            animation-delay: 2s;
        }

        .header-schedule2 {
            background-color: #0d6efd;
            animation: bgPelangi 15s 3ms alternate infinite;
            animation-delay: 4s;
        }

        .border-schedule2 {
            border-color: #0d6efd;
            animation: borderPelangi 15s 3ms alternate infinite;
            animation-delay: 4s;
        }

        .header-schedule3 {
            background-color: #dc3545;
            animation: bgPelangi 15s 3ms alternate infinite;
            animation-delay: 6s;
        }

        .border-schedule3 {
            border-color: #dc3545;
            animation: borderPelangi 15s 3ms alternate infinite;
            animation-delay: 6s;
        }

        .header-schedule4 {
            background-color: #212529;
            animation: bgPelangi 15s 3ms alternate infinite;
            animation-delay: 8s;
        }

        .border-schedule4 {
            border-color: #212529;
            animation: borderPelangi 15s 3ms alternate infinite;
            animation-delay: 8s;
        }

        .header-schedule5 {
            background-color: #198754;
            animation: bgPelangi 15s 3ms alternate infinite;
            animation-delay: 10s;
        }

        .border-schedule5 {
            border-color: #198754;
            animation: borderPelangi 15s 3ms alternate infinite;
            animation-delay: 10s;
        }

        .header-schedule6 {
            background-color: #0dcaf0;
            animation: bgPelangi 15s 3ms alternate infinite;
            animation-delay: 12s;
        }

        .border-schedule6 {
            border-color: #0dcaf0;
            animation: borderPelangi 15s 3ms alternate infinite;
            animation-delay: 12s;
        }

        @keyframes bgPelangi {
            0% {
                background-color: #ffc107;
            }

            20% {
                background-color: #6c757d;
            }

            40% {
                background-color: #0d6efd;
            }

            60% {
                background-color: #dc3545;
            }

            80% {
                background-color: #212529;
            }

            100% {
                background-color: #198754;
            }
        }

        @keyframes borderPelangi {
            0% {
                border-color: #ffc107;
            }

            20% {
                border-color: #6c757d;
            }

            40% {
                border-color: #0d6efd;
            }

            60% {
                border-color: #dc3545;
            }

            80% {
                border-color: #212529;
            }

            100% {
                border-color: #198754;
            }
        }

        @keyframes teksPelangi {
            0% {
                color: #ffc107;
            }

            20% {
                color: #6c757d;
            }

            40% {
                color: #0d6efd;
            }

            60% {
                color: #dc3545;
            }

            80% {
                color: #212529;
            }

            100% {
                color: #198754;
            }
        }

        @keyframes rounded {
            0% {
                border-top-right-radius: 100%;
                border-top-left-radius: 100%;
                border-bottom-right-radius: 100%;
                border-bottom-left-radius: 100%;
            }

            50% {
                border-top-right-radius: 100%;
                border-top-left-radius: 0%;
                border-bottom-right-radius: 0%;
                border-bottom-left-radius: 100%;
            }

            75% {
                border-top-right-radius: 100%;
                border-top-left-radius: 100%;
                border-bottom-right-radius: 100%;
                border-bottom-left-radius: 100%;
            }

            100% {
                border-top-right-radius: 0%;
                border-top-left-radius: 100%;
                border-bottom-right-radius: 100%;
                border-bottom-left-radius: 0%;
            }
        }
    </style>
</head>

<body>
    <!-- Nav Begin -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">My Daily <span>Journal</span></a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div
                class="collapse navbar-collapse"
                id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#schedule">Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#article">Article</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php" target="_blank">Login</a>
                    </li>
                    <li class="nav-item me-3">
                        <button
                            type="button"
                            id="btn-light"
                            class="border-0 p-1 btn bg-transparent">
                            <img
                                src="./img/light.png"
                                width="40px"
                                id="imgBtn-Light" />
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            id="btn-dark"
                            class="border-0 p-1 bg-transparent btn">
                            <img
                                src="./img/dark.png"
                                width="40px"
                                id="imgBtnDark" />
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Nav End -->

    <!-- hero begin -->
    <section
        id="hero"
        class="text-center p-5 bg-danger-subtle text-sm-start">
        <div class="container">
            <div class="row">
                <div class="d-sm-flex flex-sm-row-reverse align-items-center">
                    <img
                        src="./img/banner.webp"
                        class="img-fluid rounded-2 ms-sm-4"
                        width="300" />

                    <div id="hero-text">
                        <h1 class="fw-bold display-4">
                            Create Memories, Save Memories, Everyday
                        </h1>
                        <h4 class="lead display-6">
                            Mencatat semua kegiatan sehari-hari yang ada tanpa
                            terkecuali
                        </h4>
                        <time class="fw-normal" id="timestamp">
                            <span id="tanggal"></span>
                            <span id="jam"></span>
                        </time>
                    </div>
                </div>
            </div>
    </section>
    <!-- hero end -->

    <!-- profile begin -->
    <section id="profile" class="p-5">
        <div class="container">
            <h1 class="text-center fw-bolder display-4 mb-5">Profile Mahasiswa</h1>


            <div class="row g-4">
                <?php
                $sql = "SELECT * FROM mhs";
                $hasil = $conn->query($sql);
                while ($row = $hasil->fetch_assoc()) {
                ?>
                    <div class="col-12 col-lg-6">
                        <div
                            class="d-flex flex-column flex-lg-row align-items-center gap-4">
                            <div class="flex-shrink-0">
                                <img
                                    src="img/<?= $row['foto'] ?>"
                                    alt="<?= $row['nama'] ?>"
                                    class="rounded-circle object-fit-cover"
                                    width="200"
                                    height="200" />
                            </div>

                            <div>
                                <h3 class="profile-text fw-semibold text-center border-bottom border-dark">
                                    <?= $row['nama'] ?>
                                </h3>

                                <table class="text-table text-table table table-borderless align-middle m-0">
                                    <tr>
                                        <th scope="row" class="pe-3">NIM</th>
                                        <td>: <?= $row['NIM'] ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="pe-3">Program Studi</th>
                                        <td>: <?= $row['prodi'] ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="pe-3">Email</th>
                                        <td>
                                            :
                                            <a href="mailto:<?= $row['email'] ?>">
                                                <i class="bi bi-envelope"></i>
                                            </a>
                                            <?= $row['email'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="pe-3">Telepon</th>
                                        <td>
                                            :
                                            <?php
                                            $wa = str_replace(['+', ' '], '', $row['telepon']);
                                            ?>
                                            <a href="https://wa.me/<?= $wa ?>">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                            <?= $row['telepon'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="pe-3">Alamat</th>
                                        <td>: <?= $row['alamat'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
    </section>
    <!-- profile end -->

    <!-- schedule begin -->
    <section id="schedule" class="text-center p-5 bg-danger-subtle">
        <div class="container p-md-5">
            <h1 class="fw-bold display-4 pb-4">Schedule</h1>
            <div
                class="row row-cols-1 row-cols-md-4 g-5 justify-content-center align-items-stretch">
                <div class="col">
                    <div
                        class="border-schedule card mb-3 p-0 h-100 me-auto ms-auto"
                        style="max-width: 18rem">
                        <div
                            class="header-schedule card-header text-light fw-bold">
                            Senin
                        </div>
                        <div class="schedule-card card-body">
                            <div class="mb-4">
                                <h5 class="mb-1">09.30 - 12.00</h5>
                                <p class="mb-1">
                                    Probabilitas dan Statistik
                                </p>
                                <p>Ruang H.5.11</p>
                            </div>

                            <div class="mb-0">
                                <h5 class="mb-1">15.30 - 18.00</h5>
                                <p class="mb-1">Logika Informatika</p>
                                <p class="mb-0">Ruang H.3.9</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div
                        class="border-schedule1 card mb-3 h-100 me-auto ms-auto"
                        style="max-width: 18rem">
                        <div
                            class="header-schedule1 card-header text-light fw-bold">
                            Selasa
                        </div>
                        <div class="schedule-card card-body">
                            <div class="mb-4">
                                <h5 class="mb-1">10.20 - 12.00</h5>
                                <p class="mb-1">Basis Data</p>
                                <p class="mb-0">Ruang D.2.K</p>
                            </div>

                            <div class="mb-0">
                                <h5 class="mb-1">12.30 - 14.10</h5>
                                <p class="mb-1">Pemrograman Berbasis Web</p>
                                <p class="mb-0">Ruang D.2.J</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div
                        class="border-schedule2 card mb-3 h-100 me-auto ms-auto"
                        style="max-width: 18rem">
                        <div
                            class="header-schedule2 card-header text-light fw-bold">
                            Rabu
                        </div>
                        <div class="schedule-card card-body">
                            <div class="mb-4">
                                <h5 class="mb-1">09.30 - 12.00</h5>
                                <p class="mb-1">Rekayasa Perangkat Lunak</p>
                                <p class="mb-0">Ruang H.3.10</p>
                            </div>

                            <div class="mb-0">
                                <h5 class="mb-1">12.30 - 15.00</h5>
                                <p class="mb-1">Kriptografi</p>
                                <p class="mb-0">Ruang H.5.9</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div
                        class="border-schedule3 card mb-3 h-100 me-auto ms-auto"
                        style="max-width: 18rem">
                        <div
                            class="header-schedule3 card-header text-light fw-bold">
                            Kamis
                        </div>
                        <div class="schedule-card card-body">
                            <div class="mb-4">
                                <h5 class="mb-1">10.20 - 12.00</h5>
                                <p class="mb-1">Basis Data</p>
                                <p class="mb-0">Ruang H.5.6</p>
                            </div>

                            <div class="mb-0">
                                <h5 class="mb-1">12.30 - 15.00</h5>
                                <p class="mb-1">Sistem Operasi</p>
                                <p class="mb-0">Ruang H.3.10</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div
                        class="border-schedule4 card mb-3 me-auto ms-auto h-100"
                        style="max-width: 18rem">
                        <div
                            class="header-schedule4 card-header text-light fw-bold">
                            Jumat
                        </div>
                        <div class="schedule-card card-body">
                            <h5 class="mb-1">15.30 - 18.00</h5>
                            <p class="mb-1">Penambangan Data</p>
                            <p class="mb-0">Kulino</p>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div
                        class="border-schedule5 card mb-3 me-auto ms-auto h-100"
                        style="max-width: 18rem">
                        <div
                            class="header-schedule5 card-header text-light fw-bold">
                            Sabtu
                        </div>
                        <div class="schedule-card card-body">
                            <h5>Tidak Ada Jadwal</h5>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div
                        class="border-schedule6 card mb-3 me-auto ms-auto h-100"
                        style="max-width: 18rem">
                        <div
                            class="header-schedule6 card-header text-light fw-bold">
                            Minggu
                        </div>
                        <div class="schedule-card card-body">
                            <h5>Tidak Ada Jadwal</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- schedule end -->

    <!-- article begin -->
    <section id="article" class="text-center p-5">
        <div class="container">
            <h1 class="fw-bold display-4 pb-3">Article</h1>
            <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
                <?php
                $sql = "SELECT * FROM article ORDER BY tanggal DESC";
                $hasil = $conn->query($sql);

                while ($row = $hasil->fetch_assoc()) {
                ?>
                    <div class="col">
                        <div class="card h-100 article-card">
                            <img src="img/<?= $row["gambar"] ?>" class="card-img-top" alt="..." />
                            <div class="card-body">
                                <h5 class="card-title"><?= $row["judul"] ?></h5>
                                <p class="card-text">
                                    <?php
                                    // Jika kolom summary tidak kosong, tampilkan summary
                                    if ($row["summary"] != '') {
                                        echo $row["summary"];
                                    } else {
                                        // Jika summary kosong (artikel lama), potong isi artikel (30 kata)
                                        echo implode(" ", array_slice(explode(" ", $row["isi"]), 0, 30)) . "...";
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <small class="text-body-secondary text-footer">
                                    <?= $row["tanggal"] ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <!-- article end -->

    <!-- gallery begin -->
    <section id="gallery" class="text-center p-5 bg-danger-subtle">
        <div class="container">
            <h1 class="fw-bold display-4 pb-3">Gallery</h1>
            <div
                id="carouselExample"
                class="carousel slide w-75 me-auto ms-auto">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <?php
                        $sql = "SELECT * FROM gallery WHERE ID=1";
                        $hasil = $conn->query($sql);

                        while ($row = $hasil->fetch_assoc()) {
                        ?>
                            <img src="img/<?= $row["gambar"] ?>" class="d-block w-100" width="300" alt="gambar <?= $row["ID"] ?>" />
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    $sql = "SELECT * FROM gallery WHERE ID > 1";
                    $hasil = $conn->query($sql);
                    while ($row = $hasil->fetch_assoc()) {
                    ?>
                        <div class="carousel-item">

                            <img src="img/<?= $row["gambar"] ?>" class="d-block w-100" width="300" alt="gambar <?= $row["ID"] ?>" />
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#carouselExample"
                    data-bs-slide="prev">
                    <span
                        class="carousel-control-prev-icon"
                        aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#carouselExample"
                    data-bs-slide="next">
                    <span
                        class="carousel-control-next-icon"
                        aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    <!-- gallery end -->

    <!-- Footer begin -->
    <footer id="footer" class="text-center p-3">
        <h6><span class="text-footer">Kelompok 1 </span>Pemrograman Berbasis Web &copy; 2026</h6>
    </footer>
    <!-- footer end -->

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script type="text/javascript">
        window.setTimeout("tampilWaktu()", 1000);

        function tampilWaktu() {
            var waktu = new Date();
            var bulan = waktu.getMonth() + 1;

            setTimeout("tampilWaktu()", 1000);
            document.getElementById("tanggal").innerHTML =
                waktu.getDate() + "/" + bulan + "/" + waktu.getFullYear();
            document.getElementById("jam").innerHTML =
                waktu.getHours() +
                ":" +
                waktu.getMinutes() +
                ":" +
                waktu.getSeconds();
        }

        document.getElementById("btn-dark").onclick = function() {
            // hero
            document
                .getElementById("hero")
                .classList.remove("bg-danger-subtle");
            document.getElementById("hero").classList.add("bg-secondary");
            document
                .getElementById("hero-text")
                .classList.remove("text-dark");
            document
                .getElementById("hero-text")
                .classList.add("text-light");

            document
                .getElementById("timestamp")
                .classList.remove("text-dark");
            document
                .getElementById("timestamp")
                .classList.add("text-light");

            // profile
            document
                .getElementById("profile")
                .classList.remove("bg-light", "text-dark");
            document
                .getElementById("profile")
                .classList.add("bg-dark", "text-light");

            const textTable = document.getElementsByClassName("text-table");
            for (let i = 0; i < textTable.length; i++) {
                textTable[i].classList.remove("table-light");
            }
            for (let i = 0; i < textTable.length; i++) {
                textTable[i].classList.add("table-dark");
            }

            const profileText = document.getElementsByClassName("profile-text");
            for (let i = 0; i < profileText.length; i++) {
                profileText[i].classList.remove("border-dark");
            }
            for (let i = 0; i < profileText.length; i++) {
                profileText[i].classList.add("border-white");
            }

            // schedule
            document
                .getElementById("schedule")
                .classList.remove("bg-danger-subtle", "text-dark");
            document
                .getElementById("schedule")
                .classList.add("bg-secondary", "text-light");

            const scheduleCard =
                document.getElementsByClassName("schedule-card");

            for (let i = 0; i < scheduleCard.length; i++) {
                scheduleCard[i].classList.remove("bg-light", "text-dark");
            }

            for (let i = 0; i < scheduleCard.length; i++) {
                scheduleCard[i].classList.add("bg-dark", "text-light");
            }

            // article
            document
                .getElementById("article")
                .classList.remove("bg-light", "text-dark");
            document
                .getElementById("article")
                .classList.add("bg-dark", "text-light");

            const articleCard =
                document.getElementsByClassName("article-card");
            const textFooter =
                document.getElementsByClassName("text-footer");

            for (let i = 0; i < articleCard.length; i++) {
                articleCard[i].classList.remove("bg-light", "text-dark");
            }

            for (let i = 0; i < articleCard.length; i++) {
                articleCard[i].classList.add("bg-secondary", "text-light");
            }

            for (let i = 0; i < textFooter.length; i++) {
                textFooter[i].classList.remove("text-body-secondary");
            }

            for (let i = 0; i < textFooter.length; i++) {
                textFooter[i].classList.add("text-light");
            }

            // gallery
            document
                .getElementById("gallery")
                .classList.remove("bg-danger-subtle", "text-dark");
            document
                .getElementById("gallery")
                .classList.add("bg-secondary", "text-light");

            // footer
            document
                .getElementById("footer")
                .classList.remove("bg-light", "text-dark");
            document
                .getElementById("footer")
                .classList.add("bg-dark", "text-light");

            const logo = document.getElementsByClassName("bi");
            for (let i = 0; i < logo.length; i++) {
                logo[i].classList.remove("text-dark");
            }

            for (let i = 0; i < logo.length; i++) {
                logo[i].classList.add("text-light");
            }
        };

        document.getElementById("btn-light").onclick = function() {
            // hero
            document
                .getElementById("hero")
                .classList.remove("bg-secondary");
            document
                .getElementById("hero")
                .classList.add("bg-danger-subtle");

            document
                .getElementById("hero-text")
                .classList.remove("text-light");
            document.getElementById("hero-text").classList.add("text-dark");

            document
                .getElementById("timestamp")
                .classList.remove("text-light");
            document.getElementById("timestamp").classList.add("text-dark");

            // profile
            document
                .getElementById("profile")
                .classList.add("bg-light", "text-dark");
            document
                .getElementById("profile")
                .classList.remove("bg-dark", "text-light");

            const textTable = document.getElementsByClassName("text-table");
            for (let i = 0; i < textTable.length; i++) {
                textTable[i].classList.add("table-light");
            }
            for (let i = 0; i < textTable.length; i++) {
                textTable[i].classList.remove("table-dark");
            }

            const profileText = document.getElementsByClassName("profile-text");
            for (let i = 0; i < profileText.length; i++) {
                profileText[i].classList.add("border-dark");
            }
            for (let i = 0; i < profileText.length; i++) {
                profileText[i].classList.remove("border-white");
            }

            // schedule
            document
                .getElementById("schedule")
                .classList.remove("bg-secondary", "text-light");
            document
                .getElementById("schedule")
                .classList.add("bg-danger-subtle", "text-dark");

            const scheduleCard =
                document.getElementsByClassName("schedule-card");

            for (let i = 0; i < scheduleCard.length; i++) {
                scheduleCard[i].classList.remove("bg-dark", "text-light");
            }

            for (let i = 0; i < scheduleCard.length; i++) {
                scheduleCard[i].classList.add("bg-light", "text-dark");
            }

            //article
            document
                .getElementById("article")
                .classList.remove("bg-dark", "text-light");
            document
                .getElementById("article")
                .classList.add("bg-light", "text-dark");

            const articleCard =
                document.getElementsByClassName("article-card");
            const textFooter =
                document.getElementsByClassName("text-footer");

            for (let i = 0; i < articleCard.length; i++) {
                articleCard[i].classList.remove(
                    "bg-secondary",
                    "text-light"
                );
            }
            for (let i = 0; i < articleCard.length; i++) {
                articleCard[i].classList.add("bg-light", "text-dark");
            }

            for (let i = 0; i < textFooter.length; i++) {
                textFooter[i].classList.remove("text-light");
            }

            for (let i = 0; i < textFooter.length; i++) {
                textFooter[i].classList.add("text-body-secondary");
            }

            // gallery
            document
                .getElementById("gallery")
                .classList.remove("bg-secondary", "text-light");
            document
                .getElementById("gallery")
                .classList.add("bg-danger-subtle", "text-dark");

            // footer
            document
                .getElementById("footer")
                .classList.remove("bg-dark", "text-light");
            document
                .getElementById("footer")
                .classList.add("bg-light", "text-dark");

            const logo = document.getElementsByClassName("bi");
            for (let i = 0; i < logo.length; i++) {
                logo[i].classList.remove("text-light");
            }
            for (let i = 0; i < logo.length; i++) {
                logo[i].classList.add("text-dark");
            }
        };
    </script>
</body>

</html>