<?php
if (!isset($_SESSION['bookmark'])) {
    $_SESSION['bookmark'] = explode(",", $library['bookmark']) ?? array();

}
if (isset($_POST['remove-bookmark'])) {
    $remove_key = array_search($_POST['remove-bookmark'], $_SESSION['bookmark']);
    unset($_SESSION['bookmark'][$remove_key]);
    update_library($user['library_id'], $id, $_SESSION['bookmark']);
}

if (isset($_POST['add'])) {
    $current_page = $_POST['current-page'];
    array_push($_SESSION['bookmark'],  $current_page ?? 1);
    $_SESSION['bookmark'] = array_unique($_SESSION['bookmark']);
    update_library($user['library_id'], $id, $_SESSION['bookmark']);
}
if (isset($_POST['bookmark-list'])) {
    $current_page = $_POST['bookmark-list'];
    $bookmark_list = $_POST['bookmark-list'];
}

echo "<script>let currentPageIndex = {$current_page}; const doc = '{$doc}';</script>";

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
                    <?php foreach ($_SESSION['bookmark'] as $bookmark) : ?>
                        <option value="<?= $bookmark; ?>" <?= $bookmark === ($current_page ?? $_SESSION['bookmark']) ? "selected" : "" ?>>Trang <?= $bookmark; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="delete-bookmark" name="remove-bookmark" value="<?= $_POST['bookmark-list']; ?>">
                    <i class="fas fa-times-circle"></i>
                </button>
            </form>
        </div>
        <canvas id="viewport"></canvas>
    </div>
</div>