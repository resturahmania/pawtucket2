<?php
	$va_access_values = $this->getVar("access_values");
	$o_collections_config = $this->getVar("collections_config");
	$vs_desc_template = $o_collections_config->get("description_template");
	$t_item = $this->getVar("item");
	$vn_collection_id = $this->getVar("collection_id");
	$va_exclude_collection_type_ids = $this->getVar("exclude_collection_type_ids");
	$va_non_linkable_collection_type_ids = $this->getVar("non_linkable_collection_type_ids");
	$va_collection_type_icons = $this->getVar("collection_type_icons");
	$vb_collapse_levels = $o_collections_config->get("collapse_levels");
	if($va_skip_collection_type_idnos = $o_collections_config->get("skip_collection_type_idnos")){
		$t_list = new ca_lists();
		$va_skip_collection_type_ids = $t_list->getItemIDsFromList("collection_types", $va_skip_collection_type_idnos, array("dontIncludeSubItems" => true));
	}
	$vb_show_objects = $this->request->getParameter('show_objects', pInteger);	
	
function printLevel($po_request, $va_collection_ids, $o_config, $vn_level, $va_options = array()) {
	if($o_config->get("max_levels") && ($vn_level > $o_config->get("max_levels"))){
		return;
	}
	$va_access_values = caGetUserAccessValues($po_request);
	$vs_output = "";
	$vs_desc_template = $o_config->get("description_template");
	$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
	
	if($qr_collections->numHits()){
		while($qr_collections->nextHit()) {
			$vs_icon = "";
			# --- related objects?
			$va_object_ids = $qr_collections->get("ca_objects.object_id", array("returnAsArray" => true, 'checkAccess' => $va_access_values));
			$vn_rel_object_count = sizeof($va_object_ids);
			if(is_array($va_options["collection_type_icons"])){
				$vs_icon = $va_options["collection_type_icons"][$qr_collections->get("ca_collections.type_id")];
			}
			$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.rank"));
			# --- check if collection record type is configured to be excluded
			if(($vn_level > 1) && is_array($va_options["exclude_collection_type_ids"]) && (in_array($qr_collections->get("ca_collections.type_id"), $va_options["exclude_collection_type_ids"]))){
				continue;
			}
			if(is_array($va_options["skip_collection_type_ids"]) && !in_array($qr_collections->get("ca_collections.type_id"), $va_options["skip_collection_type_ids"])){
				
				$vs_output .= "<div class='collectionLevelContainer'><div style='margin-left:".(20*($vn_level - 1))."px;'><div id='collectionLevel".$qr_collections->get("ca_collections.collection_id")."'></div><span class='glyphicon glyphicon-eye-open'></span>";
				# --- should collection record link to detail?
				#$vb_link = true;
				# --- check if collection record type has been configured to not be a link to detail page
				#if(is_array($va_options["non_linkable_collection_type_ids"]) && (in_array($qr_collections->get("ca_collections.type_id"), $va_options["non_linkable_collection_type_ids"]))){
				#	$vb_link = false;
				#}
				#if(!$o_config->get("always_link_to_detail")){
				#	if(!sizeof($va_child_ids) && !$vn_rel_object_count){
				#		$vb_link = false;
				#	}
				#}
				# --- should collection record title open collapsed sub items?
				if(($vn_level > 1) && $va_options["collapse_levels"]){
					$vb_collapse_link = true;
				}else{
					$vb_collapse_link = false;
				}
				if(!sizeof($va_child_ids) && !sizeof($va_object_ids)){
					$vb_collapse_link = false;
				}
				if($vn_level == 1){
					$vs_output .= "<div class='label'>".$qr_collections->get("ca_collections.idno");
				}
				#if($vb_link){
				#	$vs_output .= $vs_icon." ";
				#	if($vb_collapse_link){
				#		$vs_output .= "<a href='#' onClick='jQuery(\"#level".$qr_collections->get('ca_collections.collection_id')."\").toggle(); return false;'>".$qr_collections->get('ca_collections.preferred_labels')."</a>";
				#	}else{
				#		$vs_output .= caDetailLink($po_request, $qr_collections->get('ca_collections.preferred_labels'), '', 'ca_collections',  $qr_collections->get("ca_collections.collection_id"));
				#	}
				#	$vs_output .= " ".caDetailLink($po_request, (($o_config->get("link_out_icon")) ? $o_config->get("link_out_icon") : ""), '', 'ca_collections',  $qr_collections->get("ca_collections.collection_id"));
				#}else{
					$vs_output .= $vs_icon." ";
					if($vb_collapse_link){
						$vs_output .= "<a href='#' onClick='jQuery(\"#level".$qr_collections->get('ca_collections.collection_id')."\").toggle(); return false;'>".$qr_collections->get('ca_collections.preferred_labels')."<span class='glyphicon glyphicon-resize-vertical'></span></a>";
					}else{
						$vs_output .= $qr_collections->get("ca_collections.preferred_labels");
					}
				#}
				#if($vn_rel_object_count){
				#	$vs_output .= " <small>(".$vn_rel_object_count." record".(($vn_rel_object_count == 1) ? "" : "s").")</small>";
				#}
				if($vn_level == 1){
					$vs_output .= "</div>";
				}
				$vs_output .= "</div>";
			}			
			$vs_desc = "";
			if($vs_desc_template && ($vs_desc = $qr_collections->getWithTemplate($vs_desc_template))){
				$vs_desc = "<p style='margin-left:".(20*($vn_level - 1))."px;'>".$vs_desc."</p>";
			}
			if(sizeof($va_child_ids) || sizeof($va_object_ids) || $vs_desc) {
				if($vb_collapse_link){
					$vs_output .= "<div id='level".$qr_collections->get("ca_collections.collection_id")."' style='display:none;'>";
				}
				$vs_output .= $vs_desc;
				if($va_options["show_object"] && sizeof($va_object_ids)){
					$qr_objects = caMakeSearchResult("ca_objects", $va_object_ids);
					if($qr_objects->numHits()){
						$vs_output .= "<div class='collectionObjectsList' style='margin-left:".(20*($vn_level - 1))."px;'>";
						while($qr_objects->nextHit()){
							# --- does this item have media or it's children have media?
							$vs_eye = "";
							$vs_grandies = $qr_objects->getWithTemplate("<unit relativeTo='ca_objects.children'>^ca_object_representations.representation_id</unit>", array("checkAccess" => $va_access_values));
							$vs_bulk_ids = $qr_objects->getWithTemplate("<unit relativeTo='ca_objects.related' restrictToTypes='bulk' delimiter=','>^ca_object_representations.representation_id</unit>", array("checkAccess" => $va_access_values));
							
							$vb_show_eye = false;
							if($qr_objects->get("ca_object_representations.representation_id") || $vs_grandies || $vs_bulk_ids){
								$vb_show_eye = true;
?>
								<script>
									$(document).ready(function(){
										$("#<?php print "level".$qr_collections->get("ca_collections.collection_id"); ?>").parents(".collectionLevelContainer").addClass("showEye");
										 
									})
								</script>
<?php
								#$vs_eye = "<span class='glyphicon glyphicon-eye-open'></span>&nbsp;&nbsp;";
							}
							$vs_output .= "<div class='row'><div class='col-xs-9".(($vb_show_eye) ? " showEye" : "")."'><span class='glyphicon glyphicon-eye-open'></span>".caDetailLink($po_request, $qr_objects->get("ca_objects.preferred_labels"), '', 'ca_objects', $qr_objects->get("ca_objects.object_id"))."</div><div class='col-xs-3'>".$qr_objects->get("ca_objects.box_folder")."</div></div>";
						}
						$vs_output .= "</div>";
					}
				}
				$vs_output .=  printLevel($po_request, $va_child_ids, $o_config, $vn_level + 1, $va_options);
				if($vb_collapse_link){
					$vs_output .= "</div>";
				}
			}
			$vs_output .= "</div><!-- end collectionLevelContainer -->";
		}
	}
	
	return $vs_output;
}

if ($vn_collection_id) {
	print printLevel($this->request, array($vn_collection_id), $o_collections_config, 1, array("show_object" => $vb_show_objects, "skip_collection_type_ids" => $va_skip_collection_type_ids, "exclude_collection_type_ids" => $va_exclude_collection_type_ids, "non_linkable_collection_type_ids" => $va_non_linkable_collection_type_ids, "collection_type_icons" => $va_collection_type_icons, "collapse_levels" => $vb_collapse_levels));

	if($va_brand = $t_item->get('ca_collections.brand', array("returnAsArray" => true))){
		$vn_brand = $va_brand[0];
		print "<div style='margin-left:20px;'>".caNavLink($this->request, "Products", "", "", "Browse", "Products", array("facet" => "brand_facet", "id" => $vn_brand))."</div>";
	}
}
?>


