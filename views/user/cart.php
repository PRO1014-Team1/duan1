<?php
$cart = $_SESSION['cart'] ?? null;
if (isset($_POST['submit'])) {

    // var_dump($_POST);
    if (!isset($cart) || count($cart) == 0) {
        alert('Không có sản phẩm nào trong giỏ hàng');
        redirect('cart');
    }

    // tăng số lượng sản phẩm
    foreach ($cart as $key => $value) {
        if ($key == $_POST['id']) {
            $_SESSION['cart'][$key]['quantity'] = $_POST['quantity'];
        }
    }

    // // tăng số lượng sản phẩm
    // for ($i = 0; $i < count($cart); $i++) {
    //     $id = $_POST['id'][$i];
    //     $quantity = $_POST['quantity'][$i];
    //     $_SESSION['cart'][$id]['quantity'] = $quantity;
    // }
    redirect('checkout');
}
if (isset($_POST['delete'])) {
    unset($_SESSION['cart'][$_POST['delete-id']]);
    redirect('cart');
}


?>
<div class="container">
    <div class="title-container">
        <h1 class="title">Thông tin giỏ hàng</h1>
        <a href="home" class="btn btn--primary-o home-redirect">
            <i class="fas fa-chevron-left"></i>&nbsp; Tiếp tục mua hàng
        </a>
    </div>
    <div class="shopping-cart__container">
        <form method="POST" class="cart-display__form" onkeydown="return event.key != 'Enter';">
            <div class="row grid mx-auto">
                <div class="col">
                    <main class="cart-display">
                        <h2 class="cart-display__title">Giỏ</h2>
                        <table class="table mx-auto">
                            <thead class="border--line">
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Loại</th>
                                    <th>Số lượng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($cart)) : ?>
                                    <?php foreach ($cart as $item) : ?>
                                        <?php
                                        $product = get_product($item['product_id']);
                                        $type_id = $item['type_id'];
                                        $type = get_type_data($item['product_id'], $type_id)[0];
                                        $min = 1;
                                        $max = $type['quantity'] ?? 1;
                                        ?>
                                        <tr class="cart-display">
                                            <td class="cart-display__form__name tooltip" data-image="<?= $product['image'] ?>">
                                                <?= $product['name'] ?>
                                                <input type="hidden" name="id" value="<?= $item['product_id'] . $type_id ?>">
                                            </td>
                                            <td class="cart-display__form__total">
                                                <input type="number" id="item_price" value="<?= discount($type['price'], $type['sale']) ?>" readonly disabled>
                                                <span class="subtotal" id="item_subtotal">Tổng: <?= discount($type['price'], $type['sale'])  * $item['quantity'] ?> </span>
                                            </td>
                                            <td>
                                                <p><?= get_type_name($type['type_id']) ?></p>
                                            </td>
                                            <?php if ($type_id <= 334) : ?>
                                                <td class="quantity">
                                                    <input class="quantity__idicator" type="number" name="quantity" min="<?= $min ?>" max="<?= $max ?>" step="1" value="<?= $item['quantity'] ?>">
                                                </td>
                                            <?php else : ?>
                                                <td>
                                                    <input type="hidden" name="quantity" value="1">
                                                </td>
                                            <?php endif; ?>
                                            <td class="cart-display__form__delete">
                                                <form action="" method="POST">
                                                    <input type="hidden" name="delete-id" value="<?= $item['id'] . $type_id ?>">
                                                    <button type=" submit" name="delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </main>
                </div>
                <div class="col">
                    <aside class="summary ">
                        <h2 class="summary__title">Tổng cộng</h2>
                        <div class="summary__display">
                            <span class="summary__display__total"></span>
                        </div>
                        <button type="submit" name="submit" class="btn btn--primary checkout">Thanh toán</button>
                    </aside>
                </div>
            </div>
        </form>
    </div>
</div>