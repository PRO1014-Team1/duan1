<?php

$orders = get_user_order(get_username());

if (!isset($_SESSION['readable'])) {
    $_SESSION['readable'] = [];
}

function translate_status($status)
{
    $product_status = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    $product_status_translated = ['Chờ xử lý', 'Đang xử lý', 'Đang giao hàng', 'Đã giao hàng', 'Đã hủy'];
    $index = array_search($status, $product_status);
    return $product_status_translated[$index];
}

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
                    <?php foreach ($orders as $order) : ?>
                        <?php
                        $order_id = $order['order_id'];
                        $order_info = get_user_order(null, $order_id);
                        $order_detail = get_order_detail($order_id);
                        ?>
                        <?php foreach ($order_detail as $detail) : ?>
                            <?php
                            $product = get_product($detail['product_id']);
                            $type_id = $detail['type_id'] != 0 ? $detail['type_id'] : get_type_data($product['product_id'])[0]['type_id'];
                            $type = get_type_data($product['product_id'], $type_id)[0];

                            ?>
                            <!-- <small>Số đơn hàng: <span class="ts-3"><?= $order_id ?></span></small>
                                <small>Ngày đặt:  </small> -->

                            <div class="card p-2">
                                <nav aria-label="breadcrumb" class="breadcrumb-container">
                                    <ul class="breadcrumb w-75 mx-auto text-center">
                                        <li class="breadcrumb-item me-2 bg-dark py-2 px-3 text-light">
                                            <span class="breadcrumb-title">
                                                <?= $order_id ?>
                                            </span>
                                        </li>
                                        <li class="breadcrumb-item me-2 bg-dark py-2 px-3 text-light">
                                            <span class="breadcrumb-title">
                                                <?= $order_info[0]['created_date'] ?>
                                            </span>
                                        </li>
                                        <li class="breadcrumb-item me-2 bg-info py-2 px-3 text-light">
                                            <span class="breadcrumb-title">
                                                <?= translate_status($order['order_status']) ?>
                                                &nbsp;<i class="ml-2 fa fa-refresh" aria-hidden="true"></i>
                                            </span>
                                        </li>
                                        <li class="breadcrumb-item me-2 bg-dark py-2 px-3 text-light">
                                            <span class="breadcrumb-title">
                                                <?= get_type_name($type_id) ?></span>
                                        </li>
                                        <li class="breadcrumb-item me-2">
                                            <span class="breadcrumb-title">
                                                <?php if ($detail['type_id'] == 335 && $order['order_status'] === "delivered") : ?>
                                                    <?php $_SESSION['readable'][$product['product_id']] = $type['download'];
                                                    ?>
                                                    <a href="readbook?id=<?= $product['product_id'] ?>" class="text-light py-2 px-3 bg-success btn text-uppercase"><button>Đọc sách</button></a>
                                                    <a href="<?= $type['download']; ?>" class="text-light py-2 px-3 ms-2 bg-primary btn text-uppercase" download><i class="fa fa-download ml-2" aria-hidden="true"></i></a>
                                                <?php elseif ($detail['type_id'] == 336 && $order['order_status'] === "delivered") : ?>
                                                    <a href="readbook?id=<?= $product['product_id'] ?>" class="text-light py-2 px-3 bg-success btn text-uppercase"><button>Đọc sách</button></a>
                                                <?php else : ?>
                                                    <a href="<?= 'detail' . '?id=' . $product['product_id'] . '&category' . $product['category_id'] ?>" class="text-decoration-none py-2 px-3 bg-dark btn link-warning text-uppercase"><button>Thông tin sách</button></a>
                                                <?php endif; ?>
                                            </span>
                                        </li>
                                    </ul>
                                </nav>
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body my-auto text-right">
                                            <div class="row  my-auto flex-column flex-md-row">
                                                <div class="col my-auto">
                                                    <img class="img-fluid" src="<?= $product['image'] ?>" width="135" height="135" />
                                                </div>
                                                <div class="col my-auto">
                                                    <p class="fs-5 text-dark"><?= $product['name'] ?></p>
                                                </div>
                                                <?php if ($detail['quantity']) : ?>
                                                    <div class="col my-auto fs-5 text-dark">
                                                        <p>Số lượng : <?= $detail['quantity'] ?></p>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="col my-auto">
                                                    <p class="fs-5 text-dark"><?= asvnd($detail['price']) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-3">
                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
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