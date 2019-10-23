function calc() {
	$('#tab_logic tbody tr').each(function (i, element) {
		var html = $(this).html();
		if (html != '') {

			var qty = $(this).find('.qty').val();
			var price = parseFloat($(this).find('.price').val());
			var tara = parseFloat($(this).find('.tara').val());
			var buhlo = tara + price;

			parseFloat($(this).find('.total').val((qty * buhlo).toFixed(2)));

			calc_total();
		}

	});
}

function calc_total() {
	total = 0;

	$('.total').each(function () {
		total += parseFloat($(this).val());
		console.log(total);
	});

	$('#sub_total').val(total.toFixed(2));

}

/////////////////////////////////////////////////

// chrome.runtime.onInstalled.addListener(function () {
// 	chrome.serial.connect("COM1", { bitrate: 9600 }, onConnect);


// });

// var con;


// var onConnect = function (connectionInfo) {
// 	// The serial port has been opened. Save its id to use later.
// 	con = connectionInfo.connectionId;
// 	// Do whatever you need to do with the opened port.
// 	console.log(con);
// 	// var x = writeSerial('Alkotrend forever!\n');
// 	// chrome.serial.flush(connectionId, onFlush);
// 	// chrome.serial.disconnect(connectionId, onDisconnect);
// }


// var writeSerial = function (str) {
// 	chrome.serial.send(con, convertStringToArrayBuffer(str), onSend);
// }
// // Convert string to ArrayBuffer
// var convertStringToArrayBuffer = function (str) {
// 	var buf = new ArrayBuffer(str.length);
// 	var bufView = new Uint8Array(buf);
// 	for (var i = 0; i < str.length; i++) {
// 		bufView[i] = str.charCodeAt(i);
// 	}
// 	// console.log(buf);
// 	return buf;
// }

// var onSend = function () {
// 	console.log("Otpravil");
// }
// var onFlush = function () {
// 	console.log("Flush All!");
// }


// var onDisconnect = function (result) {
// 	if (result) {
// 		console.log("Disconnected from the serial port");
// 	} else {
// 		console.log("Disconnect failed");
// 	}
// }

// // chrome.app.runtime.onLaunched.addListener(function () {


// // 	var x = writeSerial('Alkotrend forever!\n');

// // 	chrome.serial.flush(con, onFlush);

// // });





// function appcom() {

	
// 	var x = writeSerial('Alkotrend forever!\n');

// 	chrome.serial.flush(con, onFlush);



// }

//   // var onGsetDevices = function(ports) {
//   //   for (var i=0; i<ports.length; i++) {
//   //     console.log(ports[i].path);
//   //   }
//   // }
//   // chrome.serial.getDevices(onGetDevices);
