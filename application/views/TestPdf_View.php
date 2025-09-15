<!DOCTYPE html>
<html>
<head>
	<title>API JS</title>
</head>
<body>
	<button onclick="testapi()">Test</button>
<script type="text/javascript">
	function testapi2() {
		// body...
		const headers = new Headers()
		headers.append("Content-Type", "application/json")

		const body = {
		  "username": "admin",
		  "password":"brisk"
		}

		const options = {
		  method: "POST",
		  headers,
		  mode: "cors",
		  body: JSON.stringify(body),
		}

fetch("http://154.117.208.115:1620/alfresco/s/api/login", options)


	}
	function testapi() {
		// body...
		const body = {
		  "username": "admin",
		  "password":"brisk"
		}		
		let xmlhttprequest= new XMLHttpRequest()
		xmlhttprequest.open("POST","http://154.117.208.115:1620/alfresco/s/api/login",true)
		xmlhttprequest.setRequestHeader("Content-type", "application/json");

		xmlhttprequest.send(body);
		xmlhttprequest.onload = () => alert(xmlhttprequest.response);



	}



</script>
</body>
</html>