<?php
$Name= $_POST['Name'];
$Gender= $_POST['Gender'];
$phoneno= $_POST['phoneno'];
$myEmail= $_POST['myEmail'];
$Password= $_POST['Password'];
$myIdentity= $_POST['myIdentity'];
$myFile= $_POST['myFile'];
$myWork= $_POST['myWork'];
$mydoj= $_POST['mydoj'];

if(!empty($Name)|| !empty($Gender)|| !empty($phoneno)|| !empty($myEmail)|| !empty($Password)|| !empty($myIdentity)|| !empty($myFile)|| !empty($myWork)|| !empty($mydoj)){
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "myphpadmin";

    $conn = new mysqli($host,$dbUsername,$dbPassword,$dbname);
    if(mysqli_connect_error()){
        die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
    }
    else{
        $SELECT = "SELECT myEmail FROM register WHERE myEmail = ? OR phoneno = ? LIMIT 1";
        $INSERT = "INSERT Into register ( Name,Gender,phoneno,myEmail,Password,myIdentity,myFile,myWork,mydoj) values(?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("ss",$myEmail, $phoneno);
        $stmt->execute();
        $stmt->bind_result($myEmail);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
    
        if($rnum==0){
            $stmt->close();
        
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssisssbss",$Name,$Gender,$phoneno,$myEmail,$Password,$myIdentity,$myFile,$myWork,$mydoj);
            $stmt->execute();
            echo "New record inserted successfully";
        } else {
            echo "Someone already registered using this email or phone number.";
            $stmt->close();
            $conn->close();
            die();
        }
    }
}
?>
