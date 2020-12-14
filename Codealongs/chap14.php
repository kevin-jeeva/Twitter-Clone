<?php

//header() sends a raw HTTP header to the browser
function authenticate() {
    //this would be for hard-coded username/password, sometimes useful if you 
    //don't have a database
    //echo $_SERVER["PHP_AUTH_USER"] . "<BR>";
    if ((isset($_SERVER["PHP_AUTH_USER"]) && ($_SERVER['PHP_AUTH_USER'] == 'client') &&
            isset($_SERVER['PHP_AUTH_PW']) && ($_SERVER["PHP_AUTH_PW"] == 'secret'))) {
        header('HTTP/1.0 200 OK'); //all is good!
    } else {
        -
                //don't let them in!
                header('WWW-Authenticate: Basic realm="Test Authentication System"');
        header('HTTP/1.0 401 Unauthorized');
        echo "You must enter a valid login ID and password to access this resource\n";
    }
    exit; //stop execution of the program so we don't get any more errors
}

//end authenticate method
//unset($_SERVER["PHP_AUTH_USER"]);
//$_SERVER["PHP_AUTH_USER"] = $_POST["OldAuth"];
if (!isset(($_SERVER["PHP_AUTH_USER"]))) {
    authenticate(); //call the method
} else {
    ?>
    <p>

        Welcome,<?= $_SERVER["PHP_AUTH_USER"] ?>
    <form action='' method='post'>
        <input type='hidden' name='SeenBefore' value='0' />
        <input type='text' name='OldAuth' value="<?= htmlspecialchars($_SERVER["PHP_AUTH_USER"]) ?>"/>
        <input type='submit' value='Re Authenticate' />
    </form></p>
    <?php
}

//hints for sprint 3
//this is on signup_proc.php
//would normally post via http post
$mypassword = "opensesame"; //$_POST["passwor"];
$myhasedpassword = password_hash($mypassword, PASSWORD_DEFAULT);
echo $myhasedpassword . "<BR>";
echo $_SERVER["PHP_AUTH_USER"];
$phone = $_POST["OldAuth"];
$postal = $_POST["OldAuth"];
echo "Postal".preg_match("/([A-Z]){1}([0-9]){1}([A-Z]){1} ([0-9]){1}([A-Z]){1}([0-9]){1}/",$postal);
//echo "Preg " . preg_match("/\(([0-9]){3}\)-([0-9]){3}-([0-9]){4}/", $phone);
//this is will go in login_proc.php
echo "Password verify : " . password_verify("opensesame", $myhasedpassword) . "<BR>";
echo $_SERVER['REMOTE_ADDR'];
?>