<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
		<div class="row">
			<div class='col-sm-12'>
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<HR>
			</div>
		</div>
		<div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span><?= _t('Comments and Tags'); ?> (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-4'>
				
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator,contributor,author"><div class="unit"><label>Creators and Contributors</label>
								<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator,contributor,author"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
							</div></ifcount>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="repository" min="1"><div class="unit"><label>Repository</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="repository"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}				
				
				{{{<ifdef code="ca_objects.summary">
					<div class='unit'><label>Summary</label>
						<span class="trimText">^ca_objects.summary</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.cultural_narrative">
					<div class='unit'><label>Cultural Narrative</label>
						<span class="trimText">^ca_objects.cultural_narrative</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><label>Description</label>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
			</div>
			<div class='col-md-12 col-lg-3'>
				<div id='detailTools' class='bgLightGray'>
<?php
				print "<div class='detailTool'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Loan Request", "", "", "Contact", "Form", array("inquire_type" => "loan", "table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
				print "<div class='detailTool'>".caNavLink($this->request, "<i class='fa fa-comments-o' aria-hidden='true'></i> Share Your Cultural Narrative", "", "", "Contact", "Form", array("inquire_type" => "cultural_narrative", "table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="container">
				<div class="row bgLightGray detailBottom">
					<div class="col-sm-12 col-md-3">
						{{{<ifdef code="ca_objects.date|ca_objects.date_note"><div class="unit"><label>Date</label>^ca_objects.date<ifdef code="ca_objects.date_note"><ifdef code="ca_objects.date">, </ifdef>^ca_objects.date_note</ifdef></div></ifdef>}}}
						{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="creator,contributor,author" restrictToTypes="organization"><div class="unit"><label>Related Organizations</label>
										<unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="creator,contributor,author" restrictToTypes="organization"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
									</div></ifcount>}}}
						{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="creator,contributor,author" restrictToTypes="individual"><div class="unit"><label>Related People</label>
										<unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="creator,contributor,author" restrictToTypes="individual"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
									</div></ifcount>}}}
						{{{<ifdef code="ca_objects.type"><div class="unit"><label>Type</label>^ca_objects.type%delimiter=,_</div></ifdef>}}}
						{{{<ifdef code="ca_objects.format_material"><div class="unit"><label>Format/Material</label>^ca_objects.format_material%delimiter=,_</div></ifdef>}}}
						{{{<ifdef code="ca_objects.language"><div class="unit"><label>Language</label>^ca_objects.language%delimiter=,_</div></ifdef>}}}
						{{{<ifdef code="ca_objects.publisher_container.publisher|ca_objects.publisher_container.pub_place"><div class="unit"><label>Publisher</label>^ca_objects.publisher_container.publisher<ifdef code="ca_objects.publisher_container.pub_place">, ^ca_objects.publisher_container.pub_place</ifdef></div></ifdef>}}}
						{{{<ifcount min="1" code="ca_collections"><div class="unit"><label>Collection</label><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></div></unit>}}}
						{{{<ifdef code="ca_objects.copies"><div class="unit"><label>Number of Copies</label>^ca_objects.copies</div></ifdef>}}}
						{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
					</div>
					{{{<ifdef code="ca_objects.sacred|ca_objects.content_warning|ca_objects.cultural_app_warning|ca_objects.category|ca_objects.subjects|ca_objects.terms_container.term|ca_objects.orthography">
						<div class="col-sm-12 col-md-3">			
				
						<ifdef code="ca_objects.sacred"><div class="unit"><label>Sacred Item</label>^ca_objects.sacred</div></ifdef>
						<ifdef code="ca_objects.content_warning"><div class="unit warning"><unit relativeTo="ca_objects.content_warning" delimiter="<br/>">^ca_objects.content_warning</unit></div></ifdef>
						<ifdef code="ca_objects.cultural_app_warning"><div class="unit warning"><unit relativeTo="ca_objects.content_warning" delimiter="<br/>"><unit relativeTo="ca_objects.cultural_app_warning" delimiter="<br/>">^ca_objects.cultural_app_warning</unit></div></ifdef>
						<ifdef code="ca_objects.category"><div class="unit"><label>Special Category</label>^ca_objects.category%delimiter=,_</div></ifdef>
						<ifdef code="ca_objects.subjects"><div class="unit"><label>Subjects</label>^ca_objects.subjects%delimiter=,_</div></ifdef>
						<ifdef code="ca_objects.terms_container.term"><div class="unit"><label>Related Terms</label><unit relativeTo="ca_objects.terms_container"><ifdef code="ca_objects.terms_container.term_link"><a href="^ca_objects.terms_container.term_link">^ca_objects.terms_container.term</a></ifdef><ifnotdef code="ca_objects.terms_container.term_link">^ca_objects.terms_container.term</ifnotdef></unit></div></ifdef>
						<ifdef code="ca_objects.orthography"><div class="unit"><label>Orthography</label>^ca_objects.orthography%delimiter=,_</div></ifdef>
				
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_objects.credit|ca_objects.rights|ca_objects.access_conditions|ca_objects.use_reproduction|ca_objects.source">
						<div class="col-sm-12 col-md-3">
							<ifdef code="ca_objects.credit"><div class="unit"><label>Credit Line</label>^ca_objects.credit</div></ifdef>
							<ifdef code="ca_objects.rights"><div class="unit"><label>Rights</label>^ca_objects.rights</div></ifdef>
							<ifdef code="ca_objects.access_conditions"><div class="unit"><label>Access Conditions</label>^ca_objects.access_conditions</div></ifdef>
							<ifdef code="ca_objects.use_reproduction"><div class="unit"><label>Use and Reproduction Conditions</label>^ca_objects.use_reproduction</div></ifdef>
							<ifdef code="ca_objects.source"><div class="unit"><label>Source</label>^ca_objects.source</div></ifdef>
						</div>
					</ifdef>}}}
					<div class="col-sm-12 col-md-3">
						{{{<ifcount code="ca_places" min="1" restrictToTypes="community"><div class="unit"><label>Related Communities</label>
										<unit relativeTo="ca_places" delimiter="<br/>" restrictToTypes="community"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>
									</div></ifcount>}}}
						{{{<ifcount code="ca_places" min="1" excludeTypes="community"><div class="unit"><label>Related Places</label>
										<unit relativeTo="ca_places" delimiter="<br/>" excludeTypes="community"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>
									</div></ifcount>}}}
						<div class="unit">{{{map}}}</div>
						
					</div><!-- end col -->
				</div><!-- end row --></div><!-- end container -->
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>