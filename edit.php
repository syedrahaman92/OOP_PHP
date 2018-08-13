<?php
// including the database connection file
include_once("includes/Crud.php");
include_once("includes/Validation.php");
 
$crud = new Crud();
$validation = new Validation();
 
if(isset($_POST['update']))
{    
    $id = $crud->escape_string($_POST['id']);
    
    $name = $crud->escape_string($_POST['name']);
    $age = $crud->escape_string($_POST['age']);
    $email = $crud->escape_string($_POST['email']);
    
    $msg = $validation->check_empty($_POST, array('name', 'age', 'email'));
    $check_age = $validation->is_age_valid($_POST['age']);
    $check_email = $validation->is_email_valid($_POST['email']);
    
    // checking empty fields
    if($msg) {
        echo $msg;        
        //link to the previous page
        echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
    } elseif (!$check_age) {
        echo 'Please provide proper age.';
    } elseif (!$check_email) {
        echo 'Please provide proper email.';    
    } else {    
        //updating the table
        $result = $crud->execute("UPDATE users SET name='$name',age='$age',email='$email' WHERE id=$id");
        
        //redirectig to the display page. In our case, it is index.php
        header("Location: index.php");
    }
}
 
//getting id from url
$id = $crud->escape_string($_GET['id']);
 
//selecting data associated with this particular id
$result = $crud->getData("SELECT * FROM users WHERE id=$id");
 
foreach ($result as $res) {
    $name = $res['name'];
    $age = $res['age'];
    $email = $res['email'];
}
?>
<html>
<head>    
    <title>Edit Data</title>
</head>
 
<body>
    <a href="index.php">Home</a>
    <br/><br/>
    
    <form name="form1" method="post" action="">
        <table border="0">
            <tr> 
                <td>Name</td>
                <td><input type="text" name="name" value="<?php echo $name;?>"></td>
            </tr>
            <tr> 
                <td>Age</td>
                <td><input type="text" name="age" value="<?php echo $age;?>"></td>
            </tr>
            <tr> 
                <td>Email</td>
                <td><input type="text" name="email" value="<?php echo $email;?>"></td>
            </tr>
            <tr>
                <td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
</body>
</html>