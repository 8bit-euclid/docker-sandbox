<?php
include './inc/functions.inc.php';

$image = null;
if (!empty($_GET['image'])) {
    $imageFromUrl = (string) $_GET['image'];

    $availableImages = [];
    $handle = opendir(__DIR__ . '/images');
    while(($file = readdir($handle)) !== false) {
        if($file == "." || $file == "..") continue;
        if (str_ends_with($file, '.jpg') || str_ends_with($file, '.jpeg')) {
            $availableImages[] = $file;
        }
    }

    if (in_array($imageFromUrl, $availableImages)) {
        $image = $imageFromUrl;
    }


}
?>
<?php include './views/header.php'; ?>

<?php if (!empty($image)): ?>
    <img src="./images/<?php echo rawurlencode($image); ?>" />
<?php else: ?>
    <div class="notice">
        This image could not be found.
    </div>
<?php endif; ?>

<a href="index.php">Back to gallery</a>
<br /><br /><br /><br /><br />


<?php include './views/footer.php'; ?>
