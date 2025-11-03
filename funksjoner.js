<!DOCTYPE html>
<html>
<head>
<title>Er du sikker</title>
</head>
<body>
<button onclick="confirmAction()">Slett</button>

<script>
function confirmAction() {
let userResponse = confirm("Er du sikker?");
if (userResponse) {
alert("Action confirmed!");
} else {
alert("Action canceled!");
}
}
</script>
</body>
</html>