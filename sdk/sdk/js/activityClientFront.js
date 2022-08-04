function timedCount() {

	var tabla='usuarios';
	var xhttp;

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			postMessage(this.responseText);
		}
	};

	xhttp.open("GET", "../includes/acciones.php?timeReport="+tabla, true);
	xhttp.send();

	setTimeout("timedCount()", 10000);
}

timedCount();

