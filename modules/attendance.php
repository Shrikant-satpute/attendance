<?php
include 'config1.php';
$updateFlag = 0;
$ap = "asdf";

//$from="";
?>
<!-- Attendence Tab -->
<div class="container">
	<div class="row ">
		<div class="col-md-12 col-lg-12">
			<h1 class="page-header">Take Attendance</h1>

		</div>
	</div>
	<!-- Subjects Selection -->
	<div class="row text-center">
		<div class="col-md-12 col-lg-12">
			<form action="index.php" method="get" class="form-inline" id="subjectForm" data-toggle="validator">
				<div class="form-group">
					<label for="select" class="control-label">Subject:</label>
					<?php

					$query_subject = "SELECT subject.sname, subject.id from subject INNER JOIN user_subject WHERE user_subject.id = subject.id AND user_subject.uid = {$_SESSION['uid']}  ORDER BY subject.sname";
					$sub = $conn->query($query_subject);
					$rsub = $sub->fetchAll(PDO::FETCH_ASSOC);
					echo "<select name='subject' class='form-control' required='required'>";
					for ($i = 0; $i < count($rsub); $i++) {
						if ($_GET['subject'] == $rsub[$i]['id']) {
							echo "<option value='" . $rsub[$i]['id'] . "' selected='selected'>" . $rsub[$i]['sname'] . "</option>";
						} else {
							echo "<option value='" . $rsub[$i]['id'] . "'>" . $rsub[$i]['sname'] . "</option>";
						}
					}
					echo "</select>";
					?>
				</div>
				<!-- Select Class Type -->
				<div class="form-group">
					<label for="select" class="control-label">Select type:</label>
					<select class="form-control" name='ltype' required='required'>
						<option>Theory</option>
						<option>Practical</option>


					</select>
				</div>
				<!-- Division Selction -->
				<div class="form-group">
					<label for="select" class="control-label">Div:</label>
					<?php

					$query_div = "SELECT div_name.divnm, div_name.did from div_name INNER JOIN div_user WHERE div_user.did = div_name.did AND div_user.uid = {$_SESSION['uid']}  ORDER BY div_name.divnm";
					$sub = $conn->query($query_div);
					$rsub = $sub->fetchAll(PDO::FETCH_ASSOC);
					echo "<select name='div_name' class='form-control' required='required'>";
					for ($i = 0; $i < count($rsub); $i++) {
						if ($_GET['div_name'] == $rsub[$i]['did']) {
							echo "<option value='" . $rsub[$i]['did'] . "' selected='selected'>" . $rsub[$i]['divnm'] . "</option>";
						} else {
							echo "<option value='" . $rsub[$i]['did'] . "'>" . $rsub[$i]['divnm'] . "</option>";
						}
					}
					echo "</select>";
					?>
				</div>
				<!-- Time Slot Selection -->
				<div class="form-group">
					<label for="select" class="control-label">Time:</label>
					<label for="select" class="control-label">From:</label>
					<?php

					$query_div = "SELECT time.tid,time.t_from from time INNER JOIN user_time WHERE user_time.tid = time.tid AND user_time.uid = {$_SESSION['uid']}";
					$sub = $conn->query($query_div);
					$rsub = $sub->fetchAll(PDO::FETCH_ASSOC);
					echo "<select name='t_from' class='form-control' required='required'>";
					for ($i = 0; $i < count($rsub); $i++) {

						echo "<option value='" . $rsub[$i]['t_from'] . "'>" . $rsub[$i]['t_from'] . "</option>";
					}
					echo "</select>";
					?>
					<label for="select" class="control-label">To:</label>
					<?php

					$query_div = "SELECT time.tid,time.t_to from time INNER JOIN user_time WHERE user_time.tid = time.tid AND user_time.uid = {$_SESSION['uid']}";
					$sub = $conn->query($query_div);
					$rsub = $sub->fetchAll(PDO::FETCH_ASSOC);
					echo "<select name='t_to' class='form-control' required='required'>";
					for ($i = 0; $i < count($rsub); $i++) {

						echo "<option value='" . $rsub[$i]['t_to'] . "'>" . $rsub[$i]['t_to'] . "</option>";
					}
					echo "</select>";
					?>

				</div>

				<!-- Date Slection -->

				<div class="form-group" data-provide="datepicker">
					<label for="select" class="control-label">Date:</label>
					<input type="date" class="form-control" name="date" value="<?php print isset($_GET['date']) ? $_GET['date'] : ''; ?>" required>
				</div>

				<button type="submit" class="btn btn-danger" style='border-radius:0%;' name="sbt_stn"><i class="glyphicon glyphicon-filter"></i> Load</button>
			</form>



			<?php
			if (isset($_GET['date']) && isset($_GET['subject']) && isset($_GET['div_name']) && isset($_GET['t_from']) && isset($_GET['t_to'])) :
			?>

				<?php
				$todayTime = time();
				$submittedDate = strtotime($_GET['date']);
				if ($submittedDate <= $todayTime) :
				?>
					<form action="index.php" method="post">
						<!-- Save Attendence -->
						<div class="margin-top-bottom-medium">
							<button type="submit" class="btn btn-success btn-block" style='border-radius:0%;' name="sbt_top"><i class="glyphicon glyphicon-ok-sign"></i> Save Attendance</button>
						</div>

						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th class="text-center">Roll</th>
									<th class="text-center">Student's Name</th>
									<th class="text-center"><input type="checkbox" class="chk-head" /> All Absent</th>
								</tr>
							</thead>

							<?php
							$dat = $_GET['date'];
							$ddate = strtotime($dat);
							$sub = $_GET['subject'];
							$divz = $_GET['div_name'];
							$ltype = $_GET['ltype'];
							$from = $_GET['t_from'];
							$to = $_GET['t_to'];
							$que = "SELECT * from attendance  WHERE date  =$ddate AND id=$sub AND did=$divz ORDER BY sid";
							$ret = $conn->query($que);
							$attData = $ret->fetchAll(PDO::FETCH_ASSOC);
							//
							// $qu = "SELECT attendance.id,student.name,student.pno FROM student inner join attendance where attendance.sid=student.sid && isabsent=1";
							

							// $sub = $rstu[$i]['subject'];




							// $que2 = "SELECT subject.sname, subject.id from subject INNER JOIN user_subject WHERE user_subject.id = subject.id AND user_subject.uid = {$_SESSION['uid']}  ORDER BY subject.name";
							// $ret1 = $conn->query($que);
							// $attData1 = $ret->fetchAll(PDO::FETCH_ASSOC);
							// for ($i = 0; $i < count($attData1); $i++) {
							// 	echo "$attData1[$i]['sname']";
							// }
							// $ret1=$conn->query($que2);
							// $attData1=$ret1->fetchAll(PDO::FETCH_ASSOC);
							// $demo=arraytostring($attData1);
							// echo "$demo";
							//	echo "$op";
							//  echo "$op";
							//  	echo " ";
							//     echo "$from";
							//     echo " ";
							//     echo "$to";
							//     echo " ";
							//     echo "$dat";
							//    $message2= "hii";


							if (count($attData)) {
								$updateFlag = 1;
							} else {
								$updateFlag = 0;
							}
							//	$qu = "SELECT student.sid, student.name, student.rollno from student INNER JOIN student_subject WHERE student.sid = student_subject.sid AND student_subject.id  = {$_GET['subject']}  ORDER BY student.sid";
							$qu = "SELECT student.sid, student.name, student.rollno from student INNER JOIN student_div WHERE student.sid = student_div.sid AND student_div.did  = {$_GET['div_name']}  ORDER BY student.sid";
							// $qu = "SELECT * FROM student INNER JOIN student_div ON student.sid = student_div.sid INNER JOIN user_time ON user.uid=user_time.uid where student_div.did  = {$_GET['div_name']}  ORDER BY student.sid";
							$stu = $conn->query($qu);
							$rstu = $stu->fetchAll(PDO::FETCH_ASSOC);


							echo "<tbody>";
							for ($i = 0; $i < count($rstu); $i++) {
								echo "<tr>";

								if ($updateFlag) {
									echo "<td>" . $rstu[$i]['rollno'] . "<input type='hidden' name='st_sid[]' value='" . $rstu[$i]['sid'] . "'>" . "<input type='hidden' name='att_id[]' value='" . $attData[$i]['aid'] . "'>" .  "</td>";
									echo "<td>" . $rstu[$i]['name'] . "</td>";


									if (($rstu[$i]['sid'] ==  $attData[$i]['sid']) && ($attData[$i]['isabsent'])) {

										echo "<td><input class='chk-present' checked type='checkbox' name='chbox[]' value='" . $rstu[$i]['sid'] . "'></td>";
									} else {
										echo "<td><input class='chk-present' type='checkbox' name='chbox[]' value='" . $rstu[$i]['sid'] . "'></td>";
									}
								} else {
									echo "<td>" . $rstu[$i]['rollno'] . "<input type='hidden' name='st_sid[]' value='" . $rstu[$i]['sid'] . "'></td>";
									echo "<td>" . $rstu[$i]['name'] . "</td>";
									echo "<td><input class='chk-present' type='checkbox' name='chbox[]' value='" . $rstu[$i]['sid'] . "'></td>";
								}


								echo "</tr>";
							}
							echo "</tbody>";

							?>
						</table>

						<?php if ($updateFlag) : ?>
							<input type="hidden" name="updateData" value="1">
						<?php else : ?>
							<input type="hidden" name="updateData" value="0">
						<?php endif; ?>

						<input type="hidden" name="date" value="<?php print isset($_GET['date']) ? $_GET['date'] : ''; ?>">
						<input type="hidden" name="subject" value="<?php print isset($_GET['subject']) ? $_GET['subject'] : ''; ?>">
						<input type="hidden" name="div_name" value="<?php print isset($_GET['div_name']) ? $_GET['div_name'] : ''; ?>">
						<input type="hidden" name="t_from" value="<?php print isset($_GET['t_from']) ? $_GET['t_from'] : ''; ?>">
						<input type="hidden" name="t_to" value="<?php print isset($_GET['t_to']) ? $_GET['t_to'] : ''; ?>">
						<input type="hidden" name="ltype" value="<?php print isset($_GET['ltype']) ? $_GET['ltype'] : ''; ?>">
						<button type="submit" class="btn btn-success btn-block" style='border-radius:0%;' name="sbt_top"><i class="glyphicon glyphicon-ok-sign"></i> Save Attendance</button>


					</form>

				<?php
				else :
				?>

					<p>&nbsp;</p>
					<div3 class="alert alert-dismissible alert-danger">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>Sorry!</strong> Attendance cannot be recorded for future dates!.
		</div>

	<?php
				endif;
	?>

