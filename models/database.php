<?php

function connection()
{
    try {
        $conn = new PDO("mysql:host=localhost; dbname=xshop; charset=utf8", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        throw $e;
    }
}

function get_data_all($sql)
{
    $conn = connection();
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
