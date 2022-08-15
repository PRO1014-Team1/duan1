<?php

$orders = get_user_order(get_username());
$user = get_user(get_username());
$library = get_library($user['library_id']);
?>
<div id="container">
    <div class="container-fluid my-5 p-5 d-flex justify-content-center">
        <div class="card-container w-75">
            <div class="card-header bg-white">
                <div class="media flex-sm-row flex-column-reverse justify-content-between">
                    <div class="col my-auto">
                        <h4 class="p-2 text-dark">Thư viện cá nhân của <span class="change-color text-warning"><?= get_username() ?> </span> !</h4>
                    </div>
                    <div class="col-auto text-center my-auto pl-0 pt-sm-4" width="115" height="115">
                        <p class="mb-4 pt-0 Glasses"></p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between mb-3">
                <div class="col-auto">
                    <h6 class="color-1 mb-0 change-color">Biên nhận</h6>
                </div>
                <div class="col-auto"> </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php foreach ($library as $item) : ?>
                        <?php
                        $product = get_product($item['product_id']);
                        $variant = get_type_data($item['product_id'], $item['type_id'])[0];
                        ?>
                        <div class="card p-2">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body my-auto text-right">
                                        <div class="row  my-auto flex-column flex-md-row">
                                            <div class="col my-auto">
                                                <img class="img-fluid w-50" src="<?= $product['image'] ?>" width="100" height="135" />
                                            </div>
                                            <div class="col my-auto">
                                                <p class="fs-5 text-dark"><?= $product['name'] ?></p>
                                            </div>
                                            <div class="col my-auto fs-5 text-dark">
                                                <p>Kích cỡ: <?= file_size_format($variant['file_size']) ?></p>
                                            </div>
                                            <div class="col my-auto">
                                                <p class="fs-5 text-dark"><?= asvnd($variant['price']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="row">

                                </div>
                            </div>
                            <nav aria-label="breadcrumb" class="breadcrumb-container">
                                <ul class="breadcrumb w-75 mx-auto text-center">
                                    <li class="breadcrumb-item me-2 bg-info py-2 px-3 text-light">
                                        <span class="breadcrumb-title">
                                            <a href="<?= 'detail' . '?id=' . $item['product_id'] . '&category' . $product['category_id'] . '&type_id=' . $item['type_id'] ?>" class="text-decoration-none link-dark text-uppercase"><button>Thông tin sách</button></a>
                                        </span>
                                    </li>
                                    <li class="breadcrumb-item me-2 bg-dark py-2 px-3 text-light">
                                        <span class="breadcrumb-title">
                                            <?= get_type_name($item['type_id']) ?></span>
                                    </li>
                                    <li class="breadcrumb-item me-2">
                                        <?php if ($item['type_id'] == 335) : ?>
                                            <!-- ebook -->
                                            <span class="breadcrumb-title">
                                                <a href="readbook?id=<?= $item['product_id'] ?>&type=<?= $item['type_id'] ?>" class="text-light py-2 px-3 bg-success btn text-uppercase"><button>Đọc sách</button></a>
                                            </span>
                                        <?php else : ?>
                                            <!-- audio -->
                                            <span class="breadcrumb-title">
                                                <button class="text-dark py-2 px-3 bg-warning btn text-bold text-capitalize listen">Nghe sách</button>
                                            </span>
                                        <?php endif ?>
                                    </li>
                                    <?php if ($item['type_id'] == 336) : ?>
                                        <li class="breadcrumb-item me-2">
                                            <div class="audio-wrapper hidden">
                                                <div class="audio-controls">
                                                    <audio class="audio" src="<?= $variant['download'] ?>" preload=”metadata” loop type="audio/mp3"></audio>
                                                    <div class="media-tool-container">
                                                        <button class="utils-button"><i class="audio-toggle-btn btn-icon fas fa-play"></i></button>
                                                        <span id="current-time" class="time">0:00</span>
                                                        <input type="range" id="seek-slider" max="100" value="0">
                                                        <span id="duration" class="time">0:00</span>
                                                        <button class="media-tool volume-toggle-btn">
                                                            <i class="fas fa-headphones"></i>
                                                        </button>
                                                        <input data-minimize="true" type="hidden" class="transition-quick" class="volume-slider" id="volume-slider" max="100" value="75">
                                                        <button class="media-tool mute">
                                                            <i class="mute-toggle-btn fas fa-volume-high btn-icon-secondary"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif ?>
                                </ul>
                            </nav>
                        </div>
                    <?php endforeach; ?>
                    <div class="row m-4">
                        <div class="col">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <a href="/" class="btn btn-outline-secondary ">
                                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                        Quay lại
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>