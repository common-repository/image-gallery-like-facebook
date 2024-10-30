jQuery(document).ready(function(){

					jQuery("#hb-gallery .masonry-grid  a[rel^='prettyPhoto']").prettyPhoto({
									overlay_gallery: false,
    show_title: false,
    hideflash: true,
    social_tools: "", 
    iframe_markup: "<iframe src='{path}' width='{width}' height='{height}' frameborder='no' allowfullscreen='true'></iframe>", 
    deeplinking: false
					});		
});