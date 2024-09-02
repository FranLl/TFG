function Bytes2Float32(bytes) {
  // Get the sign
  var sign = (bytes & 0x80000000) ? -1 : 1;
  // Get the exponent
  var exponent = ((bytes >> 23) & 0xFF) - 127;
  // Get the significand or mantissa
  var significand = (bytes & ~(-1 << 23));

  if (exponent == 128)
    return sign * ((significand) ? Number.NaN : Number.POSITIVE_INFINITY);
  
  if (exponent == -127) {
    if (significand === 0) return sign * 0.0;
      exponent = -126;
      significand /= (1 << 22);
    }
    else
      significand = (significand | (1 << 23)) / (1 << 23);
      
    return sign * significand * Math.pow(2, exponent);
}


// Main function that preprocesses the data before sending them
function Decoder(bytes, port) {  
  var data = {
  	'ax': Bytes2Float32(bytes [0] << 24 | bytes [1] <<16 | bytes[2] << 8 | bytes[3]),
  	'ay': Bytes2Float32(bytes [4] << 24 | bytes [5] <<16 | bytes[6] << 8 | bytes[7]),
  	'az': Bytes2Float32(bytes [8] << 24 | bytes [9] <<16 | bytes[10] << 8 | bytes[11]),
  	'gx': Bytes2Float32(bytes [12] << 24 | bytes [13] <<16 | bytes[14] << 8 | bytes[15]),
  	'gy': Bytes2Float32(bytes [16] << 24 | bytes [17] <<16 | bytes[18] << 8 | bytes[19]),
  	'gz': Bytes2Float32(bytes [20] << 24 | bytes [21] <<16 | bytes[22] << 8 | bytes[23]),
  	'temp': Bytes2Float32(bytes [24] << 24 | bytes [25] <<16 | bytes[26] << 8 | bytes[27]),
  	'id': (bytes[28]),
  	'loc': (bytes[29])
  };
  
  return {
    'apikey': '',   // Put your apikey here
    'data': data
  };
}
