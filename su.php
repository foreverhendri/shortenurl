<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<title>Shorten URL</title>

		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">

		<style type="text/css">
			body {
				height: 100%;
				margin: 0;
				padding: 0;
				width: 100%;
			}

			#block-ui {
				background-color: #000;
				display: none;
				height: 100%;
				left: 0;
				opacity: 0.8;
				position: fixed;
				top: 0;
				width: 100%;
				z-index: 9999999;
			}

			#block-ui-img {
				left: 50%;
				position: fixed;
				top: 50%;
				transform: translate(-50%, -50%);
			}

			#title {
				font-weight: bold;
				margin: 20px auto;
				width: 100px;
			}
		</style>

		<script src="js/jquery-1.12.4.min.js" type="text/javascript"></script>
		<script src="js/bootstrap.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function() {
				$('#short-url').html('');
				$('#long-url').val('');
			});

			function generate() {
				$('#block-ui').show();

				if ($('#long-url').val().trim() == '') {
					alert('Please input long url.');
					$('#block-ui').hide();

					return false;
				}

				$.ajax({
					data: {
						long_url: $('#long-url').val().trim()
					},
					dataType: 'JSON',
					error: function() {
						alert('Server Error');
						$('#block-ui').hide();
					},
					success: function(data) {
						if (!data.success) {
							alert(data.message);
							$('#block-ui').hide();

							return false;
						}

						$('#short-url').html('<a href="'+data.shorturl+'">'+data.shorturl+'</a>');

						$('#block-ui').hide();
					},
					type: 'POST',
					url: 'http://sufh.xyz/generate.php/'
				});
			}
		</script>
	</head>
	<body>
		<div id="title">Shorten URL</div>
		<hr>
		<div class="col-xs-12">
			<div class="box-body">
				<form class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<label for="long-url" class="col-sm-1 control-label">Long URL</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="long-url" placeholder="URL" autofocus>
							</div>
						</div>
						<div class="form-group">
							<label for="long-url" class="col-sm-1 control-label">Short URL</label>
							<div class="col-sm-10" id="short-url">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12" style="text-align: center;">
								<button class="btn btn-lg btn-default" type="button" onclick="generate();">Generate</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div id="block-ui"><img id="block-ui-img" src="img/loading.gif" /></div>
	</body>
</html>