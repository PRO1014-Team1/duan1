<?php
$cart = $_SESSION['cart'] ?? null;
$min = 1;
$max = 20;
get_product();
if (isset($_POST['submit'])) {
    $_SESSION['checkout'] = $_POST;
    redirect('checkout');
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
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($cart) : ?>
                                    <?php foreach ($cart as $item) : ?>
                                        <tr>
                                            <td>
                                                <div class="grid cart-display__form__detail">
                                                    <div class="cart-display__form__detail__image">
                                                        <img src="<?= $item['product_image'] ?>" class="img-fluid">
                                                    </div>
                                                    <div class="cart-display__form__detail__name">
                                                        <?= $item['product_name'] ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" id="item_price" value="<?= $item['price'] ?>" readonly disabled>
                                                <span class="block" id="item_subtotal">Tổng: <?= $item['price'] * $item['amount'] ?> </span>
                                            </td>
                                            <td>
                                                <div class="quantity">
                                                    <input class="quantity__idicator" type="number" name="quantity[]" min="<?= $min ?>" max="<?= $max ?>" step="1" value="<?= $item['amount'] ?>">
                                                </div>
                                            </td>
                                            <input type="number" name="price[]" value="<?= $item['price'] ?>">
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