<?php
        $con=mysql_connect("localhost:3306","root","") or die ('Not connected:'.mysql_error());
        mysql_select_db('php_assignment',$con);
        $course_info=mysql_query("SELECT * FROM class");
        while($row=mysql_fetch_array($course_info)) $Data[]=$row;
        mysql_close($con);

        $course_name=$_GET["course"];
        if(strlen($course_name)>0)
        {
                $times=array();
                foreach($Data as $record)
                {
                        if($record['course']==$course_name)
                                $times[]=$record['time'];
                }
                $response="";
                foreach($times as $one_time)
                {
                        $response.="<option value=\"".$one_time."\">".$one_time."</option>";
                }
                echo $response;
        }

?>


