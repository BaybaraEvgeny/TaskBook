<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>View Task</title>
		<meta charset="utf-8">
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/icon.png" />
	</head>
	
	<body>
		<div class="container">
			<div class="span10 offset 1">
				<div class="row">
					<h3><strong>View Task</strong></h3>
				</div>

				<div class="form-horizontal">
					<div class="control-group">
						<label class="control-label">Name:</label>
							<div class="controls">
								<label class="checkbox">
									<?php echo $task->username; ?>
								</label>
							</div>
					</div>

					<div class="control-group">
						<label class="control-label">Email Address:</label>
							<div class="controls">
								<label class="checkbox">
									<?php echo $task->email; ?>
								</label>
							</div>
					</div>

					<div class="control-group">
						<label class="control-label">Text</label>
							<div class="controls">
								<label class="checkbox">
									<?php echo $task->text; ?>
								</label>
							</div>
					</div>
					<br>
					<div class="form-actions">
						<a class="btn btn-secondary" href="/">Back</a>
					</div>
			</div>
		</div>
	</body>
</html>