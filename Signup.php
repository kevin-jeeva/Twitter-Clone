<!DOCTYPE html>
<?php 
include("User.php");//INCLUDE THE USER CLASS
session_start();
if (isset($_SESSION["user_Id"])) {
    header("location:index.php");
    //exit;
} else {
    // session_destroy();
   //header("location:Login.php");
}
if(isset($_GET["message"]))
{
    $message = $_GET["message"];
    echo  "<script>alert('$message')</script>";
}
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Bitter signup page">
    <meta name="author" content="Kevin Daniel">
    <link rel="icon" href="favicon.ico">

    <title>Signup - Bitter</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/starter-template.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script type="text/javascript" src="jquery-3.3.1.min.js"></script>
    <script src="includes/bootstrap.min.js"></script>    
    <script type="text/javascript">
	//any JS validation you write can go here
        //some checkers variables
       var msg = "";
        var count = 0;
        var passCount = 0;
        var reCount = 0;
        
        var $ = function(id) 
        {
	return document.getElementById(id);
        }
        
        //main validate method
        var Validate = function()
        {              var ReCk = new RegExCheck();
              for(var i =1; i <= 12; i++)
              {
                  switch(i)
                  {
                    case 1:
                       trimFun("firstname");
                       CheckLength("firstname",50);
                       break;
                    case 2:
                       trimFun("lastname");
                       CheckLength("lastname",50);
                       break;
                    case 3:
                        trimFun("email");
                        CheckLength("email",100);
                        break;
                    case 4:
                        trimFun("username");
                        CheckLength("username",50);
                        break;
                    case 5:
                        trimFun("password");
                        CheckLength("password",250);
                        break;
                    case 6:
                        trimFun("confirm");
                        CheckLength("confirm",250);
                        PasswordMatch("password","confirm");
                        break;
                    case 7:
                        trimFun("phone");
                        var v = $("phone").value;
                        v = v.trim();
                        try{
                        if(!ReCk.Phone(v))
                        {
                            count += 1;
                            msg += "Please enter a valid phone number \n";
                        }
                    }
                    catch(ex)
                    {
                        alert(ex.message);
                    }
                        break;
                    case 8:
                        trimFun("address");
                        CheckLength("address",200);
                        break;                    
                    case 9:
                        trimFun("postalCode");  
                        var v = $("postalCode").value;
                        v = v.trim();
                        try{
                        if(!ReCk.Postal(v))
                        {
                            count += 1;
                            msg += "Please enter a valid postal code \n";
                        }
                    }
                    catch(ex)
                    {
                        alert(ex.message);
                    }
                        break;
                    case 10:
                        trimFun("url");
                        CheckLength("url",50);
                        break;
                    case 11:
                        trimFun("desc");
                        CheckLength("desc",160);
                        break;
                    case 12:
                        trimFun("location");
                        CheckLength("location",50);
                        break;                   
                  }
              }
              
           if(count == 0)
           {
             //alert("Very good job");  
             return true;
           }
          else
            {
                alert(msg);
                msg = "";
                count = 0;
                return false;
             }   
            
    }
    
        //password matching    
        var PasswordMatch = function(pass, cnfPass)
        {
           var pass1 = $(pass).value;
           var pass2 = $(cnfPass).value;
            
            if(pass1 == pass2)
            {
                count += 0;
            }
            else
            {
                count += 1;
                msg += "Please enter a valid password \n";
            }
        }
        
        //whitespace checking
        var trimFun = function(id)
        {          
           var Val = $(id).value;          
           Val = Val.trim();
            if(Val == "")
            {
                msg += id + " required " +"\n";
                count += 1;                
                return false;
            }
            else
            {                
                return true;
            }
            
        }
        //Length checking
        var CheckLength = function(id, len)
        {
            var val = $(id).value;
            val = val.trim();
            if(val.length > len)
            {
                count += 1;
                 msg += id+" should be less than " + len + "Characters \n";
            }
        }
        //checking phone number and Postal code
        var RegExCheck = function()
        {
            this.Postal = function(id)
            {               
                var pattern = /^[A-Z]\d[A-Z] \d[A-Z]\d$/;
                return pattern.test(id);
            };
            this.Phone = function(id)
            {
               
                var pattern = /^\(\d{3}\) \d{3}-\d{4}$/;
                return pattern.test(id);
            };
        }
        
	</script>
  </head>

  <body>
 <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<a class="navbar-brand" href="inde "><img src="images/logo.jpg" class="logo"></a>
		
        
      </div>
    </nav>

	<BR><BR>
    <div class="container">
		<div class="row">
			
			<div class="main-login main-center">
				<h5>Sign up once and troll as many people as you like!</h5>
                                <form method="post" id="registration_form" onsubmit="return Validate()"action="signup_proc.php">
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">First Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="firstname" id="firstname"  placeholder="Enter your First Name"/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Last Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="lastname" id="lastname"  placeholder="Enter your Last Name"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Your Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="email" id="email"  placeholder="Enter your Email"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Screen Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
                                                                    
                                              
	
                                                                    <input type="text" class="form-control" required name="username" id="username" placeholder="Enter your Screen Name"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="password" class="form-control" required name="password" id="password"  placeholder="Enter your Password"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="password" class="form-control" required name="confirm" id="confirm"  placeholder="Confirm your Password"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Phone Number</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="phone" id="phone"  placeholder="Enter your Phone Number Example: (123) 123-1234"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Address</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="address" id="address"  placeholder="Enter your Address"/>
								</div>
							</div>
						</div>
						
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Province</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<select name="province" id="province" class="textfield1" required><?php echo $vprovince; ?> 
										<option> </option>
										<option value="British Columbia">British Columbia</option>
										<option value="Alberta">Alberta</option>
										<option value="Saskatchewan">Saskatchewan</option>
										<option value="Manitoba">Manitoba</option>
										<option value="Ontario">Ontario</option>
										<option value="Quebec">Quebec</option>
										<option value="New Brunswick">New Brunswick</option>
										<option value="Prince Edward Island">Prince Edward Island</option>
										<option value="Nova Scotia">Nova Scotia</option>
										<option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
										<option value="Northwest Territories">Northwest Territories</option>
										<option value="Nunavut">Nunavut</option>
										<option value="Yukon">Yukon</option>
									  </select>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Postal Code</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="postalCode" id="postalCode"  placeholder="Enter your Postal Code Example: E3B 9W9"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Url</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="url" id="url"  placeholder="Enter your URL"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Description</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" required name="desc" id="desc"  placeholder="Description of your profile"/>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Location</label>
							<div class="cols-sm-10">
								<div class="input-group">
									
									<input type="text" class="form-control" name="location" id="location"  placeholder="Enter your Location"/>
								</div>
							</div>
						</div>
						
						
						<div class="form-group ">
							<input type="submit" name="button" id="button" value="Register" class="btn btn-primary btn-lg btn-block login-button"/>
							
						</div>
						
					</form>
				</div>
			
		</div> <!-- end row -->
    </div><!-- /.container -->
    <script>
        
      
    </script>
  </body>
</html>

<?php

if(isset($_SESSION["alert"]) && ($_SESSION["alert"] != ""))
{
    $message = $_SESSION["alert"];
    echo  "<script>alert('$message')</script>";
    $_SESSION["alert"] = "";
}

?>