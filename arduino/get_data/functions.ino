union floatInt_t {
  float fval;
  byte bval[4];
};

floatInt_t f;


/*
  Fills the msg variable with the data obtenined from the sensor.
  Return: Nothing
*/
void fill_msg( byte msg[], float ax, float ay, float az, float gx, float gy, float gz, float temp, uint8_t id, uint8_t loc ) {
  f.fval = ax;
  msg[0] = f.bval[3];
  msg[1] = f.bval[2];
  msg[2] = f.bval[1];
  msg[3] = f.bval[0];

  f.fval = ay;
  msg[4] = f.bval[3];
  msg[5] = f.bval[2];
  msg[6] = f.bval[1];
  msg[7] = f.bval[0];

  f.fval = az;
  msg[8] = f.bval[3];
  msg[9] = f.bval[2];
  msg[10] = f.bval[1];
  msg[11] = f.bval[0];

  f.fval = gx;
  msg[12] = f.bval[3];
  msg[13] = f.bval[2];
  msg[14] = f.bval[1];
  msg[15] = f.bval[0];

  f.fval = gy;
  msg[16] = f.bval[3];
  msg[17] = f.bval[2];
  msg[18] = f.bval[1];
  msg[19] = f.bval[0];

  f.fval = gz;
  msg[20] = f.bval[3];
  msg[21] = f.bval[2];
  msg[22] = f.bval[1];
  msg[23] = f.bval[0];

  f.fval = temp;
  msg[24] = f.bval[3];
  msg[25] = f.bval[2];
  msg[26] = f.bval[1];
  msg[27] = f.bval[0];

  msg[28] = id;
  msg[29] = loc;
}

/*
  Send the msg to the server using LoRa and LoRaWAN.
*/
void send_msg( byte msg[] ) {
  /* https://github.com/arduino-libraries/MKRWAN */
  modem.beginPacket();

  modem.write(msg, sizeof(msg));

  modem.endPacket();

  Serial.println("\nDatos enviados.\n");
}