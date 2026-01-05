<div class="container">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <a href="#" title="modalTambah" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-lg"></i> Tambah Article</a>
    </button>
    <div class="row">
        <div class="table-responsive" id="article_data">

        </div>

        <!-- Awal Modal Tambah-->
        <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Article</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="modal-body">

                            <div class="card mb-4 bg-light border-info">
                                <div class="card-body">
                                    <label class="form-label fw-bold">Generate Ide via Gemini AI</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="ai-topic" placeholder="Masukkan topik (contoh: Kuliah IT, Teknologi Web)">
                                        <button class="btn btn-info text-white" type="button" id="btn-generate">
                                            <i class="bi bi-stars"></i> Buat 5 Opsi
                                        </button>
                                    </div>

                                    <div id="loading-spinner" class="text-center d-none my-2">
                                        <div class="spinner-border text-info" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <small class="d-block text-muted">Sedang berpikir...</small>
                                    </div>

                                    <div id="ai-results" class="list-group"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Judul</label>
                                <input type="text" class="form-control" name="judul" id="judul" placeholder="Tuliskan Judul Artikel" required>
                            </div>

                            <div class="mb-3">
                                <label for="floatingTextarea2">Isi</label>
                                <textarea class="form-control" placeholder="Tuliskan Isi Artikel" name="isi" id="isi" rows="5" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="summary" class="form-label">Ringkasan (Thumbnail Description)</label>
                                <div class="input-group">
                                    <textarea class="form-control" name="summary" id="summary" placeholder="Ringkasan singkat untuk thumbnail..." rows="2"></textarea>
                                    <button class="btn btn-warning text-dark" type="button" id="btn-summary">
                                        <i class="bi bi-magic"></i> Buat Ringkasan
                                    </button>
                                </div>
                                <div id="loading-summary" class="d-none text-muted"><small>Sedang meringkas...</small></div>
                            </div>

                            <div class="mb-3">
                                <label for="formGroupExampleInput2" class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar" id="inputFile">
                                <div class="mt-2">
                                    <img id="preview-crop" src="" class="img-thumbnail d-none" width="200">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Akhir Modal Tambah-->
        
        <!-- modal crop -->
        <div class="modal fade" id="modalCrop" tabindex="-1" aria-labelledby="modalCropLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCropLabel">Potong Gambar (Sesuaikan Area)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <img id="image-to-crop" src="" alt="Picture">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="btn-crop">Potong & Gunakan</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal crop end -->
    </div>
</div>

