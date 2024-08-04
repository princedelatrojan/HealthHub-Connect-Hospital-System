<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "hms");

if(isset($_POST['patsub1'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if($password == $cpassword){
        // Use prepared statements to prevent SQL injection
        $query = "INSERT INTO patreg(fname, lname, gender, email, contact, password, cpassword) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "sssssss", $fname, $lname, $gender, $email, $contact, $password, $cpassword);
        $result = mysqli_stmt_execute($stmt);

        if($result){
            $_SESSION['username'] = $fname . " " . $lname;
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['gender'] = $gender;
            $_SESSION['contact'] = $contact;
            $_SESSION['email'] = $email;
            header("Location: admin-panel.php");
            exit();
        } else {
            header("Location: error.php");
            exit();
        }
    } else {
        header("Location: error1.php");
        exit();
    }
}

if(isset($_POST['update_data'])) {
    $contact = $_POST['contact'];
    $status = $_POST['status'];
    $query = "UPDATE appointmenttb SET payment=? WHERE contact=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $status, $contact);
    $result = mysqli_stmt_execute($stmt);
    if($result)
        header("Location: updated.php");
    exit();
}

// Function to display doctors
function display_docs() {
    global $con;
    $query = "SELECT * FROM doctb";
    $result = mysqli_query($con, $query);
    while($row = mysqli_fetch_array($result)) {
        $name = $row['name'];
        echo '<option value="'.$name.'">'.$name.'</option>';
    }
}

// Display Admin Panel
function display_admin_panel(){
    // Your HTML/PHP code for admin panel here
}
?>
