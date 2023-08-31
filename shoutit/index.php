<!DOCTYPE html>
<html>
	<head>
  		 <!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

  		<title>ChatterBox</title>
		<link rel="stylesheet" href="css/style.css" type="text/css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	</head>
	<body>


<!-- Back End -->
<?php

require_once('database.php');


if (isset($_REQUEST["sendMessage"]) && $_REQUEST["sendMessage"]):
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$message = isset($_POST['message']) ? $_POST['message'] : '';
	$time = date("F j, g:i a");
	$stmt = $conn->prepare("INSERT INTO messages (user, message, time)
	VALUES(:user, :message, :time)");
	$stmt->bindParam(':user', $name);
	$stmt->bindParam(':message', $message);
	$stmt->bindParam(':time', $time);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_OBJ);
	var_dump($result);
	die;
endif;
?>

<!-- Fim Back End -->

<div class="container">
	<?php if (isset($stmt) && $stmt->execute()) {  ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Processo alterado com sucesso!!!!</strong>
                            </div>
                        </div>
                    </div>
                    <?php } else if (isset($stmt)) { ?>
                    <div class="row">
                        <div class="col-md-12">
                        <?=var_dump($stmt->errorinfo())?>
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Algo deu errado! As alterações não foram salvas.</strong>
                            </div>
                        </div>
                    </div>
					<?php } ?>
	<div class="row clearfix">
		<div class="col-lg-12">
			<div class="card chat-app">
				<div class="chat">
					<div class="chat-header clearfix">
						<div class="row">
							<div class="col-lg-12">
								<div class="chat-about">
									<h6 class="m-b-0">ChatterBox</h6>
								</div>
							</div>
						</div>
					</div>
					<div class="chat-history">
						<ul class="m-b-0">
						
							<?php foreach($result ??[] as $value):?>
							<li class="clearfix">
								<div class="message-data">
									<div class="chat-about">
										<h6 class="m-b-0"><?= $name ?></h6>
									</div>
									<span class="message-data-time"><?= $time ?></span>
								</div>
								<div class="message my-message"><?=$message?></div>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="chat-message clearfix">
						<form role="form" method="POST" name="sendMessage" action="?sendMessage=true">
							<div class="input-group mb-0">
								<input type="text" class="form-control" name="name" placeholder="Enter Your Name...">    
								<input type="text" class="form-control" name="message" placeholder="Enter Your Message...">
								<button type="submit">Send</button>                       
							</div>
						</form> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	</body>
</html>