<script>
    // --- Logika untuk Generate AI ---
    $('#btn-generate').click(function() {
        var topic = $('#ai-topic').val();

        if (topic === '') {
            alert('Harap isi topik terlebih dahulu!');
            return;
        }

        // Tampilkan loading, kosongkan hasil sebelumnya
        $('#loading-spinner').removeClass('d-none');
        $('#ai-results').empty();
        $(this).prop('disabled', true);

        $.ajax({
            url: 'generate_article.php', // File proxy PHP yang kita buat
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                topic: topic
            }),
            success: function(response) {
                $('#loading-spinner').addClass('d-none');
                $('#btn-generate').prop('disabled', false);

                // Parsing hasil (karena response dari PHP sudah JSON Array)
                // Jika error dari PHP
                if (response.error) {
                    alert('Error: ' + response.error);
                    return;
                }

                // Loop hasil 5 opsi
                response.forEach(function(item, index) {
                    var limitIsi = item.isi.substring(0, 100) + '...'; // Potong isi biar ga kepanjangan di preview

                    var htmlItem = `
                        <button type="button" class="list-group-item list-group-item-action ai-option" 
                            data-judul="${item.judul}" 
                            data-isi="${item.isi}">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-bold">Opsi ${index + 1}: ${item.judul}</h6>
                            </div>
                            <small class="text-body-secondary">${limitIsi}</small>
                        </button>
                    `;
                    $('#ai-results').append(htmlItem);
                });
            },
            error: function(xhr, status, error) {
                $('#loading-spinner').addClass('d-none');
                $('#btn-generate').prop('disabled', false);
                alert('Terjadi kesalahan koneksi ke AI.');
                console.error(error);
            }
        });
    });

    // Ketika salah satu opsi AI diklik
    $(document).on('click', '.ai-option', function() {
        var judulDipilih = $(this).data('judul');
        var isiDipilih = $(this).data('isi');

        // Masukkan ke dalam form input asli
        $('#judul').val(judulDipilih);
        $('#isi').val(isiDipilih);

        // Beri feedback visual (opsional)
        $('.ai-option').removeClass('active');
        $(this).addClass('active');
    });
    // --- Akhir Logika AI ---

    // --- BARU: Logika Generate Summary ---
    $('#btn-summary').click(function() {
        var isiArtikel = $('#isi').val(); // Ambil isi dari textarea

        if (isiArtikel.length < 50) {
            alert('Isi artikel terlalu pendek untuk diringkas. Silakan tulis lebih banyak!');
            return;
        }

        // UI Loading
        $('#loading-summary').removeClass('d-none');
        $('#btn-summary').prop('disabled', true);
        $('#summary').val('Sedang memproses...');

        $.ajax({
            url: 'generate_article.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                type: 'summary', // Beritahu backend ini request summary
                content: isiArtikel
            }),
            success: function(response) {
                $('#loading-summary').addClass('d-none');
                $('#btn-summary').prop('disabled', false);

                if (response.error) {
                    alert('Error: ' + response.error);
                    $('#summary').val('');
                } else {
                    // Masukkan hasil ringkasan ke textarea summary
                    $('#summary').val(response.summary);
                }
            },
            error: function() {
                $('#loading-summary').addClass('d-none');
                $('#btn-summary').prop('disabled', false);
                alert('Gagal menghubungi AI.');
            }
        });
    });

    // --- LOGIKA SUMMARY UNTUK MODAL EDIT (Dynamic) ---
    // Kita gunakan $(document).on karena tombol ini muncul dari AJAX (dynamic content)
    $(document).on('click', '.btn-generate-summary-edit', function() {
        var id = $(this).data('id'); // Ambil ID artikel dari tombol yang diklik
        var btn = $(this);
        var isiArtikel = $('#isi' + id).val(); // Ambil isi dari textarea dengan ID spesifik
        var loading = $('#loading-summary' + id);
        var output = $('#summary' + id);

        if (isiArtikel.length < 50) {
            alert('Isi artikel terlalu pendek untuk diringkas. Silakan tulis lebih banyak!');
            return;
        }

        // UI Loading
        loading.removeClass('d-none');
        btn.prop('disabled', true);
        output.val('Sedang memproses...');

        $.ajax({
            url: 'generate_article.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                type: 'summary',
                content: isiArtikel
            }),
            success: function(response) {
                loading.addClass('d-none');
                btn.prop('disabled', false);

                if (response.error) {
                    alert('Error: ' + response.error);
                    output.val('');
                } else {
                    output.val(response.summary);
                }
            },
            error: function() {
                loading.addClass('d-none');
                btn.prop('disabled', false);
                alert('Gagal menghubungi AI.');
            }
        });
    });

    $(document).ready(function() {
        load_data();

        function load_data(hlm) {
            $.ajax({
                url: "article_data.php",
                method: "POST",
                data: {
                    hlm: hlm
                },
                success: function(data) {
                    $('#article_data').html(data);
                }
            })
        }
        $(document).on('click', '.halaman', function() {
            var hlm = $(this).attr("id");
            load_data(hlm);
        });
    });

    // --- LOGIKA IMAGE CROPPER ---
    var bsModalCrop = new bootstrap.Modal(document.getElementById('modalCrop'));
    var image = document.getElementById('image-to-crop');
    var cropper;
    var fileInput; // Variable global untuk menyimpan input file yang sedang aktif

    // Fungsi trigger saat ada input file yang berubah (baik di Tambah atau Edit)
    // Kita gunakan delegate event agar bisa support Modal Edit juga nantinya
    $(document).on('change', 'input[type="file"]', function(e) {
        var files = e.target.files;

        // Simpan elemen input yang sedang aktif
        fileInput = $(this);

        if (files && files.length > 0) {
            var file = files[0];

            // Cek apakah file adalah gambar
            if (/^image\/\w+/.test(file.type)) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Set gambar ke modal crop
                    image.src = e.target.result;

                    // Tampilkan modal crop
                    bsModalCrop.show();
                };
                reader.readAsDataURL(file);

                // Reset value input dulu agar tidak langsung upload kalau batal crop
                // (Nanti kita isi lagi setelah crop selesai)
                $(this).val('');
            } else {
                alert('Pilih file gambar yang valid!');
            }
        }
    });

    // Saat Modal Crop muncul, inisialisasi Cropper
    document.getElementById('modalCrop').addEventListener('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 16 / 9, // RASIO 16:9 (Bisa diganti 1/1 untuk persegi, 4/3, dll)
            viewMode: 1, // Agar crop box tidak keluar dari gambar
            autoCropArea: 1, // Otomatis select semua area
        });
    });

    // Saat Modal Crop ditutup, hancurkan cropper (biar ga berat/bug)
    document.getElementById('modalCrop').addEventListener('hidden.bs.modal', function() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    });

    // Tombol "Potong & Gunakan" diklik
    document.getElementById('btn-crop').addEventListener('click', function() {
        // Ambil hasil crop sebagai Blob (File object)
        var canvas = cropper.getCroppedCanvas({
            width: 800, // Resize lebar otomatis ke 800px (biar size tidak kegedean)
            height: 450, // 800 * 9/16 = 450
        });

        canvas.toBlob(function(blob) {
            // MAGIC STEP: Masukkan Blob hasil crop ke dalam Input File asli
            // Ini membuat PHP seolah-olah menerima file upload normal

            // 1. Buat file baru dari Blob
            var croppedFile = new File([blob], "cropped_image.jpg", {
                type: "image/jpeg",
                lastModified: new Date().getTime()
            });

            // 2. Gunakan DataTransfer untuk memanipulasi input file
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(croppedFile);

            // 3. Masukkan ke input file yang memicu trigger tadi
            fileInput[0].files = dataTransfer.files;

            // 4. Tampilkan preview (Opsional, cari elemen img terdekat)
            // Khusus untuk modal tambah:
            if (fileInput.attr('id') === 'inputFile') {
                $('#preview-crop').attr('src', canvas.toDataURL()).removeClass('d-none');
            }

            // Tutup modal
            bsModalCrop.hide();
        }, 'image/jpeg', 0.8); // Kompresi kualitas 0.8 (80%)
    });
