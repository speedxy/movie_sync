<?php
ini_set("display_errors", true);
class LocalList {
	protected $content = NULL;
	protected $filename;
	protected $writable;

	public function __construct($filename, $writable = FALSE) {
		$this->filename = "/home/osmc/.kodi/sync/" . basename($filename);
		$this->writable = $writable;
		if(!file_exists($this->filename))
			throw new Exception("List File Not Found");
	}

	public function get() {
		if($this->content === NULL) {
			$this->read();
		}
		return $this->content;
	}

	public function set($content) {
		if($this->writable === TRUE)
			$this->content = array_map("trim", $content);
		else
			throw new Exception("Trying To Write To Read-Only File");
		return $this;
	}

	protected function read() {
		$this->content = array();
		$content = file_get_contents($this->filename);
		$content = explode("\n", $content);
		foreach($content as $line){
			$line = trim($line);
			if($line == "")
				continue;
			$this->content[] = $line;
		}
		sort($this->content);
	}

	public function save() {
		if($this->writable === TRUE)
			file_put_contents($this->filename, implode("\n", $this->content));
		else
			throw new Exception("Trying To Write To Read-Only File");
		return $this;
	}

}

class Wishlist extends LocalList {
	public function __construct($filename) {
		parent::__construct($filename, TRUE);
	}

	protected function read() {
		parent::read();
		$content = array();
		foreach($this->content as $line) {
			if($line == "- *") {
				continue;
			}
			if(substr($line, 0, 1) == "+") {
				$line = substr($line, 2);
				$line = substr($line, 0, -4);
				$content[] = $line;
			}
		}
		$this->content = $content;
	}

	public function save() {
		$content = array();
		foreach($this->content as $line){
			$content[] = "+ " . $line . "/***";
		}
		$content[] = "- *";

		if(!file_put_contents($this->filename, implode("\n", $content)))
			throw new Exception("Error Writing Wishlist File");
		return $this;
	}
}

try {
	if(!isset($_GET["mod"]))
		$_GET["mod"] = "start";
	switch($_GET["mod"]) {
		case "movies" :
			$wishlist = new Wishlist("movies-wishlist");
			$serverlist = new LocalList("movies-serverlist", FALSE);

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if($_POST["wishlist"]){
					$wishlist->set(explode("\n", $_POST["wishlist"]))->save();
				}
			}

			$template = "movies.tpl.php";
			break;
		case "tv" :
			$wishlist = new Wishlist("tv-wishlist");
			$serverlist = new LocalList("tv-serverlist", FALSE);

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if($_POST["wishlist"]){
					$wishlist->set(explode("\n", $_POST["wishlist"]))->save();
				}
			}

			$template = "movies.tpl.php";

			$template = "tv.tpl.php";
			break;
		case "settings" :
			$template = "settings.tpl.php";
			break;
		case "start":
		default :
			$template = "default.tpl.php";
			break;
	}

	// Movies

	// TV
} catch(Exception $e) {
	die($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script>
			$(document).ready(function() {
				setTimeout(function() {
					$('.fadeout').fadeOut('slow');
				}, 5000);
				$('.btn-close').click(function() {
					$(this).closest('div').fadeOut();
				});
				$('#sidebar').affix({
					offset: {
				    	top: 150
				    }
				});
				var toggle_marked = false;
				$('.toggle-unmarked').click(function(){
					console.log(toggle_marked);
					$('.list-group-item', $(this).closest(".panel")).each(function(){
						if(!$(this).hasClass("active")){
							if(toggle_marked == false)
								$(this).hide();
							else
								$(this).show();
						}
					});
					toggle_marked = !toggle_marked;
				});
				$('.add-to-wishlist').click(function(){
					// @TODO
					console.log($(this).text());
					return false;
				});
			});
		</script>
		<style>
			textarea.small-list {
				width: 100%;
				height: 400px;
			}
			#sidebar {
				width: 290px;
			}
			#sidebar.affix {
				top: 20px;
			}
			@media (min-width: 1200px){
				#sidebar {
					width: 360px;
				}
			}
		</style>
		<title>OSMC Media-Sync</title>
	</head>
	<body>
		<div class="container">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="/">OSMC Media-Sync</a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<li<?=($_GET["mod"] == "movies" ? ' class="active"' : ''); ?>>
								<a href="/?mod=movies">Filme <span class="sr-only">(current)</span></a>
								</li>
								<li<?=($_GET["mod"] == "tv" ? ' class="active"' : ''); ?>>
									<a href="/?mod=tv">Serien</a>
									</li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li<?=($_GET["mod"] == "settings" ? ' class="active"' : ''); ?>>
								<a href="/?mod=settings"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
								</li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>

			<div id="content">
				<?php
				require (__DIR__ . "/" . $template);
				?>
			</div>
		</div><!-- /.container -->
	</body>
</html>