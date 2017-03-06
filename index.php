<!DOCTYPE html>
<html>
<head>
  	<title>Social Networking Site</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
          integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
          crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/ajax.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Chat Room</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Login</a></li>
                    <li><a href="register.php">Regsiter</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="login">
        <div class="container">
            <div class="col-md-8 col-md-offset-2">
                <form acction="login.php" onsubmit="return false;">
                    <lable class="spacing">Email</lable>
                    <input class="form-control spacing" type="email" placeholder="Enter Email" name="email" id="email" required>
                    <lable class="spacing">Password</lable>
                    <input class="form-control spacing" type="password" placeholder="Enter Password" name="password" id="password" required>
                    <button class="btn btn-default spacing btn-lg" name="login_btn" id="login_btn" onclick="login()">
                      Login
                    </button>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
            <div class="col-md-12">
                <p>Copyright &copy; 2017, All Rights Reserved</p>
            </div>
          </div>
      </div>
    </footer>
</body>
</html>