<?php endif; ?>

<?php

if (isset($_POST['sbt_top'])) {
	if (isset($_POST['updateData']) && ($_POST['updateData'] == 1)) {

		// prepare sql and bind parameters

		$id = $_POST['subject'];
		$uid = $_SESSION['uid'];
		$did = $_SESSION['did'];
		$t_from = $_SESSION['t_from'];
		$t_to = $_SESSION['t_to'];
		$ltype = $_SESSION['ltype'];
		$p = 0;
		$st_sid =  $_POST['st_sid'];
		$attt_aid =  $_POST['att_id'];
		$isabsent = array();

		if (isset($_POST['chbox'])) {
			$isabsent =  $_POST['chbox'];
		}

		for ($j = 0; $j < count($st_sid); $j++) {
			//echo "hii";
			// UPDATE `attendance` SET `isabsent` = '1' WHERE `attendance`.`aid` = 79;

			$stmtInsert = $conn->prepare("UPDATE attendance SET isabsent = :isMarked WHERE aid = :aid");
			$stmtInsert1 = $conn->prepare("UPDATE daily SET isabsent = :isMarked WHERE aid = :aid");

			if (count($isabsent)) {
				$p = (in_array($st_sid[$j], $isabsent)) ? 1 : 0;
			}

			$stmtInsert->bindParam(':isMarked', $p);
			$stmtInsert->bindParam(':aid', $attt_aid[$j]);
			$stmtInsert->execute();
			$stmtInsert1->bindParam(':isMarked', $p);
			$stmtInsert1->bindParam(':aid', $attt_aid[$j]);
			$stmtInsert1->execute();
			//echo "data upadted";
		}
		echo '<p>&nbsp;</p><div class="alert alert-dismissible alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Well done!</strong> Attendance Recorded Successfully!.
						</div>';
	} else {

		// prepare sql and bind parameters
		$date = $_POST['date'];
		$tstamp = strtotime($date);
		$id = $_POST['subject'];
		$uid = $_SESSION['uid'];
		$did = $_POST['div_name'];
		$t_from = $_POST['t_from'];
		$t_to = $_POST['t_to'];
		$ltype = $_POST['ltype'];
		$p = 0;
		$st_sid =  $_POST['st_sid'];
		$isabsent = array();
		if (isset($_POST['chbox'])) {
			$isabsent =  $_POST['chbox'];
		}

		for ($j = 0; $j < count($st_sid); $j++) {
			// echo "hii";
			$stmtInsert = $conn->prepare("INSERT INTO attendance (sid, date, isabsent, uid, id, did, t_from, t_to, ltype) 
								VALUES (:sid, :date, :isabsent, :uid, :id ,:did ,:t_from, :t_to, :ltype)");
			$stmtInsert1 = $conn->prepare("INSERT INTO daily (sid, date, isabsent, uid, id, did, t_from, t_to, ltype) 
								VALUES (:sid, :date, :isabsent, :uid, :id ,:did ,:t_from, :t_to, :ltype)");

			if (count($isabsent)) {
				$p = (in_array($st_sid[$j], $isabsent)) ? 1 : 0;
			}


			$stmtInsert->bindParam(':sid', $st_sid[$j]);
			$stmtInsert->bindParam(':date', $tstamp);
			$stmtInsert->bindParam(':isabsent', $p);
			$stmtInsert->bindParam(':uid', $uid);
			$stmtInsert->bindParam(':id', $id);
			$stmtInsert->bindParam(':did', $did);
			$stmtInsert->bindParam(':t_from', $t_from);
			$stmtInsert->bindParam(':t_to', $t_to);
			$stmtInsert->bindParam(':ltype', $ltype);
			$stmtInsert->execute();

			$stmtInsert1->bindParam(':sid', $st_sid[$j]);
			$stmtInsert1->bindParam(':date', $tstamp);
			$stmtInsert1->bindParam(':isabsent', $p);
			$stmtInsert1->bindParam(':uid', $uid);
			$stmtInsert1->bindParam(':id', $id);
			$stmtInsert1->bindParam(':did', $did);
			$stmtInsert1->bindParam(':t_from', $t_from);
			$stmtInsert1->bindParam(':t_to', $t_to);
			$stmtInsert1->bindParam(':ltype', $ltype);
			$stmtInsert1->execute();
			//	echo "data upadted".$j;
		}


		echo '<p>&nbsp;</p><div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Well done!</strong> Attendance Recorded Successfully!.
              </div>';
		echo "<button type='submit' class='btn btn-success btn-block' style='border-radius:0%;' name='message'><i class='glyphicon glyphicon-envelope'></i><a href='index.php?message=true'> <span style='color:white'>Send Message</span></a></button>";
	}
}
?>
<br>
<?php


function msg_send()
{


	$databaseHost = 'localhost';
	$databaseName = 'test';
	$databaseUsername = 'root';
	$databasePassword = '';

	// remote Database connection

	// $databaseHost = '#####';
	// $databaseName = '#####';
	// $databaseUsername = '#####';
	// $databasePassword = '###############';

	try {

		$conn = new PDO('mysql:host=' . $databaseHost . ';dbname=' . $databaseName . '', $databaseUsername, $databasePassword);
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
	// echo "Connection is there<br/>";
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



	// $qu = "SELECT * FROM student INNER JOIN attendance ON attendance.sid=student.sid INNER JOIN subject ON attendance.id=subject.id";
	// $stu = $conn->query($qu);
	// $rstu = $stu->fetchAll(PDO::FETCH_ASSOC);

	// for ($i = 0; $i < count($rstu); $i++) {
	// 	$no = $rstu[$i]['pno'];
	// 	$na = $rstu[$i]['name'];
	// 	$que1 = "SELECT id, name from subject where id={$rstu[$i]['id']}";
	// 	$ret1 = $conn->query($que1);
	// 	$attData1 = $ret1->fetchAll(PDO::FETCH_ASSOC);
	// 	$l = $rstu[$i]['name'];
	// 	$m = "Dear Parent " . "
	// 	" . "Your Child " . $na . " is absent for Today's " . $l . " lecture<br>
	// 	";
	// 	echo $m;
	// }
	// $qu = "SELECT attendance.id,student.name,student.pno FROM student inner join attendance where attendance.sid=student.sid && isabsent=1";
	$qu = "SELECT * FROM student INNER JOIN attendance ON attendance.sid=student.sid INNER JOIN subject ON attendance.id=subject.id where isabsent=1";
	$stu = $conn->query($qu);
	$rstu = $stu->fetchAll(PDO::FETCH_ASSOC);

	for ($i = 0; $i < count($rstu); $i++) {
		$no = $rstu[$i]['pno'];
		$na = $rstu[$i]['name'];
		$t = $rstu[$i]['ltype'];
		$l = $rstu[$i]['sname'];
		$tf = $rstu[$i]['t_from'];
		$tt = $rstu[$i]['t_to'];
		$m = "Dear Parent 
	" . "Your Child " . $na . " is absent for Today's ".$t." lecture of " . $l ." From: ".$tf." To:".$tt. " Schedule"."
	";
		echo $m;

		// $sub = $rstu[$i]['subject'];



		// Pull messages (for push messages please go to settings of the number)
		$my_apikey = "XFV5ZU87JOPFJREP2SY4";
		$number = "918698155767";
		$type = "OUT";
		$markaspulled = "1";
		$getnotpulledonly = "0";
		$api_url  = "http://panel.rapiwha.com/get_messages.php";
		$api_url .= "?apikey=" . urlencode($my_apikey);
		$api_url .= "&number=" . urlencode($number);
		$api_url .= "&type=" . urlencode($type);
		$api_url .= "&markaspulled=" . urlencode($markaspulled);
		$api_url .= "&getnotpulledonly=" . urlencode($getnotpulledonly);
		$my_json_result = file_get_contents($api_url, false);
		$my_php_arr = json_decode($my_json_result);
		foreach ($my_php_arr as $item) {
			$from_temp = $item->from;
			$to_temp = $item->to;
			$text_temp = $item->text;
			$type_temp = $item->type;
			echo "<br>" . $from_temp . " -> " . $to_temp . " (" . $type_temp . "): " . $text_temp;
			// Do something
		}
		$my_apikey = "XFV5ZU87JOPFJREP2SY4";
		$destination = $no;
		$message = $m;
		$api_url = "http://panel.rapiwha.com/send_message.php";
		$api_url .= "?apikey=" . urlencode($my_apikey);
		$api_url .= "&number=" . urlencode($no);
		$api_url .= "&text=" . urlencode($m);
		$my_result_object = json_decode(file_get_contents($api_url, false));
		echo "<br>Result: " . $my_result_object->success;
		echo "<br>Description: " . $my_result_object->description;
		echo "<br>Code: " . $my_result_object->result_code;
		echo "<br>";


		$server_name = "localhost";
		$user_name = "root";
		$password = "";
		$database_name = "test";
		$connection = mysqli_connect($server_name, $user_name, $password, $database_name);
		$query = "TRUNCATE table attendance";

		if (mysqli_multi_query($connection, $query)) {
			echo "Message Sent<br>";
		} else {
			echo "Error:" . mysqli_error($connection);
		}
		mysqli_close($connection);
	}
}
if (isset($_GET['message'])) {
	msg_send();
}

?>

	</div>
</div>
</div>

<script>
	$('#subjectForm').validator();
</script>