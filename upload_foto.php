<?php
function make_thumb_354x236_jpg(string $srcPath, string $dstPath, int $tw = 354, int $th = 236): bool
{
    $info = @getimagesize($srcPath);
    if (!$info) return false;

    $mime = $info['mime'];
    switch ($mime) {
        case 'image/jpeg':
            $src = imagecreatefromjpeg($srcPath);
            break;
        case 'image/png':
            $src = imagecreatefrompng($srcPath);
            break;
        case 'image/gif':
            $src = imagecreatefromgif($srcPath);
            break;
        default:
            return false;
    }
    if (!$src) return false;

    $sw = imagesx($src);
    $sh = imagesy($src);
    $targetRatio = $tw / $th;
    $srcRatio = $sw / $sh;

    // hitung area crop center supaya rasio pas
    if ($srcRatio > $targetRatio) {
        $cropH = $sh;
        $cropW = (int) round($sh * $targetRatio);
        $sx = (int) round(($sw - $cropW) / 2);
        $sy = 0;
    } else {
        $cropW = $sw;
        $cropH = (int) round($sw / $targetRatio);
        $sx = 0;
        $sy = (int) round(($sh - $cropH) / 2);
    }

    $dst = imagecreatetruecolor($tw, $th);
    // background putih (biar png transparan gak jadi hitam)
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);

    imagecopyresampled($dst, $src, 0, 0, $sx, $sy, $tw, $th, $cropW, $cropH);

    $ok = imagejpeg($dst, $dstPath, 85);

    imagedestroy($src);
    imagedestroy($dst);
    return $ok;
}

function upload_foto($File)
{
    $uploadOk = 1;
    $hasil = array();
    $message = '';

    $FileName = $File['name'];
    $TmpLocation = $File['tmp_name'];
    $FileSize = $File['size'];

    $FileExt = explode('.', $FileName);
    $FileExt = strtolower(end($FileExt));

    $Allowed = array('jpg', 'png', 'gif', 'jpeg');

    if ($FileSize > 500000) {
        $message .= "Sorry, your file is too large, max 500KB. ";
        $uploadOk = 0;
    }

    if (!in_array($FileExt, $Allowed)) {
        $message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
        $uploadOk = 0;
    }

    // pastikan beneran gambar
    if ($uploadOk && !@getimagesize($TmpLocation)) {
        $message .= "File bukan gambar yang valid. ";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $message .= "Sorry, your file was not uploaded. ";
        $hasil['status'] = false;
    } else {
        // kita paksa output thumbnail jadi JPG
        $NewName = date("YmdHis") . '.jpg';
        $UploadDestination = "img/" . $NewName;

        // buat thumb langsung dari tmp → dst
        if (make_thumb_354x236_jpg($TmpLocation, $UploadDestination, 354, 236)) {
            $message .= $NewName;
            $hasil['status'] = true;
        } else {
            $message .= "Gagal memproses gambar (GD extension mungkin belum aktif). ";
            $hasil['status'] = false;
        }
    }

    $hasil['message'] = $message;
    return $hasil;
}
