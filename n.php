<?php
$year = $_POST['year'];
$month = $_POST['month'];
$file =$year.'/'.$month.'.csv';

 $name = $_POST["customerName"]; 

 if ( preg_match( '/\d{9}/', $name ) === 0) {
    echo '<h1/>الرقم الوظيفي خطأ يرجى التأكد'; 
} 

else {
	echo ' 
	<head>
 <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3047591855739610"
     crossorigin="anonymous"></script>
 
 </head> 
	';
$output = "";
$row = 0;
if (($handle = fopen($file, "r")) !== FALSE) {
   
    echo '<table border="1">';
   
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);
        if ($row == 0) {
            echo '<thead><tr>';
        }else{
            echo '<tr>';
        }
       
	   	   $txt = fgets($handle);

	   while ( !feof( $handle) ) {
	   
	   // Search for keyword
      if ( stripos( $txt, $name ) !== false ) {
      $output = $txt;
      }

      $txt = fgets($handle);
	   
	   }
	   
	   	   
        for ($c=0; $c < $num; $c++) {
            //echo $data[$c] . "<br />\n";
            if(empty($data[$c])) {
               $value = "&nbsp;";
			   $output ="&nbsp;";
            }else{
               $value = $data[$c];
			   
            }
            if ($row == 0) {
echo '<html dir="rtl">' ;
                echo '<th>'.$value.'</th>';
				
							
            }else{
                echo '<td>'.$value.'</td>';
								//echo '<th>'.$output.'</th>';

            }
        }
		$cells = explode(";",$output);
        echo "<tr>";
        foreach ($cells as $cell) {
            echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>\n";
       
        if ($row == 1) {
            echo '</tr></thead><tbody>';
        }else{
            echo '</tr>';
        }
        $row++;
    }
   
    echo '</tbody></table>';
    fclose($handle);
}
}
?>