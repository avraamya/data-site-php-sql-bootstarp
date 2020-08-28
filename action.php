<?php
require_once 'crud.php';
$object = new crud();
if (isset($_POST["action"])) {
    if ($_POST["action"] == "Filter") {
        if (isset($_POST["query"])) {
            $search = $object->validate('search',$_POST["query"]);
            $query = "
            SELECT * FROM product 
            WHERE name LIKE '%" . $search . "%'
            OR description LIKE '%" . $search . "%' 
            OR price LIKE '%" . $search . "%' 
            OR picture LIKE '%" . $search . "%' 
            ";
        } else {
            $query = "
            SELECT * FROM product ORDER BY id
            ";
        }
        $result = mysqli_query($object->connect, $query);
        if ($result->num_rows > 0) {
            echo $object->print_table ($query);
        } else {
            echo 'Data Not Found';
        }
    }
    if ($_POST["action"] == "Load") {
        echo $object->print_table("SELECT * FROM product ORDER BY id");
    }
    if ($_POST["action"] == "Insert") {
        $name = $object->validate('text',$_POST["name"]);
        $description = $object->validate('text',$_POST["description"]);
        $price = $object->validate('int',$_POST["price"]);
        $picture = "upload/".$object->upload_file($_FILES["image"]);
        if($name != '' && $description != '' && $price != '' && $picture != "upload/")
        {
            $query = "  
           INSERT INTO product  
           (name, description, price,picture)   
           VALUES ('" . $name . "', '" . $description . "'," . $price . " , '" . $picture . "')  
           ";
            $object->execute_query($query);
            echo 'The form has been submitted';
        }
        else
        {
            echo 'The form has not been submitted';
        }
    }
    if ($_POST["action"] == "Fetch") {
        $output [] = '';
        $query = "SELECT * FROM product WHERE id = '" . $_POST["user_id"] . "'";
        $result = $object->execute_query($query);
        while ($row = mysqli_fetch_array($result)) {
            $output["name"] = $row['name'];
            $output["description"] = $row['description'];
            $output["price"] = $row['price'];
            $output["picture"] = $row['picture'];
        }
        echo json_encode($output);
    }
    if ($_POST["action"] == "Edit") {
        $query = "SELECT * FROM product WHERE id = '" . $_POST["user_id"] . "'";
        $prevPicture = $object->get_image($query );
        $name = $object->validate('text',$_POST["name"]);
        $description = $object->validate('text',$_POST["description"]);
        $price = $object->validate('int',$_POST["price"]);
        $picture = "upload/".$object->upload_file($_FILES["image"]);
        if($name != '' && $description != '' && $price != '' && $picture != "upload/")
        {
            $query = "UPDATE product SET name = '$name', description = '$description', price = '$price' , picture = '$picture' WHERE id = '" . $_POST["user_id"] . "'";
            $object->execute_query($query);
            $object->delete_image('Edit',$prevPicture);
            echo 'Data Updated';
        }
        else
        {
            echo 'Data Was Not Updated';
        }
    }
    if ($_POST["action"] == "Delete") {
        $query = "SELECT * FROM product WHERE id = '" . $_POST["user_id"] . "'";
        $picture = $object->get_image($query );
        $object->delete_image('Delete',$picture);
        $query = "DELETE FROM product WHERE id = '" . $_POST["user_id"] . "'";
        $object->execute_query($query);
        echo 'Data Deleted';
    }
}
?>