<form action="form.php"  method="post">
	<table>
      <tr>
         <th>
            <h1>Add new user</h1>
         </th>
      </tr>
		<tr>
      	<td>
            <input type="text" placeholder="First Name"  name="new[firstname]">
      		<input type="text" placeholder="Last Name"  name="new[lastname]">
      		<input type="number" placeholder="Age"  name="new[age]">
            <input type="submit" name="action[add]" value="Add">
      		</td>
      	</tr>

	</table>
</form>

<?php

include "helper.php";
include "db_config.php";

$form_data = $_POST; // saame formi väärtused

if(isset($form_data["action"]["add"])){ // siin tuleks nüüd infot uuendada

   unset($form_data["action"]); // viskan kasutatud key välja, et tsükel oleks lihtsam
   foreach ($form_data as $user_id => $user_data) {
	  // TODO siin vahel tuleks sisend ära puhastada enne DB-sse panekut, et kaitsta rünnakute eest.
	  $update_sql = "INSERT INTO `users` (`firstname`, `lastname`, `age`) VALUES ('".$user_data["firstname"]."','".$user_data["lastname"]."','".$user_data["age"]."')";

	  $insert_query = mysqli_query($link, $update_sql); // <== saada info andmebaasi

	  if($insert_query){

		 echo "<h3 style='color:green;'>User added</h3>";
	  }
   }
}
