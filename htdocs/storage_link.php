<?php
// HAPUS FILE INI SEGERA SETELAH SYMLINK BERHASIL DIBUAT!
// Akses: https://domain-anda.infinityfreeapp.com/storage_link.php
$targetFolder = __DIR__.'/../cbt_core/storage/app/public';
$linkFolder   = __DIR__.'/storage';

if (is_link($linkFolder)) {
    echo '<p style="color:orange">Symlink sudah ada sebelumnya.</p>';
} elseif (symlink($targetFolder, $linkFolder)) {
    echo '<p style="color:green;font-weight:bold">SUKSES! Symlink berhasil dibuat. HAPUS file ini sekarang!</p>';
} else {
    // Fallback: copy folder jika symlink tidak diizinkan
    if (!is_dir($linkFolder)) { mkdir($linkFolder, 0755, true); }
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($targetFolder, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($files as $file) {
        $relPath = substr($file->getPathname(), strlen($targetFolder));
        $dest = $linkFolder . $relPath;
        if ($file->isDir()) {
            if (!is_dir($dest)) mkdir($dest, 0755, true);
        } else {
            copy($file->getPathname(), $dest);
        }
    }
    echo '<p style="color:blue">Symlink gagal, tetapi folder storage telah dicopy langsung. HAPUS file ini sekarang!</p>';
}
?>
