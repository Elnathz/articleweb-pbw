<div class="container">
    <!-- Button trigger modal (FIX: jangan taruh <a> di dalam <button>) -->
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Article
    </button>

    <div class="row">
        <div class="table-responsive" id="article_data"></div>

        <!-- Awal Modal Tambah -->
        <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                        <input type="text" class="form-control" id="ai-topic"
                                            placeholder="Masukkan topik (contoh: Kuliah IT, Teknologi Web)">
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
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" name="judul" id="judul"
                                    placeholder="Tuliskan Judul Artikel" required>
                            </div>

                            <div class="mb-3">
                                <label for="isi" class="form-label">Isi</label>
                                <textarea class="form-control" placeholder="Tuliskan Isi Artikel" name="isi" id="isi" rows="5"
                                    required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="summary" class="form-label">Ringkasan (Thumbnail Description)</label>
                                <div class="input-group">
                                    <textarea class="form-control" name="summary" id="summary"
                                        placeholder="Ringkasan singkat untuk thumbnail..." rows="2"></textarea>
                                    <button class="btn btn-warning text-dark" type="button" id="btn-summary">
                                        <i class="bi bi-magic"></i> Buat Ringkasan
                                    </button>
                                </div>
                                <div id="loading-summary" class="d-none text-muted">
                                    <small>Sedang meringkas...</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="inputFile" class="form-label">Gambar</label>
                                <!-- (opsional) accept image -->
                                <input type="file" class="form-control" name="gambar" id="inputFile" accept="image/*">
                                <div class="mt-2">
                                    <img id="preview-crop" src="" class="img-thumbnail preview-crop d-none" width="200">
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
        <!-- Akhir Modal Tambah -->

        <!-- Modal Crop (FIX: jangan modal-footer dobel/nested) -->
        <div class="modal fade" id="modalCrop" tabindex="-1" aria-labelledby="modalCropLabel" aria-hidden="true"
            data-bs-backdrop="static" data-bs-keyboard="false">
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
                        <div class="me-auto">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="zoomOut">-</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="zoomIn">+</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="resetCrop">Reset</button>
                        </div>

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
    // =========================
    // --- Logika Generate AI ---
    // =========================
    $('#btn-generate').click(function() {
        var topic = $('#ai-topic').val();

        if (topic === '') {
            alert('Harap isi topik terlebih dahulu!');
            return;
        }

        $('#loading-spinner').removeClass('d-none');
        $('#ai-results').empty();
        $(this).prop('disabled', true);

        $.ajax({
            url: 'generate_article.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                topic: topic
            }),
            success: function(response) {
                $('#loading-spinner').addClass('d-none');
                $('#btn-generate').prop('disabled', false);

                if (response.error) {
                    alert('Error: ' + response.error);
                    return;
                }

                response.forEach(function(item, index) {
                    var limitIsi = item.isi.substring(0, 100) + '...';

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

    $(document).on('click', '.ai-option', function() {
        var judulDipilih = $(this).data('judul');
        var isiDipilih = $(this).data('isi');

        $('#judul').val(judulDipilih);
        $('#isi').val(isiDipilih);

        $('.ai-option').removeClass('active');
        $(this).addClass('active');
    });

    // ============================
    // --- Logika Generate Summary ---
    // ============================
    $('#btn-summary').click(function() {
        var isiArtikel = $('#isi').val();

        if (isiArtikel.length < 50) {
            alert('Isi artikel terlalu pendek untuk diringkas. Silakan tulis lebih banyak!');
            return;
        }

        $('#loading-summary').removeClass('d-none');
        $('#btn-summary').prop('disabled', true);
        $('#summary').val('Sedang memproses...');

        $.ajax({
            url: 'generate_article.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                type: 'summary',
                content: isiArtikel
            }),
            success: function(response) {
                $('#loading-summary').addClass('d-none');
                $('#btn-summary').prop('disabled', false);

                if (response.error) {
                    alert('Error: ' + response.error);
                    $('#summary').val('');
                } else {
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

    // ==================================================
    // --- LOGIKA SUMMARY UNTUK MODAL EDIT (Dynamic) ---
    // ==================================================
    $(document).on('click', '.btn-generate-summary-edit', function() {
        var id = $(this).data('id');
        var btn = $(this);
        var isiArtikel = $('#isi' + id).val();
        var loading = $('#loading-summary' + id);
        var output = $('#summary' + id);

        if (isiArtikel.length < 50) {
            alert('Isi artikel terlalu pendek untuk diringkas. Silakan tulis lebih banyak!');
            return;
        }

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

    // =========================
    // --- Load Data Article ---
    // =========================
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
    $(function() {
        // Pastikan library ada
        if (!window.bootstrap) {
            console.error("Bootstrap belum ter-load saat init cropper.");
            return;
        }
        if (!window.Cropper) {
            console.error("CropperJS belum ter-load saat init cropper.");
            return;
        }

        const modalCropEl = document.getElementById('modalCrop');
        const image = document.getElementById('image-to-crop');

        if (!modalCropEl || !image) {
            console.error("Elemen modalCrop / image-to-crop tidak ditemukan.");
            return;
        }

        const bsModalCrop = new bootstrap.Modal(modalCropEl);

        let cropper = null;
        let fileInput = null;

        let parentModalEl = null;
        let parentModalInstance = null;

        const TARGET_W = 354;
        const TARGET_H = 236;
        const TARGET_RATIO = TARGET_W / TARGET_H;

        // tombol zoom/reset
        document.getElementById('zoomIn')?.addEventListener('click', () => cropper && cropper.zoom(0.1));
        document.getElementById('zoomOut')?.addEventListener('click', () => cropper && cropper.zoom(-0.1));
        document.getElementById('resetCrop')?.addEventListener('click', () => cropper && cropper.reset());

        // Trigger saat input file berubah (delegated, aman untuk elemen dynamic)
        $(document).on('change', 'input[type="file"]', function(e) {
            const files = e.target.files;
            if (!files || !files.length) return;

            fileInput = $(this);
            const file = files[0];

            if (!/^image\/\w+/.test(file.type)) {
                alert('Pilih file gambar yang valid!');
                return;
            }

            // Deteksi modal asal (modalTambah / modalEdit)
            parentModalEl = fileInput.closest('.modal')[0] || null;
            if (parentModalEl && parentModalEl.id !== 'modalCrop') {
                parentModalInstance =
                    bootstrap.Modal.getInstance(parentModalEl) || new bootstrap.Modal(parentModalEl);
            } else {
                parentModalEl = null;
                parentModalInstance = null;
            }

            // mekanisme "tunggu" supaya modalCrop tidak ketimpa modalTambah
            let isParentHidden = !parentModalInstance; // kalau tidak ada parent modal, anggap sudah "hidden"
            let isFileReady = false;
            let dataUrl = "";

            function showCropIfReady() {
                if (!isParentHidden || !isFileReady) return;
                image.src = dataUrl;
                bsModalCrop.show();
            }

            if (parentModalInstance && parentModalEl) {
                parentModalEl.addEventListener('hidden.bs.modal', function() {
                    isParentHidden = true;
                    showCropIfReady();
                }, {
                    once: true
                });

                parentModalInstance.hide();
            }

            const reader = new FileReader();
            reader.onload = function(ev) {
                dataUrl = ev.target.result;
                isFileReady = true;
                showCropIfReady();
            };
            reader.readAsDataURL(file);

            // reset value input dulu, nanti diisi lagi setelah crop
            $(this).val('');
        });

        // Init cropper saat modal crop tampil
        modalCropEl.addEventListener('shown.bs.modal', function() {
            if (cropper) cropper.destroy();

            cropper = new Cropper(image, {
                aspectRatio: TARGET_RATIO,
                viewMode: 2,
                autoCropArea: 0.85,

                // supaya bisa adjust crop box
                dragMode: 'crop',
                cropBoxMovable: true,
                cropBoxResizable: true,

                // UX
                movable: true,
                zoomable: true,
                background: false,
                responsive: true,
                guides: true,
                center: true,
                highlight: true
            });
        });

        // Tombol "Potong & Gunakan"
        document.getElementById('btn-crop')?.addEventListener('click', function() {
            if (!cropper || !fileInput) return;

            const canvas = cropper.getCroppedCanvas({
                width: TARGET_W,
                height: TARGET_H,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });

            canvas.toBlob(function(blob) {
                const croppedFile = new File([blob], `thumb_${Date.now()}.jpg`, {
                    type: 'image/jpeg',
                    lastModified: Date.now()
                });

                const dt = new DataTransfer();
                dt.items.add(croppedFile);
                fileInput[0].files = dt.files;

                // preview
                const $preview = fileInput.closest('.mb-3').find('.preview-crop');
                if ($preview.length) {
                    $preview.attr('src', canvas.toDataURL('image/jpeg', 0.85)).removeClass('d-none');
                }

                bsModalCrop.hide();
            }, 'image/jpeg', 0.85);
        });

        // Saat modal crop ditutup, balikin modal asal
        modalCropEl.addEventListener('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            image.src = '';

            if (parentModalInstance) {
                parentModalInstance.show();
            }

            parentModalEl = null;
            parentModalInstance = null;
            fileInput = null;
        });
    });
</script>

<?php
include "upload_foto.php";

// =====================
// SIMPAN (INSERT/UPDATE)
// =====================
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $summary = $_POST['summary'];

    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    // jika ada file yang dikirim
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

    // UPDATE
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            $gambar = $_POST['gambar_lama'];
        } else {
            unlink("img/" . $_POST['gambar_lama']);
        }

        $stmt = $conn->prepare("UPDATE article SET judul=?, isi=?, summary=?, gambar=?, tanggal=?, username=? WHERE id=?");
        $stmt->bind_param("ssssssi", $judul, $isi, $summary, $gambar, $tanggal, $username, $id);
        $simpan = $stmt->execute();
    } else {
        // INSERT
        $stmt = $conn->prepare("INSERT INTO article (judul, isi, summary, gambar, tanggal, username) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $judul, $isi, $summary, $gambar, $tanggal, $username);
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

// =====================
// HAPUS (FIX: jangan duplikat blok hapus)
// =====================
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM article WHERE id=?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
      alert('Hapus data sukses');
      document.location='admin.php?page=article';
    </script>";
    } else {
        echo "<script>
      alert('Hapus data gagal: " . $stmt->error . "');
      document.location='admin.php?page=article';
    </script>";
    }

    $stmt->close();
    $conn->close();
}
?>