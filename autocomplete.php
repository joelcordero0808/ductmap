<?php		
	$keyword = strval($_POST['query']);
	$search_param = "{$keyword}%";
	$conn =new mysqli('localhost', 'root', '' , 'passive2');

	$sql = $conn->prepare("SELECT id,manhole FROM tblobject WHERE manhole LIKE ?");
	$sql->bind_param("s",$search_param);			
	$sql->execute();
	$result = $sql->get_result();
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		$objres[] = $row["id"]." | ".$row["manhole"];
		}
		echo json_encode($objres);
	}
	$conn->close();
?>

