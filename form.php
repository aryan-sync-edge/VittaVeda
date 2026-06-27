<?php 
require_once "Config.php";

if ($_SERVER["REQUEST_METHOD"] != "POST"){
	header("Location: index.html");
	exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$firstName = trim($_POST['fname']);
	$lastName = trim($_POST['lname']);
	$email = trim($_POST['email']);
	$phone = trim($_POST['phone']);
	$category = trim($_POST['category']);
	$message = trim($_POST['message']);
	if(empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($category)){
			die("Please fill all required fields.");
		}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		die("Invalid email address.");
	}
	if(!preg_match('/^[0-9]{10}$/', $phone)){
		die("Phone number must contain exactly 10 digits. ");
	}

	$stmt = $conn->prepare("INSERT INTO TBL_CONSULTATION_REQUESTS(FIRST_NAME, LAST_NAME, EMAIL, PHONE, SERVICE_CATEGORY, MESSAGE) VALUES (?,?,?,?,?,?)");
	$stmt->bind_param("ssssss", $firstName, $lastName, $email, $phone, $category, $message);
	if($stmt->execute()){
		require_once "mail.php";
		echo "Data saved Successfully!";
	} else {
		echo "Error: " . $stmt->error;
	}
	$stmt->close();
	$conn->close();
}
?>

<!-- ===================== Stay With & Consultation ==================== 
		<section class="stay_consultation" id="contact">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 map-container-wrapper">
						<div class="map-container" style="padding-top: 66px; padding-bottom: 30px;">
							<iframe src="https://www.google.com/maps/embed?pb=!4v1782329048055!6m8!1m7!1se7QV70VyUs8oof2FnNUJ4A!2m2!1d19.21221045160097!2d72.95533917092526!3f17.6267995030962!4f8.027815293515744!5f1.5378273236760784" width="100%" height="450" style="border:0; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
						</div>
					</div>
					<div class="col-lg-7 col-md-7 col-md-12 col-xs-12 consultation" id="consultation-form">
						<div class="title_container">
							<h4>Request a Free Consultation</h4>
							<span class="decor_default"></span>
						</div>
						<form action="form.php" method="POST" class="submit cf-validation">
							<div class="input-group">
								<input type="text" name="fname" class="contact_field contact_field_1" placeholder="First Name *" required>
								<input type="text" name="lname" class="left_input_fix contact_field contact_field_2" placeholder="Last Name *" required>
								<input type="text" name="email" class="contact_field contact_field_3" placeholder="Email" required>
								<input type="text" name="phone" class="left_input_fix contact_field contact_field_4" placeholder="Phone *" required>
								<div class="single_form">
									<select class="selectmenu contact_field contact_field_5" name="category">
										<option selected="selected">Private Banking</option>
										<option>Mutual Fund</option>
										<option>Insurance</option>
										<option>Share Trading</option>
										<option>Loans</option>
										<option>Construction Finance</option>
										<option>Project Finance</option>
										<option>MSME Finance</option>
										<option>Real Estate Buy & Sale</option>
										<option>Wealth Basket</option>
										<option>Stock Broking</option>
									</select>
								</div>  End .single_form 
								<textarea class="contact_field contact_field_6" placeholder="Special Request..." name="message"></textarea>
							</div>  /input-group 
							<button type="submit" class="button-main hvr-sweep-to-rightB submit_now">Submit now</button>
						</form>
					</div>
				</div>
			</div>
		</section>
		< ===================== /Stay With & Consultation ==================== -->
