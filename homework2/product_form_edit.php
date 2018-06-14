<?php

include "helper.php";
include "db_config.php";


//DELETE
if($_POST["delete"]) {
    $delete_query = "DELETE FROM `products` WHERE `product_id` IN (" . implode (", ", $_POST["product_id"]) . ")";
    echo $delete_query;
    $delete = mysqli_query($link, $delete_query);

    if($delete){
        echo "<h3 style='color:green;'>product deleted ".$form_data["name"]."</h3>";
    }
}
    
//EDIT
if($_POST["edit"]) {
    $query = "SELECT * FROM `products` WHERE `product_id` IN (" . implode (", ", $_POST["product_id"]) . ")";
    $edit_result = mysqli_query($link, $query);
    $product_result = mysqli_fetch_assoc($edit_result);
var_dump($product_result);

    $query_all_users = "SELECT * FROM `users`";
    $all_users_results = mysqli_query($link, $query_all_users);

    $chosen_owner_choice = "";

    while($user_result = mysqli_fetch_assoc($all_users_results)) {
        if($user_result["id"] == $product_result["owner_id"]) {
            $chosen_owner_choice .= "<option value ='".$user_result["id"]."' selected>".$user_result["firstname"]." ".$user_result["lastname"]."</option>";
        }
        else {
            $chosen_owner_choice .= "<option value ='".$user_result["id"]."'>".$user_result["firstname"]." ".$user_result["lastname"]."</option>";
        }
    }
    
    echo
    '<form action="./product_form_edit.php" method="post">
        <table>
            <tr>
                <th>
                    <h1>Update product</h1>
                </th>
            </tr>
        <tr>
            <td>
                <input type="hidden" placeholder="product_id" name="update[product_id]" value="'.$product_result["product_id"].'"> 
                <input type="text" placeholder="name"  name="update[name]" value="'.$product_result["name"].'">
                <input type="text" placeholder="description"  name="update[description]" value="'.$product_result["description"].'">
                <input type="number" placeholder="price"  name="update[price]" value="'.$product_result["price"].'">
                <select name="update[owner]">
                    '.$chosen_owner_choice.'
                </select>
            </td>
        </tr>
        <tr>
        <td>
            
            <input type="submit" name="action[update]" value="Update">
        </td>
    </tr>
    </table>
    </form>';
}
//UPDATE
if($_POST["update"]) {

    $form_data = $_POST["update"];
    //     foreach ($form_data as $product_data) {
    $update_sql = "UPDATE `products` SET `name`='".$form_data["name"]."',`description`='".$form_data["description"]."',`price`=".$form_data["price"]." ,`owner_id`=".$form_data["owner"]." WHERE product_id=".$form_data["product_id"];

    $insert_query = mysqli_query($link, $update_sql); // <== saada info andmebaasi

	  if($insert_query){
		 echo "<h3 style='color:green;'>Product ".$form_data["name"]." updated </h3>";
      }
//    }
}

$sort_column = isset($_GET["sort"]) ? $_GET["sort"] : "product_id";
$sort_asc = isset($_GET["asc"]) ? $_GET["asc"] : true;
$sort_direction = $sort_asc ? "ASC" : "DESC";

$first_select = "SELECT * FROM `products` ORDER BY " . $sort_column . " " . $sort_direction;
$query_results = mysqli_query($link, $first_select);

?>

<form "./product_form_edit.php" method="post">
   <table>
       <tr>
         <th>
            <h1>Products</h1>
         </th>
      </tr>
      <tr>
         <td>
            <span>#</span>
         </td>
         <td>
         <a href="./product_form_edit.php?sort=product_id&asc=<?php echo !$sort_asc ?>" >ID</a>
         </td>
         <td>
         <a href="./product_form_edit.php?sort=name&asc=<?php echo !$sort_asc ?>" >Name</a>
         </td>
         <td>
         <a href="./product_form_edit.php?sort=description&asc=<?php echo !$sort_asc ?>" >Description</a>
         </td>
         <td>
         <a href="./product_form_edit.php?sort=price&asc=<?php echo !$sort_asc ?>" >Price</a>
         </td>
         <td>
            <span>Owner</span>
         </td>
      </tr>
      <?php
         while ($result = mysqli_fetch_assoc($query_results)) {
             $specific_user_select = "SELECT * FROM  `users` WHERE `id`=".$result["owner_id"];
             $specific_user_result = mysqli_query($link, $specific_user_select);
             $select_user  = mysqli_fetch_assoc($specific_user_result);
            echo '<tr>
                     <td>
                        <input type="radio" name="product_id[]" value="'.$result["product_id"].'">
                     </td>
                     <td>
                     <span>'.$result["product_id"].'</span>
                  </td>
                     <td>
                        <span>'.$result["name"].'</span>
                     </td>
                     <td>
                        <span>'.$result["description"].'</span>
                     </td>
                     <td>
                        <span>'.$result["price"].'</span>
                     </td>
                     <td>
                     <span>'.$select_user["firstname"].' '.$select_user["lastname"].'</span>
                  </td>
                  </tr>
                 ';
         }
         
      ?>
       <tr>
                <td>
                    <input type="submit" name="delete" value="Delete">
                    <input type="submit" name="edit" value="Edit">
                    <button><a href="product_form.php">Add New Product</a></button>
                </td>
            </tr>
   </table>
</form>


