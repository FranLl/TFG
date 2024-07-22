// Main function that preprocesses the data before sending them
function Decoder(bytes, port) {  
  var data = {
  	'ax': (bytes [0] << 24 | bytes [1] <<16 | bytes[2] << 8 | bytes[3]),
  	'ay': (bytes [4] << 24 | bytes [5] <<16 | bytes[6] << 8 | bytes[7]),
  	'az': (bytes [8] << 24 | bytes [9] <<16 | bytes[10] << 8 | bytes[11]),
  	'gx': (bytes [12] << 24 | bytes [13] <<16 | bytes[14] << 8 | bytes[15]),
  	'gy': (bytes [16] << 24 | bytes [17] <<16 | bytes[18] << 8 | bytes[19]),
  	'gz': (bytes [20] << 24 | bytes [21] <<16 | bytes[22] << 8 | bytes[23]),
  	'temp': (bytes [24] << 24 | bytes [25] <<16 | bytes[26] << 8 | bytes[27]),
  	'id': (bytes[28]),
  	'loc': (bytes[29])
  };
  
  return {
    'apikey': '',	// Put your apikey
    'data': data
  };
}
