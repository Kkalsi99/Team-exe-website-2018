<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id" content="307712715810-5gqv439ef8l9hmmod3ggpbdplcc7t7gq.apps.googleusercontent.com">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Team .EXE is the technical team of Computer Science & Engineering Department for technical fest NIMBUS at NIT Hamirpur.">
    <meta name="author" content="Team .EXE">
    <link rel="icon" href="images/title.png">

    <title>Login - Team .EXE</title>

  </head>

<?php
session_start(); //session start

require_once ('libraries/Google/autoload.php');
include_once('stylesheets.php'); 
include_once('header.php');
include_once('navigation.php');
include_once('dbconnect.php');

//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
$client_id = '307712715810-5gqv439ef8l9hmmod3ggpbdplcc7t7gq.apps.googleusercontent.com'; 
$client_secret = 'yvXrJI4PIvIEtJr4G-DBd44N';
$redirect_uri = 'http://localhost/exe/login.php';

/*//database
$db_username = "xxxxxxxxx"; //Database Username
$db_password = "xxxxxxxxx"; //Database Password
$host_name = "localhost"; //Mysql Hostname
$db_name = 'xxxxxxxxx'; //Database Name
*/

/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

/************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
 ************************************************/
$service = new Google_Service_Oauth2($client);

/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
*/
  
if (isset($_GET['code'])) 
{
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

/************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) 
{
  $client->setAccessToken($_SESSION['access_token']);
} 
else 
{
  $authUrl = $client->createAuthUrl();
}

//Display user info or display login url as per the info we have.
echo "<br><br><br>";
echo '<div class="jumbotron">';
echo '<div class="container">';

if (isset($authUrl))
{ 
	//show login url
	echo '<div align="center">';
	echo '<img class="btlog1" src="images/logo.png"><br>';
	echo "<h3><code>Team .EXE wants you to Sign In to your Google account</code></h3><br>";
	echo '<a class="login" href="' . $authUrl . '"><img class="btlog1" src="images/signin_button.png" /></a>';
	
} 
else 
{
	
	$user = $service->userinfo->get(); //get user info 
	$_SESSION['login_user']=$user['id'];
	include_once('user_session.php');
	
	//check if user exist in database using COUNT
$resulta = mysqli_query($link,"SELECT COUNT(google_id) as usercount FROM users WHERE google_id=$user->id");
$user_count = $resulta->fetch_object()->usercount; //will return 0 if user doesn't exist
	
	//show user picture
	echo '<img src="'.$user->picture.'" style="float: right;margin-top: 33px; width:40%;" />';
	
	if($user_count!=0) //if user already exist change greeting text to "Welcome Back"
    {
        
echo '<h3> Welcome back <b><a href="profile.php">'.$user->name.'</a></b> Nice to see you again!</h3>';

    }
	else //else greeting text "Thanks for registering"
	{ 
        echo '<code><h3>Hi <b><a href="profile.php">'.$user->name.'</a></b>, Thanks for Registering!</code></h3>';
		$qaryu=mysqli_query($link,"INSERT INTO users (google_id, name, email, link, picture) VALUES('$user->id','$user->name', '$user->email', '$user->link', '$user->picture')");
    }
	
	//print user details
	/*echo '<pre>';
	print_r($user);
	echo '</pre>';*/
}
include_once('user_navigation.php');
echo '</div>';
echo '</div>';
echo '</div>';
echo "</center>";
include_once('footer.php');

?>

