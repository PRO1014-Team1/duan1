<?php

//xóa cart sau khi thanh toán
// function delete_cart()
// {
//     if (isset($_SESSION['cart'])) {
//         unset($_SESSION['cart']);
//     }
// }
// delete_cart();
$_total = $_SESSION['checkout']['price'];
$total = array_reduce($_total, function($a,$b){echo (int)$b;}, 0 );
?>

<div class="col">
    <aside class="summary ">
        <h2 class="summary__title">Tổng cộng</h2>
        <div class="summary__display">
            <span class="summary__display__total"><?= (int)$_total['price'] ?> </span>
        </div>
        <button type="submit" name="submit" class="btn btn--primary checkout">Thanh toán</button>
    </aside>
</div>