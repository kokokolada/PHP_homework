<?php

include "helper.php";
include "db_config.php";

//DELETE
if($_POST["delete"]) {    
    //    foreach ($form_data as $user_id => $user_data) {
                $delete_query = "DELETE FROM `users` WHERE `id` IN  (" . implode (", ", $_POST["id"]) . ")";
                $delete = mysqli_query($link, $delete_query);

                if($delete){
                   echo "<h3 style='color:green;'>User ".$form_data["firstname"]. "deleted</h3>";
                }
            }        
//EDIT
if($_POST["edit"]) {
    $query = "SELECT * FROM users WHERE id IN (" . implode (", ", $_POST["id"]) . ")";
    $result = mysqli_query($link, $query);

    echo
    '<form action="./form_edit.php" method="post">
        <table>
            <tr>
                <th>
                    <h1>Update user</h1>
                </th>
            </tr>';

    while($row = mysqli_fetch_array($result)) {
        echo
        '<tr>
            <td>
                <input type="hidden" placeholder="id" name="id[]" value="'.$row["id"].'"> 
                <input type="text" placeholder="first Name"  name="firstname[]" value="'.$row["firstname"].'">
                <input type="text" placeholder="last Name"  name="lastname[]" value="'.$row["lastname"].'">
                <input type="number" placeholder="age"  name="age[]" value="'.$row["age"].'">
            </td>
        </tr>';
    }
    echo 
    '<tr>
        <td>
            
            <input type="submit" name="update" value="Update">
        </td>
    </tr>
    </table>
    </form>';
}
//UPDATE
if($_POST["update"]) {
    for ($i = 0; $i < count($_POST["id"]); $i++) {
        $update_sql = "UPDATE `users` SET `firstname`='".$_POST["firstname"][$i]."',`lastname`='".$_POST["lastname"][$i]."',`age`='".$_POST["age"][$i]."' WHERE id='".$_POST["id"][$i]."'";
        $insert_query = mysqli_query($link, $update_sql); // <== saada info andmebaasi

        if($insert_query) {
            echo "<h3 style='color:green;'>User ".$_POST["firstname"][$i]." updated </h3>";
         }
    } 
}
//checks if true or false and depending on that sorts either asc or desc
$sort_column = isset($_GET["sort"]) ? $_GET["sort"] : "id";
$sort_asc = isset($_GET["asc"]) ? $_GET["asc"] : true;
$sort_direction = $sort_asc ? "ASC" : "DESC";

$first_select = "SELECT * FROM `users` ORDER BY " . $sort_column . " " . $sort_direction;
$query_results = mysqli_query($link, $first_select);

?>

<form action="./form_edit.php" method="post">
   <table>
       <tr>
         <th>
            <h1>Users</h1>
         </th>
      </tr>
      <tr>
         <td>
            <span>#</span>
         </td>
         <td>
            <a href="./form_edit.php?sort=id&asc=<?php echo !$sort_asc ?>" >ID</a>
         </td>
         <td>
            <a href="./form_edit.php?sort=firstname&asc=<?php echo !$sort_asc ?>" >First Name</a>
         </td>
         <td>
            <a href="./form_edit.php?sort=lastname&asc=<?php echo !$sort_asc ?>" >Last Name</a>
         </td>
         <td>
            <a href="./form_edit.php?sort=age&asc=<?php echo !$sort_asc ?>" >Age</a>
         </td>
      </tr>
      <?php
         while ($result = mysqli_fetch_assoc($query_results)) {
            echo '<tr>
                     <td>
                        <input type="checkbox" name="id[]" value="'.$result["id"].'">
                     </td>
                     <td>
                        <span>'.$result["id"].'</span>
                     </td>
                    <td>
                        <span>'.$result["firstname"].'</span>
                    </td>
                    <td>
                        <span>'.$result["lastname"].'</span>
                    </td>
                    <td>
                        <span>'.$result["age"].'</span>
                    </td>
                </tr>';
         }
      ?>
      <tr>
         <td>
            <input type="submit" name="delete" value="Delete">
            <input type="submit" name="edit" value="Edit">
            <button><a href="form.php">Add New User</a></button>
         </td>
      </tr>
   </table>
</form>


