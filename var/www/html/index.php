<?php

$color = "000000";
exec("sudo pigpiod");

//code for "Set color" button
if (isset($_POST['colorpicker']))
{
        //takes the hex color input selected by the user and executes the python script for the ledstrip
        $color = $_POST['colorpicker'];
        $color = ltrim($color, '#');
        echo "<b>Ledstrip Color:</b> " . $color . "<br /><br />";
        //executes the python script that lights the LED strip
        exec("sudo python /var/www/culori.py $color");
        //reads the output from the sensor
        $read = exec("sudo python /var/www/sensor.py");
        echo "<b>Light output from sensor:</b> " . $read;
}

//executes the script "culori.py" and reads its output (meaning the output from our sensor - light or dark)
if (isset($_GET['getValue']))
{
        $OUTPUT = 1;
        exec("sudo python /var/www/sensor.py", $OUTPUT);
        print_r($OUTPUT[count($OUTPUT)-1]);
        die();
}

//code for "LED strip Off" button
if (isset($_POST['ledOff']))
{
        //executes the python script for closing the LED strip
        exec("sudo python /var/www/culori.py 000000");
}
?>

<html>
<head>
  <title>LED Strip Project </title>
</head>

<body style="background-color: #ddd1f8">
<br /><br />
<center>
<h1> <font color='black'>LED Strip Project</font></h1>
<br />

<form method="post">
  <table style="width: 50%; text-align: left; margin-left: auto; margin-right: auto; border=1; cellpadding=2; cellspacing=2;">
        <tr>
                <input type="color" name="colorpicker">
                <button id="set_color">Set Color</button>
        </tr>
        <tr>
                <br /><br />
                <button type="submit" name="ledOff" id="ledOff">LED strip Off</button>
        </tr>
  </table>
</center>
</form>
        <script>
                //add an event listener for the "Set Color" button
                var colorPicker = document.getElementById("set_color");
                colorPicker.addEventListener("click", culoare);

                //callback function for when the "Set Color" button is clicked
                function culoare(e)
				        {
                        //stop the page from refreshing
                        e.preventDefault();

                        //send a GET request to "/?getValue"
                        var ajax1 = new XMLHttpRequest();
                        ajax1.open("GET", "/?getValue", true);

                        //when the response is ready, show a confirmation pop-up with data from the sensor (dark/light)
                        ajax1.onreadystatechange = function(){
                                if(ajax1.readyState == 4 && ajax1.status == 200){
                                        var popUp = confirm("It is " + ajax1.responseText + ". Are you sure you want to light the LED strip?");
                                        //if the user clicked "Yes" on the confirmation pop-up, send a POST request to the server, in order to light the LED strip with the selected color
                                        if (popUp)
                                        {
                                                var ajax = new XMLHttpRequest();
                                                ajax.open("POST", "/", true);
                                                ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                //send the value from the color picker
                                                ajax.send("colorpicker=" + encodeURIComponent(document.querySelector("input[type=color]").value));
                                        }

                                }
						            };
                        ajax1.send();

                }
        </script>
<footer style="position: fixed; bottom: 0; text-align: center; width: 100%;">
        &copy;Morosan Carla-Adriana &amp; Radion Claudia
        <br />
        1309A
        <br />
        Facultatea de Automatica si Calculatoare
</footer>

</body>
</html>


