#include <GY521.h>
#include <MKRWAN.h>


/* https://github.com/arduino-libraries/MKRWAN */
LoRaModem modem;
// TheThingsNetwork app credentials.
String appEui = "";	// Put your appEui
String appKey = "";	// Put you appKey

/* https://github.com/RobTillaart/GY521 */
// AD0 connected to GND => 0x68, AD0 connected to VCC => 0x69.
GY521 sensor(0x68);
// Sensitivity Acceleration. 0,1,2,3 ==> 2g 4g 8g 16g.
#define AS 0
// Sensitivity Gyroscope- 0,1,2,3 ==> 250, 500, 1000, 2000 degrees/second.
#define GS 0

// Sensor ID and location.
#define ID 1
#define LOC 1

// Variables to store the data and message to be sent.
float ax, ay, az;
float gx, gy, gz;
float temp;
byte msg[29];

// Time in milliseconds between each message sent.
#define msg_time 20000



void setup() {
  Serial.begin(115200);

  // Wait to allow Serial to start
  delay(2000);

  Serial.println( "** Iniciando sensor " + (String)ID + " de la ubicación " + (String)LOC + "... **");

  if (!modem.begin(EU868)) {
    Serial.println("Error al iniciar el módulo LoRa. Por favor, reinicie.");
    exit(1);
  }

  // The Things Network connection.
  uint8_t connected = modem.joinOTAA(appEui, appKey);

  while(!connected) {
    Serial.println("Error al conectarse a la aplicación The Things Network mediante LoRa. Reintentando conexión...");
    
    connected = modem.joinOTAA(appEui, appKey);
  }

  Wire.begin();

  while (sensor.wakeup() == false)
  {
    Serial.println("Error al contactar con el sensor GY521");
    delay(1000);
  }

  sensor.setAccelSensitivity(AS);
  sensor.setGyroSensitivity(GS);
  // Throttle to force delay between reads.
  sensor.setThrottle();

  // Set all calibration errors to zero
  sensor.axe = 0;
  sensor.aye = 0;
  sensor.aze = 0;
  sensor.gxe = 0;
  sensor.gye = 0;
  sensor.gze = 0;
}


void loop() {
  ax = ay = az = 0;
  gx = gy = gz = 0;
  temp = 0;

  // Get mean values
  for (int i = 0; i < 20; i++)
  {
    sensor.read();
    ax -= sensor.getAccelX();
    ay -= sensor.getAccelY();
    az -= sensor.getAccelZ();
    gx -= sensor.getGyroX();
    gy -= sensor.getGyroY();
    gz -= sensor.getGyroZ();
    temp += sensor.getTemperature();
  }

  ax *= 0.05;
  ay *= 0.05;
  az *= 0.05;
  gx *= 0.05;
  gy *= 0.05;
  gz *= 0.05;
  temp *= 0.05;

  // Print mean values
  Serial.println("\nACCELEROMETER\t\tGYROSCOPE\t\tTEMPERATURE");
  Serial.println("ax\tay\taz\tgx\tgy\tgz\tT");
  Serial.print(ax);
  Serial.print('\t');
  Serial.print(ay);
  Serial.print('\t');
  Serial.print(az);
  Serial.print('\t');
  Serial.print(gx);
  Serial.print('\t');
  Serial.print(gy);
  Serial.print('\t');
  Serial.print(gz);
  Serial.print('\t');
  Serial.println(temp);

  // Adjust calibration errors so table should get all zero's.
  sensor.axe += ax;
  sensor.aye += ay;
  sensor.aze += az;
  sensor.gxe += gx;
  sensor.gye += gy;
  sensor.gze += gz;

  fill_msg( msg, ax, ay, az, gx, gy, gz, temp, ID, LOC );

  send_msg( msg );

  delay(msg_time);
}
