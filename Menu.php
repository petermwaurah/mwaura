<?php
    
	function loop_array($array = array(), $parent_id = 0){
		
		if(!empty($array[$parent_id])) {
			
			echo '<ul class="cssmenu" style="color:#FFF">';
			foreach($array[$parent_id] as $items){
			echo '<li>'	;
			echo $items['name'];
			loop_array($array, $items['id']);
			echo '<li>';	
			}
			echo '</ul>';
			
			}
		
		}
		
		function display_menus()
		{
			
			
			$con = mysqli_connect("localhost", "root", "", "user_id");
			$query = $con->query("SELECT * FROM menu");
			$array = array();
			
			if(mysqli_num_rows($query)){
				
				while($rows = mysqli_fetch_array($query)){
					
					$array[$rows['parent_id']][] = $rows;
					
					}
				    loop_array($array);
				
				}
		}
?>