<?php
//including the database connection file
include_once("includes/Crud.php");
include_once("includes/Validation.php");
 
$crud = new Crud();
$validation = new Validation();
 
if(isset($_POST['Submit'])) {    
    $name = $crud->escape_string($_POST['name']);
    $age = $crud->escape_string($_POST['age']);
    $email = $crud->escape_string($_POST['email']);
        
    $msg = $validation->check_empty($_POST, array('name', 'age', 'email'));
    $check_age = $validation->is_age_valid($_POST['age']);
    $check_email = $validation->is_email_valid($_POST['email']);
    
    // checking empty fields
    if($msg != null) {
        echo $msg;        
        //link to the previous page
        echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
    } elseif (!$check_age) {
        echo 'Please provide proper age.';
    } elseif (!$check_email) {
        echo 'Please provide proper email.';
    }    
    else { 
        // if all the fields are filled (not empty) 
            
        //insert data to database    
        $result = $crud->execute("INSERT INTO users(name,age,email) VALUES('$name','$age','$email')");
        
        //display success message
        echo "<font color='green'>Data added successfully.";
        echo "<br/><a href='index.php'>View Result</a>";
    }
}
?>
<html>
<head>
    <title>Add Data</title>
</head>
 
<body>
    <a href="index.php">Home</a>
    <br/><br/>
 
    <form action="" method="post" name="form1">
        <table width="25%" border="0">
            <tr> 
                <td>Name</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr> 
                <td>Age</td>
                <td><input type="text" name="age"></td>
            </tr>
            <tr> 
                <td>Email</td>
                <td><input type="text" name="email"></td>
            </tr>
            <tr> 
                <td></td>
                <td><input type="submit" name="Submit" value="Add"></td>
            </tr>
        </table>
    </form>
</body>
</html>