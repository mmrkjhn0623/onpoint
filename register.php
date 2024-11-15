
<!DOCTYPE html>
<html>
<head>
    <title>EmailJS and PHP</title>
</head>
<body>
<?php
session_start();

$email = $_POST['registerEmail'];
$bname = $_POST['registerBname'];

include "config.php";

$sql="SELECT user_id,username FROM users WHERE username = '".$email."'";
$result = mysqli_query($conn,$sql);

function generateRandomString($length = 15) {
    return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length)), 0, $length);
}
$pwd = generateRandomString();
if($row = mysqli_fetch_array($result)) {
	header("Location: createaccount.php?invalid=1");
}
else{
    $newuser = "INSERT INTO users (username, password, nickname, company_id) VALUES ('".$email."','".$pwd."','User','')";
    $conn->query($newuser);

    $sqlforuserid = "SELECT user_id FROM users WHERE username = '".$email."' and password = '".$pwd."'";
    $queryuserid = mysqli_query($conn,$sqlforuserid);
    $userid = mysqli_fetch_array($queryuserid);


    $newcompany = "INSERT INTO company ( name, address, contact) VALUES ( '".$bname."', 'Not Available', 'Not Available')";
    $conn->query($newcompany);

    $sqlforcompanyid = "SELECT company_id FROM company WHERE name = '".$bname."' and address = 'Not Available' and contact = 'Not Available'";
    $querycompanyid = mysqli_query($conn,$sqlforcompanyid);
    $companyid = mysqli_fetch_array($querycompanyid);

    $sqlusercompany = "UPDATE users SET company_id = '".$companyid["company_id"]."' WHERE users.user_id = '".$userid["user_id"]."'";
    $conn->query($sqlusercompany);

    $sqlforinvoice = "INSERT INTO invoice ( si_no, item_id, sold_price, quantity, date, company_id) VALUES ( '0', '0', '0', '0', 'now()', '".$companyid["company_id"]."')";
    $conn->query($sqlforinvoice);

    echo "<input type='hidden' id='emailaddress' value='".$email."' />";
    echo "<input type='hidden' id='pwd' value='".$pwd."' />";

    echo "Added User: 1<br/>";
    echo "Company ID:". $companyid["company_id"];
}
mysqli_close($conn);
?>
<script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
</script>
<script type="text/javascript">
   (function(){
      emailjs.init({
        publicKey: "lR9LmmL0XNeKWf5V5",
      });
      emailjs.send("service_ar0ifgb","template_85bq2vo",{
            from_name: "Onpoint",
            generated_pwd: document.getElementById("pwd").value,
            send_to: document.getElementById("emailaddress").value,
            }).then(
            (response) => {
                console.log("Email sent successfully!", response.status, response.text);
            },
            (error) => {
                console.error("Email send failed:", error);
            }
        );
   })();
</script>

</body>
</html>