
<?php

class ANSYS{

	function write_input($data, $uploaddir, $input){
        $doto = $data;
//		$doto = json_encode($data);

//        $input = "../SHARED/ansys/input.inp";

        file_put_contents( $uploaddir.$input, json_encode($data));

//		$ansys_input = fopen('input.inp', "w") or die("Unable to open file!");
//		$ansys_input = fopen($input, "w") or die("Unable to open file!");
//
//		for ($inode = 0; $inode < sizeof($doto['nodes']); $inode++) {
//			$txt = "N, ".$doto['nodes'][$inode]['no'].' ,'.$doto['nodes'][$inode]['x'].", ".$doto['nodes'][$inode]['y'].", ".$doto['nodes'][$inode]['z']. ";\n";
//			fwrite($ansys_input, $txt);
//		}
//
//		for ($imbr = 0; $imbr < sizeof($doto['members']); $imbr++) {
//
//		}
//		fclose($ansys_input);
	}

}

?>