</script>

<?php
include "upload_foto.php";

//jika tombol simpan diklik
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $summary = $_POST['summary'];
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    //jika ada file yang dikirim  
    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES["gambar"]);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=article';
            </script>";
            die;
        }
    }

    //cek apakah ada id yang dikirimkan dari form
    if (isset($_POST['id'])) {
        //jika ada id, lakukan update data dengan id tersebut
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            $gambar = $_POST['gambar_lama'];
        } else {
            unlink("img/" . $_POST['gambar_lama']);
        }

        $stmt = $conn->prepare("UPDATE article SET judul=?, isi=?, summary=?, gambar=?, tanggal=?, username=? WHERE id=?");
        $stmt->bind_param("ssssssi", $judul, $isi, $summary, $gambar, $tanggal, $username, $id);

        // --- BARIS YANG HILANG SEBELUMNYA ---
        $simpan = $stmt->execute();
    } else {
        // INSERT QUERY
        $stmt = $conn->prepare("INSERT INTO article (judul, isi, summary, gambar, tanggal, username) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $judul, $isi, $summary, $gambar, $tanggal, $username);

        // --- BARIS YANG HILANG SEBELUMNYA ---
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='admin.php?page=article';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal: " . $stmt->error . "');
            document.location='admin.php?page=article';
        </script>";
    }

    $stmt->close();
    $conn->close();
}

//jika tombol hapus diklik
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM article WHERE id =?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
            alert('Hapus data sukses');
            document.location='admin.php?page=article';
        </script>";
    } else {
        echo "<script>
            alert('Hapus data gagal');
            document.location='admin.php?page=article';
        </script>";
    }

    $stmt->close();
    $conn->close();
}


//jika tombol hapus diklik
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        //hapus file gambar
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM article WHERE id =?");

    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
    alert('Hapus data sukses');
    document.location = 'admin.php?page=article';
</script>";
    } else {
        echo "<script>
    alert('Hapus data gagal');
    document.location = 'admin.php?page=article';
</script>";
    }

    $stmt->close();
    $conn->close();
}
?>