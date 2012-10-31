<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <title>Generate username</title>
</head>
<body>
  <div id="wrapper">
    <div id="content">
      <div id="adduser">
        <?php
        if(isset($_POST['add-submit']))
        {
          $dbhost="localhost";     //host name
          $dbuser="root";		    //mysql username
          $dbpass="root"; 				//mysql password
          $dbname="test";  		//database name
          $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)
          or die ("Could not select database because ".mysqli_error());
          mysqli_query($link, "SET NAMES UTF8");
          $firstname=mysqli_real_escape_string($link, trim($_POST['firstname']));
          $lastname=mysqli_real_escape_string($link, trim($_POST['lastname']));
          if(empty($firstname)&&empty($lastname))
          {
            echo "You entered nothing!<br />";
            return;
          }
          else
          {
            if(!empty($firstname))
            {
              $checkfirstname=mysqli_query($link, "SELECT * FROM firstname WHERE firstname='$firstname'")
              or die ("Could not match data because ".mysqli_error($link));
              $numfirstname=mysqli_num_rows($checkfirstname);
              if($numfirstname<1)
              {
                $addfirstname=mysqli_query($link, "INSERT INTO firstname (firstname)
                VALUES ('$firstname')")
                or die ("Could not match data because ".mysqli_error($link));
                echo "The firstname of <b>".$firstname."</b> is added.<br />";
              }
              else
              {
                echo "The firstname of <b>".$firstname."</b> already exist in the database.<br />";
              }
            }
            if(!empty($lastname))
            {
              $checklastname=mysqli_query($link, "SELECT * FROM lastname WHERE lastname='$lastname'")
              or die ("Could not match data because ".mysqli_error($link));
              $numlastname=mysqli_num_rows($checklastname);
              if($numlastname<1)
              {
                $addlastname=mysqli_query($link, "INSERT INTO lastname (lastname)
                VALUES ('$lastname')")
                or die ("Could not match data because ".mysqli_error($link));
                echo "The lastname of <b>".$lastname."</b> is added.<br />";
              }
              else
              {
                echo "The lastname of <b>".$lastname."</b> already exist in the database.<br />";
              }
            }
          }
          mysqli_close($link);
        }
        ?>
        <form action="index.php" method="post" >
          <fieldset>
            First Name: <input type="text" name="firstname"
            value="<?php if (isset($_POST['firstname'])) 
            {print stripslashes($_POST['firstname']);} ?>"><br>
            Last Name: <input type="text" name="lastname"
            value="<?php if (isset($_POST['lastname'])) 
            {print stripslashes($_POST['lastname']);} ?>"><br>
            <input name="add-submit" type="submit" value="submit">
          </fieldset>
        </form>
      </div>
      <div id="output">
        <form action="index.php" method="post" >
          <fieldset>
            How many user name do you want?: <input type="text" name="numberofname"
            value="<?php if (isset($_POST['numberofname'])) 
            {print stripslashes($_POST['numberofname']);} ?>">
            <input name="generate-submit" type="submit" value="submit">
          </fieldset>
        </form>
        <center>
          <table>
            <?php
            $dbhost="localhost";     //host name
            $dbuser="root";		    //mysql username
            $dbpass="root"; 				//mysql password
            $dbname="test";  		//database name
            $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)
            or die ("Could not select database because ".mysqli_error());
            mysqli_query($link, "SET NAMES UTF8");
            if(isset($_POST['generate-submit']))
            {
              if(empty($_POST['numberofname']))
              {
                echo "Please input how many username you want?<br />";
              }
              else
              {
                if(!is_numeric($_POST['numberofname']))
                {
                  echo "Please enter a number!";
                }
                else
                {
                  $numberofname=$_POST['numberofname'];
                  $firstnamearray=array();
                  $lastnamearray=array();
                  print "<tr><th>First name</th><th>Last name</th>            <th>User name</th></tr>";
                  $firstname = mysqli_query($link, "SELECT * FROM firstname")
                  or die ("Could not match data because ".mysqli_error($link));
                  $numberofirstname= mysqli_num_rows($firstname);
                  while ($row = mysqli_fetch_array($firstname)) 
                  {
                    $firstnamearray[]=$row['firstname'];
                  }
                  $lastname = mysqli_query($link, "SELECT * FROM lastname")
                  or die ("Could not match data because ".mysqli_error($link));
                  $numberolastname= mysqli_num_rows($lastname);
                  while ($row = mysqli_fetch_array($lastname)) 
                  {
                    $lastnamearray[]=$row['lastname'];
                  }
                  shuffle($firstnamearray);
                  shuffle($lastnamearray);
                  //var_dump($firstnamearray);
                  //var_dump($lastnamearray);
                  for($i=0;$i<$numberofname;$i++)
                  {
                    $first=$firstnamearray[rand(0,$numberofirstname-1)];
                    $last=$lastnamearray[rand(0,$numberolastname-1)];
                    $usernamearray[0]=$first.$last;
                    $usernamearray[1]=$first.'_'.$last;
                    $usernamearray[2]=$last;
                    $usernamearray[3]=$first.'.'.$last;
                    $usernamearray[4]=$first[0].$last;
                    $usernamearray[5]=$first.$last[0];
                    $username=$usernamearray[rand(0,5)];
                    print "<tr><td>".$first."</td><td>".$last."</td><td>".$username."</td></tr>";
                  }
                }
              }
            }
            mysqli_close($link);
            ?>
          </table>
        </center>
      </div>
    </div>
    <!-- End #content -->
  </div>    
  <!-- End #wrapper -->
</body>
</html>