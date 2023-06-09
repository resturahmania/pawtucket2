<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_refine_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2015 Whirl-i-Gig
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
 
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_key 			= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vs_view			= $this->getVar('view');
	$vs_browse_type		= $this->getVar('browse_type');
	$o_browse			= $this->getVar('browse');
	$va_browse_info 	= $this->getVar("browseInfo");
	
	$vn_facet_display_length_initial = 60;
	$vn_facet_display_length_maximum = 600;
	$va_browse_types = caGetBrowseTypes();
	
	$t_item = new ca_list_items();
	
	$va_multiple_selection_facet_list = [];

	#if(is_array($va_facets) && sizeof($va_facets)){
		print "<div id='bMorePanel'><!-- long lists of facets are loaded here --></div>";
		print "<div id='bRefine'>";
		print "<a href='#' class='pull-right' id='bRefineClose' onclick='jQuery(\"#bRefine\").toggle(); return false;'><span class='glyphicon glyphicon-remove-circle'></span></a>";

		foreach ($va_browse_types as $vs_browse_id => $va_browse_type) {
			
			if ($vs_browse_type == $vs_browse_id) {
				if(is_array($va_facets) && sizeof($va_facets)) {
					print "<H5>"._t("Filter by")."</H5>";
				}
				foreach($va_facets as $vs_facet_name => $va_facet_info) {
					$va_multiple_selection_facet_list[$vs_facet_name] = caGetOption('multiple', $va_facet_info, false, ['castTo' => 'boolean']);
			
					if ((caGetOption('deferred_load', $va_facet_info, false) || ($va_facet_info["group_mode"] == 'hierarchical')) && ($o_browse->getFacet($vs_facet_name))) {
						print "<h5 data-toggle='dropdown'>".$va_facet_info['label_singular']."</H5><div id='facetGroup{$vs_facet_name}'>"; 
						print "<div class='container'><div class='row hierarchicalList'>"; 
?>
						
							<script type="text/javascript">
								jQuery(document).ready(function() {
									jQuery("#bHierarchyList_<?php print $vs_facet_name; ?>").load("<?php print caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'linkTo' => 'morePanel')); ?>");
								});
							</script>
							<div id='bHierarchyList_<?php print $vs_facet_name; ?>'><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
<?php
						print "</div><!-- end row --></div><!-- end container --></div><!-- end facetGroup -->";
					} else {				
						if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
						print "<h5 type='button' onClick='jQuery(\"#facetGroup{$vs_facet_name}\").slideToggle(); return false;'>".$va_facet_info['label_singular']."</H5><div id='facetGroup{$vs_facet_name}' style='display:none;'>"; 
						print "<div class='container facetContainer' id='{$vs_facet_name}_facet_container'><div class='row'>";
						switch($va_facet_info["group_mode"]){
							case "alphabetical":
							case "list":
							default:
								$vn_facet_size = sizeof($va_facet_info['content']);
								$vn_c = 0;
								foreach($va_facet_info['content'] as $va_item) {
									$vs_label = $va_item['label'];
									if (caGetOption('show_color_swatch', $va_facet_info, false, ['castTo' => 'boolean'])){
										$t_item->load($va_item['id']);
										$vs_label = "<span class='bSwatch' style='background-color:#".$t_item->get("color")."' title='".$va_item['label']."'></span>";
									}
									print "<div class='col-sm-4 facetItem' data-facet='{$vs_facet_name}' data-facet_item_id='{$va_item['id']}'>".caNavLink($this->request, $vs_label, '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."</div>";
									$vn_c++;
									if ($vn_c == 3) {
										print "<div style='clear:both;width:100%;margin-bottom:10px;'></div>";
										$vn_c = 0;
									}
						
									#if (($vn_c == $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size <= $vn_facet_display_length_maximum)) {
									#	print "<div id='{$vs_facet_name}_more' style='display: none;'>";
									#} else {
									#	if(($vn_c == $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_maximum))  {
									#		break;
									#	}
									#}
								}
								#if (($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size <= $vn_facet_display_length_maximum)) {
								#	print "</div>\n";
						
								#	$vs_link_open_text = _t("and %1 more", $vn_facet_size - $vn_facet_display_length_initial);
								#	$vs_link_close_text = _t("close", $vn_facet_size - $vn_facet_display_length_initial);
								#	print "<div><a href='#' class='more' id='{$vs_facet_name}_more_link' onclick='jQuery(\"#{$vs_facet_name}_more\").slideToggle(250, function() { jQuery(this).is(\":visible\") ? jQuery(\"#{$vs_facet_name}_more_link\").text(\"".addslashes($vs_link_close_text)."\") : jQuery(\"#{$vs_facet_name}_more_link\").text(\"".addslashes($vs_link_open_text)."\")}); return false;'><em>{$vs_link_open_text}</em></a></div>";
								#} elseif (($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_maximum)) {
								#	print "<div><a href='#' class='more' onclick='jQuery(\"#bMorePanel\").load(\"".caNavUrl($this->request, '*', '*', '*', array('getFacet' => 1, 'facet' => $vs_facet_name, 'view' => $vs_view, 'key' => $vs_key))."\", function(){jQuery(\"#bMorePanel\").show(); jQuery(\"#bMorePanel\").mouseleave(function(){jQuery(\"#bMorePanel\").hide();});}); return false;'><em>"._t("and %1 more", $vn_facet_size - $vn_facet_display_length_initial)."</em></a></div>";
								#}
							break;	
							# ---------------------------------------------
						}
						
						if ($va_multiple_selection_facet_list[$vs_facet_name]) {
?>
	<a href="#" id="<?php print $vs_facet_name; ?>_facet_apply" data-facet="<?php print $vs_facet_name; ?>" class="facetApply">Apply</a>
<?php
						}
						
						print "</div><!-- end row --></div><!-- end container --></div><!-- end facetGroup -->";
					}
				}
				if(is_array($va_facets) && sizeof($va_facets)) {
					print "<div style='height:5px;width:100%;'></div>";
				}
			}	
		}
		print "</div><!-- end bRefine -->\n";
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
            if(jQuery('#browseResultsContainer').height() > jQuery(window).height()){
				var offset = jQuery('#bRefine').height(jQuery(window).height() - 30).offset();   // 0px top + (2 * 15px padding) = 30px
				var panelWidth = jQuery('#bRefine').width();
				jQuery(window).scroll(function () {
					var scrollTop = $(window).scrollTop();
					// check the visible top of the browser
					if (offset.top<scrollTop && ((offset.top + jQuery('#pageArea').height() - jQuery('#bRefine').height() + 155) > scrollTop)) {
						jQuery('#bRefine').addClass('fixed');
						jQuery('#bRefine').width(panelWidth);
					} else {
						jQuery('#bRefine').removeClass('fixed');
					}
				});
            }
            
            var multiple_selection_facet_list = <?php print json_encode($va_multiple_selection_facet_list); ?>;
            
            jQuery(".facetApply").hide();
            
            jQuery(".facetItem").on('click', function(e) { 
            	if (!multiple_selection_facet_list[jQuery(this).data('facet')]) { return; }
            	if (jQuery(this).attr('facet_item_selected') == '1') {
            		jQuery(this).attr('facet_item_selected', '');
            	} else {
            		jQuery(this).attr('facet_item_selected', '1');
            	}
            	
            	if (jQuery("div.facetItem[facet_item_selected='1']").length > 0) {
            		jQuery("#" + jQuery(this).data('facet') + "_facet_apply").show();
            	} else {
            		jQuery("#" + jQuery(this).data('facet') + "_facet_apply").hide();
            	}
            	
            	e.preventDefault();
            	return false;
            });
            
            jQuery(".facetApply").on('click', function(e) { 
            	var facet = jQuery(this).data('facet');
            	
            	var ids = [];
            	jQuery.each(jQuery("#" + facet + "_facet_container").find("[facet_item_selected=1]"), function(k,v) {
            		ids.push(jQuery(v).data('facet_item_id'));
            	});
            	
            	window.location = '<?php print caNavUrl($this->request, '*', '*','*', array('key' => $vs_key, 'view' => $vs_view)); ?>/facet/' + facet + '/id/' + ids.join('|');
            	
            	e.preventDefault();
            });
		});
	</script>
<?php	
	#}
