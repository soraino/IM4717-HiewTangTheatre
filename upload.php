<?php

$userId = $_POST['userId'];

$fName = $_FILES['fileToUpload']['name'];
$fSize = $_FILES['fileToUpload']['size'];
$fType = $_FILES['fileToUpload']['type'];

// echo $fName;
// echo $fSize;
// echo $fType;

$timestamp = date("Ymd_His");
// echo $timestamp;

$target = "uploaded_files/" . $userId . $timestamp . $fName;
// echo $target;

if ($fSize < 30000) {
    if ($fType == "image/jpg" or $fType == "image/jpg" or $fType == "image/png") {
        $result = move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);

        if ($result) {
            echo $fName . " Uploaded";
            doSaveData($userId, $target);
        } else {
            echo $result;
            echo $fName . " Failed to upload";
        }
    } else {
        echo "Invalid file type!";
    }
} else {
    echo "File is too large!";
}

function doSaveData($userId, $target)
{
    $db = new mysqli('localhost', 'f34ee', 'f34ee', 'f34ee');

    if (mysqli_connect_errno()) {
        echo 'Error: Could not connect to database.';
        exit;
    }

    $sql = "Insert into User (ImgUrl) VALUES ('$target') where User.Id = '" . $userId . "'";
    $result = $db->query($sql);

    if ($result == true) {
        echo "Data saved!";
    } else {
        echo "Data NOT saved!";
    }
}
