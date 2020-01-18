<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Nicht Lachen! | Willkommen</title>

    <style media="screen">
    .button {
display: inline-block;
padding: .75rem 1.25rem;
border-radius: 10rem;
color: white;
text-transform: uppercase;
font-size: 1rem;
letter-spacing: .15rem;
transition: all .3s;
position: relative;
overflow: hidden;
z-index: 1;
}
.button:after {
content: '';
position: absolute;
bottom: 0;
left: 0;
width: 100%;
height: 100%;
background-color: #ff8000;
border-radius: 10rem;
z-index: -2;
}
.button:before {
content: '';
position: absolute;
bottom: 0;
left: 0;
width: 0%;
height: 100%;
background-color: white;
transition: all .3s;
border-radius: 10rem;
z-index: -1;
}
.button:hover {
color: #ff8000;
}
.button:hover:before {
width: 100%;
}

/* optional reset for presentation */
* {
font-family: Arial;
text-decoration: none;
font-size: 20px;
}

.container {
padding-top: 50px;
margin: 0 auto;
width: 100%;
text-align: center;
}

h1 {
text-transform: uppercase;
font-size: .8rem;
margin-bottom: 2rem;
color: #777;
}

span {
display: block;
margin-top: 2rem;
font-size: .7rem;
color: #777;
}
span a {
font-size: .7rem;
color: #999;
text-decoration: underline;
}

    </style>

  </head>
  <body style="background-color: yellow">
    <h1 style="font-family: Arial; background-color: orange; color: white"><center><br>Willkommen bei Nicht Lachen 2.0!<br><br></center></h1>
    <center>
    <table style="font-family: Arial; background-color: orange; color: white">
      <tr>
        <td style="font-size: x-large; text-align: center">Melden Sie sich an:<br>
          <div class="container">
            <a href="login.php" class="button">Anmelden</a>
          </div>
          <br>
        </td>
      </tr>
      <tr>
        <td style="font-size: x-large; text-align: center">Oder registrieren Sie sich:<br>
          <div class="container">
            <a href="register.php" class="button">Registrieren</a>
          </div>
          <br>
        </td>
      </tr>
    </table>
  </center>
    <footer style="font-family: Arial; color: white">
	     <div style="position: fixed; right: 0px; bottom: 0px; width: 100%; background-color: #ff8000; text-align: right"><p>© 2020 by Der_Schnuzbart&nbsp&nbsp</p></div>
    </footer>
  </body>
</html>
