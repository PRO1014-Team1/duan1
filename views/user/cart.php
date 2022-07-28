<?php
$cart = $_SESSION['cart'] ?? null;

if (isset($_POST['submit'])) {
    for ($i = 0, $quantity = $_POST['quantity'], $ids = $_POST['id']; $i < count($ids); $i++) {
        $_SESSION['cart'][$ids[$i]]['quantity'] = $quantity[$i];
    }
    redirect('checkout');
}
if (isset($_GET['action'])){
    $id=$_GET['id'];
    switch ($_GET['action']) {
        case 'delete';
        unset($_SESSION['cart'][$id]);
        break;
    }
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
                                    <th>Số lượng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($cart) : ?>
                                    <?php foreach ($cart as $item) : ?>
                                        <?php
                                        $product = get_product($item['id']);
                                        $type = get_type_data($product['product_id'])[0];
                                        $min = 1;
                                        $max = $type['quantity'];
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="cart-display__form__detail">
                                                    <div class="cart-display__form__detail__image">
                                                        <img src="<?= $product['image'] ?>" class="img-fluid">
                                                    </div>
                                                    <div class="cart-display__form__detail__name">
                                                        <?= $product['name'] ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" id="item_price" value="<?=discount($type['price'], $type['sale']) ?>" readonly disabled>
                                                <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                                                <span class="block" id="item_subtotal">Tổng: <?= discount($type['price'], $type['sale'])  * $item['quantity'] ?> </span>
                                            </td>
                                            <td>
                                                <div class="quantity">
                                                    <input class="quantity__idicator" type="number" name="quantity[]" min="<?= $min ?>" max="<?= $max ?>" step="1" value="<?= $item['quantity'] ?>">
                                                </div>
                                            </td>
                                            <td> 
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
  <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"onclick="location='?option=cart&action=delete&id=<?=$item['id']?>';">
</svg>
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