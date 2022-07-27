<?php

$orders =  get_user_order(get_username());

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
        <div class="card">
            <div class="card-header bg-white">
                <div class="media flex-sm-row flex-column-reverse justify-content-between">
                    <div class="col my-auto">
                        <h4 class="mb-0 text-dark">Thư viện cá nhân của <span class="change-color text-warning"><?= get_username() ?> </span> !</h4>
                    </div>
                    <div class="col-auto text-center my-auto pl-0 pt-sm-4" width="115" height="115">
                        <p class="mb-4 pt-0 Glasses"></p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <h6 class="color-1 mb-0 change-color">Biên nhận</h6>
                    </div>
                    <div class="col-auto  "> <small>Số đơn hàng</small> </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php foreach ($orders as $order) : ?>
                            <?php
                            $order_id = $order['order_id'];
                            $order_detail = get_order_detail($order_id);
                            ?>
                            <?php foreach ($order_detail as $detail) : ?>
                                <?php
                                $product = get_product($detail['product_id']);
                                $type;
                                if (is_null($detail['type_id'])) {
                                    $type = get_type_data($product['product_id'], $detail['type_id'])[0];
                                } else {
                                    $type = get_type_data($product['product_id'])[0];
                                }
                                ?>
                                <div class="card card-2">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="sq align-self-center w-25"> <img class="img-fluid my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0" src="<?= $product['image'] ?>" width="135" height="135" /> </div>
                                            <div class="media-body my-auto text-right">
                                                <div class="row  my-auto flex-column flex-md-row">
                                                    <div class="col my-auto">
                                                        <h6 class="mb-0"><?= $product['name'] ?></h6>
                                                    </div>
                                                    <?php if ($detail['quantity']) : ?>
                                                        <div class="col my-auto"> <small>Số lượng : <?= $detail['quantity'] ?></small></div>
                                                    <?php endif; ?>
                                                    <div class="col my-auto">
                                                        <h6 class="mb-0"><?= $detail['price'] ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-3">
                                        <div class="row">
                                            <div class="hihi">
                                                <small>
                                                    <span class="bg-warning text-dark font-weight-bold p-2 ml-5"><?= translate_status($order['order_status']) ?>
                                                        <i class=" ml-2 fa fa-refresh" aria-hidden="true"></i></span>
                                                    <span class="bg-success text-light font-weight-bold p-2 ml-5"><?= get_type_name($detail['type_id'] ?? 333) ?></span>
                                                    <?php if ($detail['type_id'] == 335) : ?>
                                                        <a href="readbook" class="link-light"><button class="bg-info text-light font-weight-bold p-2 ml-5">Đọc sách</button></a>
                                                    <?php else : ?>
                                                        <a href="<?= 'detail' . '?id=' . $product['product_id'] . '&category' . $product['category_id'] ?>" class="bg-dark link-light text-light font-weight-bold p-2 ml-5">Thông tin sách</a>
                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <div class="row mt-4">
                            <div class="col">
                                <div class="row justify-content-between">
                                    <div class="col-auto">
                                        <a href="/" class="btn btn-outline-secondary ">
                                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                            Quay lại
                                        </a>
                                        <!-- <div class="flex-sm-col text-right col">
                                        <p class="mb-1"><b>Tổng tiền</b></p>
                                    </div>
                                    <div class="flex-sm-col col-auto">
                                        <p class="mb-1">360.000</p>
                                    </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>