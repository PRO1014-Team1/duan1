<?php

require_once "lib/route.php";
require_once "lib/global.php";
require_once "controllers/controller.php";

route("/", function () {
    home(); 
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
    home();
});

route("/cart", function(){
    cart();
});

route("/checkout", function(){
    checkout();
});
route("/feedback", function(){
    feedback();
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

route("/news", function(){
    news();
});

// Các route cho admin

route("/product", function(){
    product();
});

route("/category", function(){
    category();
});

route("/add-category", function(){
    add_category();
});

route("/add-product", function(){
    add_product();
});

route("/edit-product", function(){
    edit_product();
});

route("/edit-category", function(){
    edit_category();
});

route("edit-customer", function(){
    edit_customer();
});

route("/customer", function(){
    customer();
});

// route("/order", function(){
//     order();
// });

route("/comment", function(){
    comment();
});

route("/graph", function(){
    graph();
});

route("/statistic", function(){
    statistic();
});

route("/dashboard", function(){
    dashboard();
});

route("/library", function(){
    library();
});

route("/readbook", function(){
    readbook();
});


set_meta();
run();
set_footer();
