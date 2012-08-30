# ArduinoPi Controller
The ArduinoPi controller is a web-based solution to control your Arduino using a RaspberryPi.
The controller uses AJAX and PHP, this github demonstrates some of the possibilities. The communication between
the RaspberryPi and the Arduino is possible thanks to the [php_serial.class.php](http://code.google.com/p/php-serial/).

I also want to thank the following authers/scripts/plugins for making my coding easier:
* [Twitter bootstrap](http://twitter.github.com/bootstrap/)
* [flot](http://code.google.com/p/flot/)
* [jQuery](http://jquery.com/)
* [Farbtastic Color Picker](http://acko.net/blog/farbtastic-jquery-color-picker-plug-in/)
* [Combining jQuery UI and Farbtastic](http://www.emanueleferonato.com/2011/03/22/jquery-color-picker-using-farbtastic-and-jquery-ui/)

Warning: Before checking out the repo, please make sure you have a basic understanding of HTML, CSS, PHP and jQuery (and C++)

## Basic Commands
A example of a command:
`@6,255:`

If we send this command, using the sendCommand function the Arduino will switch port 6 with a value of 255. The "@" marks the start of a command while ":" marks the end.
If the port value is between 0-99 then the Arduino will switch the port. Also note that only PWM ports can have different values between 0-255, digital ports only execute a 0 or 255.
Sending a value of 127 to a digital port will end in wierd results!

## Special commands
There are also a couple of special commands, but feel free to clone the repository and add your own (its really easy!)

###Sending an RGB color
Sending an RGB color to some RGB leds can be quite frustrating and slow if you have to send 3 basic commands.
`@101,0,126,23:`
The following command can also be send with the sendCommand function and will switch 3 PWM port to the corresponding value.
Any value above 100 tells the Arduino we are using a special command, in this example the following 3 values represent an RGB color an can be used to switch RGB LEDS or RGB led strips.

###Requesting sensor data
Sending the following code will request the an analogRead command on the desired pin.
`@102,6`
102 indicates an Analog reading and 6 indicates the pin to do the reading on.

##More Information
More information on how to connect the Raspberry Pi with the Arduino and how everything works can be found on my blog:
[fritz-hut](http://fritz-hut.com).
