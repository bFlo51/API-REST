<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="shortcut icon" href="../resources/img/dofus.jpg" TYPE="image/x-icon" />

		<title>Api - Jeu</title>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	</head>

	<body onload="loadTab()">
		<table class="table table-dark">  
			<thead>
    			<tr>
			      <th scope="col">#</th>
			      <th scope="col">nom</th>
			      <th scope="col">classe</th>
			      <th scope="col">niveau</th>
    			</tr>
    		</thead>
    		<tbody class= "list">
    		<tbody>
		</table>
	</body>
</html>
<script>
	function loadTab(){
		// Ici, la requête sera émise de façon synchrone.
		const req = new XMLHttpRequest();
		req.open('GET', 'http://localhost:8100/php/index.php/personnages', false); 
		req.send(null);

		if (req.status === 200) {
		    console.log("Réponse reçue: %s", req.responseText);
		} else {
		    console.log("Status de la réponse: %d (%s)", req.status, req.statusText);
		}
		var data =req.responseText;
		var res = JSON.parse(data);
		console.log(res);

		var stringData = "";

		for (var i = 0; i < Object.keys(res).length-1 ; i++) {
		  console.log(i);
		  stringData += "<tr><td>"  + res.result[i]["id"] + "</td><td>" + res.result[i]["nom"] + "</td><td>" + res.result[i]["classe"] + "</td><td>"+ res.result[i]["niveau"] + "</td></tr>";
		}
		console.log(stringData);
		$(".list").append(stringData);

	}
</script>