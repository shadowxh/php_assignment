<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
 		$name=test_input($_POST["name"]);
  		$phone=test_input($_POST["phone"]);
		$knowledge=test_input($_POST["knowledge"]);
		if(strlen($name)==0) {echo "name can't be empty";exit(0);}
		if(!(($name[0]>='a' && $name[0]<='z')||($name[0]>='A' && $name[0]<='Z'))) {echo "name should begin with a letter";exit(0);}
		for($i=1;$i<strlen($name);$i++)
		{
			if(!test_name($name[$i])) {echo "check your name";exit(0);}
			if(($name[$i]==$name[$i-1]) && (($name[$i]=='-') || ($name[$i]=="'"))) {echo "check your name";exit(0);}
		}
		$cnt=0;
		if(strlen($phone)==0) {echo "phone number shouldn't be empty";exit(0);}
		if($phone[0]!='0') {echo "phone number should begin with a '0'";exit(0);}
		for($i=0;$i<strlen($phone);$i++)
		{
			if(!test_phone($phone[$i])) {echo "unexpected input of phone number";exit(0);}
			if(($phone[$i]>='0') && ($phone[$i]<='9')) $cnt++;
		}
		if(($cnt!=9) && ($cnt!=10)) {echo "check the number of digits of the phone number";;exit(0);}
		$all_courses=get_course_info();
		foreach($all_courses as $record)
		{
			if(($record['course']==$_POST['course']) && ($record['time']==$_POST['time']))
			{
				if($record['capacity']==0) {echo "no empty place";exit(0);}
				update_cap($_POST['course'],$_POST['time'],$record['capacity']-1);
				add_member($_POST['course'],$_POST['time'],$name,$phone,$knowledge);
			}

		}
		Header("Location:main.php");
		
	}

	function test_phone($ch)
	{
		if(!(($ch>='0') && ($ch<='9')) && ($ch!=' ')) return 0;
		return 1;
	}
	function test_name($ch)
	{
		$is_letter=(($ch[0]>='a' && $ch[0]<='z')||($ch[0]>='A' && $ch[0]<='Z'));
		if(!$is_letter && ($ch!='-') && ($ch!='\'') && ($ch!=' ')) return 0;
		return 1;
	}
	function test_input($data) {
  		$data = stripslashes($data);
		$data = htmlspecialchars($data);
  		return $data;
	}

	function add_member($course_name,$course_time,$name,$phone,$knowledge)
	{
                $con=mysql_connect("localhost:3306","root","") or die ('Not connected:'.mysql_error());
                mysql_select_db('php_assignment',$con);
                $sql = "insert into member(course,time,name,phone,knowledge) value('".$course_name."','".$course_time."','".$name."','".$phone."','".$knowledge."')";
                mysql_query($sql,$con);
		mysql_close($con);
        }
	

	function update_cap($course_name,$course_time,$cap)
	{
		$con=mysql_connect("localhost:3306","root","") or die ('Not connected:'.mysql_error());
                mysql_select_db('php_assignment',$con);
		$sql = "update class set capacity=".$cap." where course='".$course_name."' and time='".$course_time."'";
		mysql_query($sql,$con);
		mysql_close($con);
	}


	function get_course_info()
	{
        	$con=mysql_connect("localhost:3306","root","") or die ('Not connected:'.mysql_error());
        	mysql_select_db('php_assignment',$con);
        	$course_info=mysql_query("SELECT * FROM class");
        	while($row=mysql_fetch_array($course_info)) $Data[]=$row;
        	mysql_close($con);
		return $Data;
	}
?>
