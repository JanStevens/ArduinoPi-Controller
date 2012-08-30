int ledstate = LOW;
String cmd;
bool cmdRec = false;
void setup()
{
	//Start the connection with the Raspberry Pi
	Serial1.begin(115200);
	// Start the connection with the Laptop
	Serial.begin(115200);
	for(int i=2; i <= 10; i++) {
		pinMode(i, OUTPUT);
	}
}

void loop()
{
	handleCmd();
}

void serialEvent1() {
	while(Serial1.available() > 0 && Serial1.writeable()) {
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

	int data[4];
	int numArgs = 0;

	int beginIdx = 0;
	int idx = cmd.indexOf(",");

	String arg;
	char charBuffer[16];

	
	while (idx != -1) {
		arg = cmd.substring(beginIdx, idx);
		arg.toCharArray(charBuffer, 16);

		// add error handling for atoi:
		data[numArgs++] = atoi(charBuffer);
		beginIdx = idx + 1;
		idx = cmd.indexOf(",", beginIdx);
	}
	// And also fetch the last command
	arg = cmd.substring(beginIdx);
	arg.toCharArray(charBuffer, 16);
	data[numArgs++] = atoi(charBuffer);
	
	// We just want to switch a port so lets change the values
	if(data[0] < 100) {
		execCmd(data);
	} else {
		execCmds(data);
	}
	cmdRec = false;
}

// Select just one port and enable it
void execCmd(int* data) {
	analogWrite(data[0], data[1]);
}

// For advanced function like switch all the leds in RGB
void execCmds(int* data) {
	switch(data[0]) {
	case 101:
		// first the red part of the RGB
		// for me 4,7,10
		analogWrite(4, data[1]);
		analogWrite(7, data[1]);
		analogWrite(10, data[1]);
		// green: 3, 6, 9
		analogWrite(3, data[2]);
		analogWrite(6, data[2]);
		analogWrite(9, data[2]);
		// blue: 2, 5, 8
		analogWrite(2, data[3]);
		analogWrite(5, data[3]);
		analogWrite(8, data[3]);
		break;

	case 102:
		// request analog readout!
		int sensor = analogRead(data[1]);
		Serial1.println(sensor);
	}
}

