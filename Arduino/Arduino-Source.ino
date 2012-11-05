String cmd;
bool cmdRec = false;
void setup()
{
	//Start the connection with the Raspberry Pi
	Serial1.begin(115200);
	// Start the connection with the Laptop, for debugging only!
	//Serial.begin(115200);
}

void loop()
{
	handleCmd();
}

void serialEvent1() {
	while(Serial1.available() > 0) {
		char inByte = (char)Serial1.read();
		if(inByte == ':') {
			cmdRec = true;
			return;
		} else if(inByte == '@') {
			cmd = "";
			cmdRec = false;
			return;
		} else {
			cmd += inByte;
			return;
		}
	}
}

void handleCmd() {
	if(!cmdRec) return;
	
	// If you have problems try changing this value, 
	// my MEGA2560 has a lot of space
	int data[80];
	int numArgs = 0;

	int beginIdx = 0;
	int idx = cmd.indexOf(",");

	String arg;
	char charBuffer[20];


	while (idx != -1) {
		arg = cmd.substring(beginIdx, idx);
		arg.toCharArray(charBuffer, 16);

		data[numArgs++] = atoi(charBuffer);
		beginIdx = idx + 1;
		idx = cmd.indexOf(",", beginIdx);
	}
	// And also fetch the last command
	arg = cmd.substring(beginIdx);
	arg.toCharArray(charBuffer, 16);
	data[numArgs++] = atoi(charBuffer);
	// Now execute the command
	execCmd(data);

	cmdRec = false;
}

// For advanced function like switch all the leds in RGB
void execCmd(int* data) {
	switch(data[0]) {
	case 101:
		{
			for(int i = 2; i < (data[1]*2)+1; i+=2) {
				pinMode(data[i], OUTPUT);
				analogWrite(data[i], data[i+1]);
			}
		}
		break;

	case 102:
		{
			pinMode(data[1], INPUT);
			int sensor = analogRead(data[1]);
			Serial1.println(sensor);
		}
		break;

	case 103:
		{
			String result = "";
			int sensor = 0;
			for(int j = 2; j < data[1]+2; j++) {
				pinMode(data[j], INPUT);
				sensor = analogRead(data[j]);
				result += String(sensor)+",";
			}
			Serial1.println(result);
		}
		break;
	default:
		{
			pinMode(data[0], OUTPUT);
			analogWrite(data[0], data[1]);
		}
		break;
	}
}