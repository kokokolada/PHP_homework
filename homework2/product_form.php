
<?php

include "helper.php";
include "db_config.php";

$query_users  = "SELECT * FROM `users`";
$user_results = mysqli_query($link, $query_users);

$owner_choice = "";

while ($result = mysqli_fetch_assoc($user_results)) {
    $owner_choice .= "<option value ='" . $result["id"] . "'>" . $result["firstname"] . " " . $result["lastname"] . "</option>";
}
echo '<form action="product_form.php"  method="post">
      <table>
            <tr>
                  <th>
                  <h1>Add new product</h1>
                  </th>
            </tr>
            <tr>
                  <td>
                        <input type="text" placeholder="ProductName" name="new[name]">
                        <input type="text" placeholder="ProductDescription" name="new[description]">
                        <input type="number" placeholder="Price" name="new[price]">
                        <select name="new[owner]">' . $owner_choice . '</select>
                        <input type="submit" name="action[add]" value="Add">
                  </td>
            </tr>
      </table>
</form>';

$form_data = $_POST; // saame formi väärtused

if (isset($form_data["action"]["add"])) { // siin tuleks nüüd infot uuendada
      unset($form_data["action"]); // viskan kasutatud key välja, et tsükel oleks lihtsam

      foreach ($form_data as $product_id => $product_data) {

            // TODO siin vahel tuleks sisend ära puhastada enne DB-sse panekut, et kaitsta rünnakute eest.
            $update_sql = "INSERT INTO `products` (`name`, `description`, `price`, `owner_id`) VALUES ('" . $product_data["name"] . "','" . $product_data["description"] . "'," . $product_data["price"] . "," . $product_data["owner"] . ")";
            echo $update_sql;

            $insert_query = mysqli_query($link, $update_sql); // <== saada info andmebaasi
            
            if ($insert_query) {
            
            echo "<h3 style='color:green;'>Product added</h3>";
            }
      }
}