<?php
$article_id = $_GET['id'] ?? null;
function get_article($article_id)
{
    $path = "./views/articles/{$article_id}.html";
    if (file_exists($path)) {
        return file_get_contents($path);
    } else {
        $path = "./views/articles/main.html";
        return file_get_contents($path);
    }
}
?>

<main class="main-container">
    <div class="row grid mx-auto">
        <aside class="col side-menu">
            <!-- top 10 product list -->
            <div class="top-10-prod">
                <h2 class="title">Tin nổi bật</h2>
                <div class="top-10-prod__list col-2-2 grid ">
                    <div class="top-10-prod__item">
                        <a href="?id=1" class="hover-mask" data-content="5 Địa điểm trao đổi sách cũ cho hội mê sách">
                            <img class="img-fluid top-10-prod__img" src="/public/img/news/5 Địa điểm trao đổi sách cũ cho hội mê sách.jpg" alt="5 Địa điểm trao đổi sách cũ cho hội mê sách" />
                        </a>
                    </div>
                    <div class="top-10-prod__item">
                        <a href="?id=2" class="hover-mask" data-content="4 TÁC PHẨM VĂN HỌC VIỆT NAM HAY CHO BẠN ĐỌC">
                            <img class="img-fluid top-10-prod__img" src="/public/img/news/4 TÁC PHẨM VĂN HỌC VIỆT NAM HAY CHO BẠN ĐỌC.jpg" alt="4 TÁC PHẨM VĂN HỌC VIỆT NAM HAY CHO BẠN ĐỌC" />
                        </a>
                    </div>
                    <div class="top-10-prod__item">
                        <a href="?id=3" class="hover-mask" data-content="Những tác phẩm văn học kinh điển nước ngoài nhất định bạn phải đọc">
                            <img class="img-fluid top-10-prod__img" src="/public/img/news/Những tác phẩm văn học kinh điển nước ngoài nhất định bạn phải đọc.jpg" alt="Những tác phẩm văn học kinh điển nước ngoài nhất định bạn phải đọc" />
                        </a>
                    </div>
                    <div class="top-10-prod__item">
                        <a href="?id=4" class="hover-mask" data-content="ĐỌC SÁCH MỖI NGÀY GIÚP NÂNG CAO TINH THẦN TỰ HỌC">
                            <img class="img-fluid top-10-prod__img" src="/public/img/news/ĐỌC SÁCH MỖI NGÀY GIÚP NÂNG CAO TINH THẦN TỰ HỌC.jpg" alt="ĐỌC SÁCH MỖI NGÀY GIÚP NÂNG CAO TINH THẦN TỰ HỌC" />
                        </a>
                    </div>
                    <div class="top-10-prod__item">
                        <a href="?id=5" class="hover-mask" data-content="Cách giúp bạn rèn luyện thói quen đọc sách mỗi ngày cực hiệu quả">
                            <img class="img-fluid top-10-prod__img" src="/public/img/news/Cách giúp bạn rèn luyện thói quen đọc sách mỗi ngày cực hiệu quả.jpg" alt="Cách giúp bạn rèn luyện thói quen đọc sách mỗi ngày cực hiệu quả" />
                        </a>
                    </div>
                    <div class="top-10-prod__item">
                        <a href="?id=6" class="hover-mask" data-content="Những cuốn sách dành cho tuổi trẻ lạc lối">
                            <img class="img-fluid top-10-prod__img" src="/public/img/news/Những cuốn sách dành cho tuổi trẻ lạc lối.jpg" alt="Những cuốn sách dành cho tuổi trẻ lạc lối" />
                        </a>
                    </div>
                </div>
            </div>
            <!-- end top 10 product list -->
        </aside>
        <?= get_article($article_id) ?>
    </div>
</main>