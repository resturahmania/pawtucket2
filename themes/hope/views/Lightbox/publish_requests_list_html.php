<?php
	$va_under_review_sets = $this->getVar("under_review_sets");
	$va_published_sets = $this->getVar("published_sets");
	$vs_displayname = $this->getVar("lightbox_parent_displayname");
	$vs_displayname_plural = $this->getVar("lightbox_displayname_plural");
?>
	<div class="publishRequestList">
	<div class="row">
		<div class='col-sm-12 col-md-8 col-md-offset-2'>
			<h1>Student / Faculty <?php print $vs_displayname; ?> Publication Requests</h1>
			<div class='row'><div class='col-sm-12'><hr/></div></div>
<?php
		if(is_array($va_under_review_sets) && sizeof($va_under_review_sets)){
			foreach($va_under_review_sets as $va_set){
				print "<div class='row'><div class='col-sm-12 col-md-6'><H2>".$va_set["name"]."</h2><b>Owner:</b> ".trim($va_set["lname"]." ".$va_set["fname"])." (<a href='mailto:".$va_set["email"]."'>".$va_set["email"]."</a>)<br/><br/></div>";
				print "<div class='col-sm-12 col-md-6 text-center'><br/>".caNavLink($this->request, _t("Preview %1", $vs_displayname), "btn btn-default btn-sm", "", "Gallery", $va_set["set_id"])." ".caNavLink($this->request, "Publish", "btn btn-default btn-sm", "", "Lightbox", "publishRequestApprove", array("set_id" => $va_set["set_id"]))." ".caNavLink($this->request, "Unpublish", "btn btn-default btn-sm", "", "Lightbox", "unpublish", array("set_id" => $va_set["set_id"]))."</div>";
				print "</div><!-- end row -->\n";
				print "<div class='row'><div class='col-sm-12'><hr/></div></div>";
			}
		}else{
?>
			<div class='row'><div class='col-sm-12'><b>There are no publication requests to review</b></div></div>
			<div class='row'><div class='col-sm-12'><hr/></div></div>
<?php			
		}
?>
			</div>
		
		</div>
	</div>
	<div class="row">
		<div class='col-sm-12 col-md-8 col-md-offset-2'>
			<h1>Published Student / Faculty <?php print $vs_displayname_plural; ?></h1>
			<div class='row'><div class='col-sm-12'><hr/></div></div>
<?php
		if(is_array($va_published_sets) && sizeof($va_published_sets)){
			foreach($va_published_sets as $va_set){
				print "<div class='row'><div class='col-sm-12 col-md-6'><H2>".$va_set["name"]."</h2><b>Owner:</b> ".trim($va_set["lname"]." ".$va_set["fname"])." (<a href='mailto:".$va_set["email"]."'>".$va_set["email"]."</a>)<br/><br/></div>";
				print "<div class='col-sm-12 col-md-6 text-center'><br/>".caNavLink($this->request, _t("View %1", $vs_displayname), "btn btn-default btn-sm", "", "Gallery", $va_set["set_id"])." ".caNavLink($this->request, "Unpublish", "btn btn-default btn-sm", "", "Lightbox", "unpublish", array("set_id" => $va_set["set_id"]))."</div>";
				print "</div><!-- end row -->\n";
				print "<div class='row'><div class='col-sm-12'><hr/></div></div>";
			}
		}else{
?>
			<div class='row'><div class='col-sm-12'><b>There are no published <?php print $vs_displayname_plural; ?></b></div></div>
			<div class='row'><div class='col-sm-12'><hr/></div></div>
<?php			
		}
?>
			</div>
		
		</div>
	</div>
		
