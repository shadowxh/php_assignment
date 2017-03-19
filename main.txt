<?php
        $con=mysql_connect("localhost:3306","root","") or die ('Not connected:'.mysql_error());
        mysql_select_db('php_assignment',$con);
        $course_info=mysql_query("SELECT * FROM class");
	while($row=mysql_fetch_array($course_info)) $Data[]=$row;
	mysql_close($con);
	$courses=array();
	foreach($Data as $record)
	{
		$courses[]=$record['course'];
	}
	$courses=array_unique($courses);
?>
<html>
	<body>
		<script>
			function change_time()
			{
				//alert("change_time");
				var xmlHttpReg = null;
          			if(window.ActiveXObject)
				{
					xmlHttpReg = new ActiveXObject("Microsoft.XMLHTTP");

          			}
				else if(window.XMLHttpRequest)
				{
					xmlHttpReg = new XMLHttpRequest();
          			}
          			if(xmlHttpReg != null)
				{
					var selected=document.getElementById("course_name");
					var index=selected.selectedIndex;
					var course_name=selected.options[index].value;
              				xmlHttpReg.open("get", "change_course.php?course="+course_name, true);
               				xmlHttpReg.send(null);
              				xmlHttpReg.onreadystatechange = doResult;
				}

				function doResult()
				{
          				if(xmlHttpReg.readyState==4)
					{
                 				if(xmlHttpReg.status==200)
						{
                      					document.getElementById("time").innerHTML=xmlHttpReg.responseText;
              					}
              				}

          			}			
			}
		</script>
		<form action="book.php" method="post">
			course_name:
				<select name="course" id='course_name' onchange="change_time()">
					<?php	
						foreach($courses as $key)
						{
							echo "<option value=\"".$key."\">".$key."</option>";
						}
					?>	
				</select>
			course_time:
				<select name="time" id='time'>
					<?php
						foreach($Data as $record)
						{
							if($record['course']!=$courses[0]) continue;
							echo "<option value=\"".$record['time']."\">".$record['time']."</option>";
						}
	
					?>
				</select>
			name: <input type="text" name="name" /><br />
			phone number: <input type="text" name="phone" /><br />
			previous knowledge:<input type="text" name="knowledge" /><br />
			<input type="submit" />
		</form>

	</body>
</html>
