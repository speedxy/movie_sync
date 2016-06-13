<div class="page-header">
		<h1>Serien <small>Synchronisation</small></h1>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					Serien auf dem Server
					<small><a href="#" class="toggle-unmarked"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></a></small>
					<span class="badge pull-right"><?=number_format(count($serverlist->get()), 0, ",", ".");?></span>
				</h3>
			</div>
			<div class="panel-body">
				<div class="list-group">
					<!--class="active"-->
					<?php
						foreach($serverlist->get() as $movie){
							$class = "";
						    foreach($wishlist->get() as $wish){
						    	$wish = preg_quote($wish);
						    	$wish = str_replace("\*", ".*", $wish);
						    	if(preg_match("#^" . $wish . "$#", $movie)){
						    		$class = "active";
						    		break;
						    	}
						    }
							?><a href="#" class="list-group-item <?=$class;?> add-to-wishlist"><?=$movie;?></a><?php
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<form role="form" method="post" action="/?mod=tv">
			<div class="panel panel-primary" id="sidebar">
				<div class="panel-heading">
					<h3 class="panel-title">
						Serien in der Wunschliste
						<span class="badge pull-right"><?=number_format(count($wishlist->get()), 0, ",", ".");?></span>
					</h3>
				</div>
				<div class="panel-body">
					<textarea name="wishlist" class="small-list"><?=implode("\n", $wishlist->get());?></textarea>
				</div>
				<div class="panel-footer">
					<button type="submit" class="btn btn-primary">
						Änderungen speichern
					</button>
				</div>
			</div>
		</form>
	</div>
</div>