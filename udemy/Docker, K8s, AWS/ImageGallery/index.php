<?php
include './inc/functions.inc.php';

$images = [];
$handle = opendir(__DIR__ . '/images');
while(($file = readdir($handle)) !== false) {
    if($file == "." || $file == "..") continue;
    if (str_ends_with($file, '.jpg') || str_ends_with($file, '.jpeg')) {
        $images[] = $file;
    }
}

?>
<?php include './views/header.php'; ?>

<div class="gallery-container">
    <?php foreach($images AS $src): ?>
        <a href="image.php?<?php echo http_build_query(['image' => $src]); ?>" class="gallery-item">
            <img src="./images/<?php echo rawurlencode($src); ?>" alt="<?php echo e($src); ?>" />
        </a>
    <?php endforeach; ?>
</div>

<?php include './views/footer.php'; ?>
