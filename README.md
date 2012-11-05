# ArduinoPi Controller
The ArduinoPi controller is a web-based solution to control your Arduino using a RaspberryPi.
The controller uses AJAX and PHP, this github demonstrates some of the possibilities. The communication between
the RaspberryPi and the Arduino is possible thanks to the [php_serial.class.php](http://code.google.com/p/php-serial/).

I also want to thank the following authors/scripts/plugins for making my coding easier:
* [Twitter bootstrap](http://twitter.github.com/bootstrap/)
* [flot](http://code.google.com/p/flot/)
* [jQuery](http://jquery.com/)
* [Farbtastic Color Picker](http://acko.net/blog/farbtastic-jquery-color-picker-plug-in/)
* [Combining jQuery UI and Farbtastic](http://www.emanueleferonato.com/2011/03/22/jquery-color-picker-using-farbtastic-and-jquery-ui/)

Warning: Before checking out the repo, please make sure you have a basic understanding of HTML, CSS, PHP and jQuery (and C++)

# Changed
v1.6:Analog ports are now called using 0-15 (for arduino mega), adding the A for analog will not work anymore and should be avoided
Also changed some bugs in the Arduino Code.
v1.5:From this version on, I've changed the way analog ports can be used as digital ports. If you want to use a analog port as
a digital port then include the real value of the analog port. For example on my Arduino MEga 2560 I have 52 digital ports,
port 53 is my A0 port and so on.

##More Information & Options
Check my blog for more information how to use the API: [blog](http://www.fritz-hut.com/all-projects/arduinopi/)       
More information on how to connect the Raspberry Pi with the Arduino and how everything works can be found on my blog:
[fritz-hut](http://fritz-hut.com).         
Code is free for all to be used, copied, changed, edited and deleted. I only ask a simpel link to my blog if you use my code :)