<?php
	$xml = simplexml_load_file("oldal.xml");
	
	function fvg($xml_, $keres){
		foreach($xml_ as $web){
			$keresett = $web->xpath($keres);
		}
	}

	fvg($xml, "rendszam");
	
	$i=0;
	foreach($xml as $web){
		if($web["nev"] == "title"){
			$title = $xml->tulajdonsag[$i]->ertek;
		}else if($web["nev"] == "menu"){
			$menuk = $xml->tulajdonsag[$i]->mp;
			foreach($web as $mp){
				$menu_links[] = $mp->attributes();
			}
		}else if($web["nev"] == "body"){
			$body_tartalom = "";
			$bgcolor = $xml->tulajdonsag[$i]->bgcolor;
			foreach($web->tartalom[0] as $tartalom){
				$attr_num = count($tartalom->attributes());
				foreach($tartalom->attributes() as $attr_key => $attr_value){
					if($attr_key == "type"){
						if(strpos($attr_value, "/") !== false){
							$body_tartalom .= "<".$attr_value.">";
						}else{
							$body_tartalom .= "<".$attr_value." ";
						}
					}else{
						if($attr_num > 2){
							$body_tartalom .= $attr_key."='".$attr_value."' ";
							$attr_num--;
						}else{
							$body_tartalom .= $attr_key."='".$attr_value."'>".$tartalom;
						}
					}
				}
			}
		}
		
		$i++;
	}
?>
<html>
	<head>
		<title><?php echo $title; ?></title>	
	</head>
	<body bgcolor="<?php echo $bgcolor; ?>">
		<?php 
		for($i=0;$i<count($menuk);$i++){
			echo $menuk[$i]." ";
		}
		?>
		<br>
		<?php 
		for($i=0;$i<count($menuk);$i++){
			echo $menu_links[$i]." ";
		}
		?>
		<br>
		<?php
		print($body_tartalom);
		?>
	</body>
</html>