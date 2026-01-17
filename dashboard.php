<?php
//query untuk mengambil data article
$sql1 = "SELECT * FROM article ORDER BY tanggal DESC";
$hasil1 = $conn->query($sql1);

//menghitung jumlah baris data article
$jumlah_article = $hasil1->num_rows;

//query untuk mengambil data gallery
$sql2 = "SELECT * FROM gallery";
$hasil2 = $conn->query($sql2);

//menghitung jumlah baris data gallery
$jumlah_gallery = $hasil2->num_rows;
?>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 g-md-4 justify-content-center pt-3 pt-md-4">
    <div class="col">
        <div class="card border border-danger mb-2 mb-md-3 shadow h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="p-2 p-md-3">
                        <h5 class="card-title mb-0"><i class="bi bi-newspaper"></i> Article</h5>
                    </div>
                    <div class="p-2 p-md-3">
                        <span class="badge rounded-pill text-bg-danger fs-4 fs-md-2"><?php echo $jumlah_article; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card border border-danger mb-2 mb-md-3 shadow h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="p-2 p-md-3">
                        <h5 class="card-title mb-0"><i class="bi bi-camera"></i> Gallery</h5>
                    </div>
                    <div class="p-2 p-md-3">
                        <span class="badge rounded-pill text-bg-danger fs-4 fs-md-2"><?php echo $jumlah_gallery; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>