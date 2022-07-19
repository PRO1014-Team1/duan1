<?php

require_once "lib/route.php";
require_once "controllers/controller.php";
route("/", function () {
    echo "HOME PAGE";
});

route("/contact", function () {
    echo "Contact page";
});

route("/about-us", function () {
    echo "About us page";
});

route("/404", function () {
    echo "404 FILE NOT FOUND!";
});

route("/hang_hoa", function () {
    hang_hoa_index();
});
run();
