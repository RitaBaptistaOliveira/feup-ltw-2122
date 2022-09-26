<?php
function photoIsValid($name)
{
    if (filesize($name) > 11) {
        $type = exif_imagetype($name);
    } else {
        $type = false;
    }

    if ($type === false || ($type !== IMAGETYPE_PNG && $type !== IMAGETYPE_JPEG)) {
        return false;
    }
    return $type;
}

function extensionToString($type) {
    if ($type === IMAGETYPE_PNG) {
        return "png";
    } else if ($type === IMAGETYPE_JPEG) {
        return "jpg";
    } else {
        return;
    }
}

function uploadPhotoUser($id, $tmp_name, $type)
{
    $originalFileName = "../images/users/";

    $originalFileName .= "$id.$type";

    move_uploaded_file($tmp_name, $originalFileName);
}

function uploadPhotoRestaurant($id, $tmp_name, $type)
{
    $originalFileName = "../images/restaurants/";

    $originalFileName .= "$id.$type";

    move_uploaded_file($tmp_name, $originalFileName);
}

function uploadPhotoProduct($id, $tmp_name, $type)
{
    $originalFileName = "../images/product/";

    $originalFileName .= "$id.$type";

    move_uploaded_file($tmp_name, $originalFileName);
}

function uploadPhotoMenu($id, $tmp_name, $type)
{
    $originalFileName = "../images/menu/";

    $originalFileName .= "$id.$type";

    move_uploaded_file($tmp_name, $originalFileName);
}
?>
