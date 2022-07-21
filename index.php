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
    path_not_found();
});

route("/home", function(){
    home();
});

route("/login", function(){
    login();
});

route("/logout", function(){
    logout();
});

route("/cart", function(){
    cart();
});

route("/detail", function(){
    detail();
});

route("/profile", function(){
    profile();
});

route("/register", function(){
    register();
});

set_meta();
set_header(get_role());
run();
set_footer();
