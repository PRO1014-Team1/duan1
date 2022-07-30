<?php
if (!isset($_SESSION['bookmark'])) {
    $_SESSION['bookmark'] = array();
    $current_page = 1;
}
if (isset($_POST['remove-bookmark'])) {
    var_dump($_SESSION['bookmark']);
    $remove_key = array_search($_POST['remove-bookmark'], $_SESSION['bookmark']);
    unset($_SESSION['bookmark'][$remove_key]);
}

array_push($_SESSION['bookmark'], $_POST['current-page'] ?? 1);
$_SESSION['bookmark'] = array_unique($_SESSION['bookmark']);
$bookmarks = $_SESSION['bookmark'];
if (isset($_POST['add'])) {
    $current_page = $_POST['bookmark-list'];
} else {
    $current_page = end($bookmarks);
}
echo "<script>let currentPageIndex = {$current_page}; </script>";
reset($bookmarks);

?>
<div id="container">
    <div id="app" class="grid">
        <div role="toolbar" id="toolbar">
            <div id="pager">
                <button data-pager="prev"><i class="fa fa-chevron-left"></i>Trước</button>
                <button class="btn counter"><?= $current_page ?></button>
                <button data-pager="next">Sau <i class="fa fa-chevron-right"></i></button>
            </div>
            <form id="bookmark-wrapper" method="POST">
                <button type="submit" data-bookmark="add" name="add" id="bookmark"><i class="fa fa-bookmark"></i></button>
                <!-- bookmark list -->
                <input type="hidden" name="current-page" id="current-page" value="<?= $_POST['current-page'] ?? 1 ?>">
                <select id="bookmark-list-select" name="bookmark-list" onchange="submit()">
                    <?php foreach ($bookmarks as $bookmark) : ?>
                        <option value="<?= $bookmark; ?>" <?= $bookmark === ($current_page ?? $_SESSION['bookmark']) ? "selected" : "" ?>>Trang <?= $bookmark; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="delete-bookmark" name="remove-bookmark" value="<?= $_POST['bookmark-list']; ?>">
                    <i class="fas fa-times-circle"></i>
                </button>
            </form>
            <!-- <div id="page-mode">
            <label>Page Mode <input type="number" value="1" min="1" /></label>
        </div> -->
        </div>
        <canvas id="viewport"></canvas>
    </div>
</div>