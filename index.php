<?php

require_once "lib/route.php";
require_once "lib/global.php";
require_once "lib/template.php";
require_once "controllers/controller.php";


route("/", function () {
    redirect("/home");
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

route("/home", function(){
    home();
});

set_meta();
set_header($_SESSION['role']);
run();
set_footer();
