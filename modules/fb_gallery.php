<?php
/*
* Add-on Name: Image Gallery Like Facebook for WPBakery Page Builder (formerly Visual Composer)
* Add-on URI: https://www.cristianiosub.com
*/
if(!class_exists("fb_gallery")){
	class fb_gallery{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"fb_gallery_init"));
			add_shortcode('fb_gallery',array($this,'fb_gallery_shortcode'));
		}
		function fb_gallery_init(){
			if(function_exists("vc_map")){
				vc_map( array(
					"base" => "fb_gallery",
					"name" => __( "Image Gallery Like Facebook", "js_composer" ),
					"class" => "about_class",
					"category" => __( 'FB Image Gallery', 'js_composer' ),
					"icon" => "about_icon",
					"params" => array(	
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Gallery Title", "js_composer" ),
							"param_name" => "galelement_heading",
							"description" => __( "Enter Gallery Heading Here ", "js_composer" )
						),
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "gall_class",
							"heading" => __( "Gallery Icon Class", "js_composer" ),
							"param_name" => "gall_class",
							"description" => __( "Add Gallery Icon Class", "js_composer" )
						),
						array(
							"type" => "dropdown",
							"holder" => "p",
							"heading" => __( "Link or prettyphoto", "js_composer" ),
							"param_name" => "chhose_type",
							"value" => array("prettyphoto","link"),
							"description" => __( "Choose From The Dropdown", "js_composer" )
						),
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Image Space padding px", "js_composer" ),
							"param_name" => "img_padding",
							"description" => __( "Enter Image Padding Here px ", "js_composer" )
						),
						array(
							"type" => "colorpicker",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Choose Shadow Color", "js_composer" ),
							"param_name" => "img_color",
							"description" => __( "Choose Shadow Color Here ", "js_composer" )
						),
						array(
							"type" => "colorpicker",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Choose Font Icon Color", "js_composer" ),
							"param_name" => "icon_color",
							"description" => __( "Choose  Font Icon Color Here ", "js_composer" )
						),
						array(
										'type' => 'attach_images',
										"holder" => "p",
										'heading' => __( 'Images Gallery', 'js_composer' ),
										'param_name' => 'bkground_image',
										'value' => '',
										'description' => __( 'Select Images From Media Library', 'js_composer' )
									),
					array(
										"type" => "textarea",
										"holder" => "p",
										"class" => "",
										"heading" => __( "Gallery Links For Custom Links Case", "js_composer" ),
										"param_name" => "gal_link",
										"description" => __( "Enter links for every image (Seperate each link by -- )", "js_composer" )
									),
				)
					) 
				);
			}
		}
		function fb_gallery_shortcode( $atts, $content = null ) {
			$result = shortcode_atts( array(
				'galelement_heading' => '',
				'gall_class' => '',
				'chhose_type' => '',
				'img_padding' => '',
				'img_color' => '',
				'bkground_image' => '',
				'gal_link' => '',
				'icon_color'=>'',
			), $atts );
			extract( $result );
			if(empty($img_padding)){
				$padding='15px';
			}else{
				$padding=$img_padding;
			}
			if(empty($img_color)){
				$img_color='rgba(170,170,255,0.8)';
			}
			if(empty($icon_color)){
				$icon_color='rgba(170,170,255,0.8)';
			}
			$output='<style>.hb-postimage:before,
.hb-gallerycontent
{background: rgba('.$img_color.');
background: -moz-linear-gradient(left, '.$img_color.' 0%, rgba(251,186,248,0.8) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, '.$img_color.'), color-stop(100%, rgba(251,186,248,0.8)));
background: -webkit-linear-gradient(left, '.$img_color.' 0%, rgba(251,186,248,0.8) 100%);
background: -o-linear-gradient(left, '.$img_color.' 0%, rgba(251,186,248,0.8) 100%);
background: -ms-linear-gradient(left, '.$img_color.' 0%, rgba(251,186,248,0.8) 100%);
background: linear-gradient(to right, '.$img_color.' 0%, rgba(251,186,248,0.8) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#aaaaff", endColorstr="#fbbaf8", GradientType=1 );
}</style>'; 
wp_enqueue_style( 'gall-adonscss3', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css
' );
			wp_enqueue_style( 'gall-adonscss', plugin_dir_url( __FILE__ ) . '../assets/gallery.css' );
			wp_enqueue_style( 'gall-adonscss2', 'https://cdn.jsdelivr.net/prettyphoto/3.1.6/css/prettyPhoto.css' );
			wp_enqueue_script( 'gall-adonscss','https://cdn.jsdelivr.net/prettyphoto/3.1.6/js/jquery.prettyPhoto.js' );
			wp_enqueue_script( 'gall-adonjs', plugin_dir_url( __FILE__ ) . '../assets/gall.js' );
					$explodebk=explode(',',$bkground_image);
	 		if($chhose_type=='link'){
	 			$output .='<section id="hb-gallery" class="hb-gallery v2 hb-sectionspace hb-haslayout">
							<div class="container">
								<div class="row">
									<div class=" col-xs-12 col-sm-12 ">
										<div class="hb-sectionhead ">
											<div class="hb-sectiontitle">
												<h3><i class="fa '.$gall_class.'" style="color:'.$icon_color.';"></i>
													'.$galelement_heading.'
												</h3>
											</div>
										</div>
									</div>
									<div class=" col-xs-12">
										<div class="hb-gallery-area">
								            <div id="filter-masonry" class="hb-portfolio-content hb-haslayout">';
								            $countdata=count($explodebk);
								            $link2=explode('--', $gal_link);
								            $temp=1;
								            if(!empty($explodebk)){
								            	$temp2=0;
								            	foreach ($explodebk as $datg) {
								            			$image = wpb_getImageBySize( array( 'attach_id' => $datg, 'thumb_size' => '100', 'class' => 'vc_single_image-img' ) );
								            			print_r($image);
														$bkground_image2 =  $image['p_img_large'][0];
														if($temp==6){
														}else{
														}
														if($temp>6){	
															$sstyle='display:none;padding:'.$padding;
														}else{
															$sstyle='padding:'.$padding;
														}
														if(empty($link2[$temp2])){
															$link='';
														}else{
															$link=$link2[$temp2];
														}
														$temp2++;
					$output .='            	<div class="masonry-grid " style="'.$sstyle.'">
								                    <div class="hb-project">
								                    	<a href="'.$link.'">
								                      	<figure class="hb-galleryimg">
															<img src="'.$bkground_image2.'" alt="'.get_post_meta( $datg, '_wp_attachment_image_alt', true).'">';
													if($temp==6&&$countdata>6){		
														$deldat=$countdata-6;
					$output .='								<figcaption class="hb-gallerycontent">
																<span style="font-size: 30px;">+'.$deldat.'</span>
															</figcaption>';
													}		
					$output .='							</figure>
														</a>
					                       			</div>
							                  </div>';
							                  	 $temp++;
							             }  }     	
				$output .='			       </div>
										</div>
									</div>
								</div>
							</div>
						</section>';
	 		}else{
	 				$output .='<section id="hb-gallery" class="hb-gallery v2 hb-sectionspace hb-haslayout">
							<div class="container">
								<div class="row">
									<div class=" col-xs-12 col-sm-12">
										<div class="hb-sectionhead ">
											<div class="hb-sectiontitle">
												<h3><i class="fa '.$gall_class.'" style="color:'.$icon_color.';"></i>
													'.$galelement_heading.'
												</h3>
											</div>
										</div>
									</div>
									<div class=" col-xs-12">
										<div class="hb-gallery-area">
								            <div id="filter-masonry" class="hb-portfolio-content hb-haslayout">';
								            $countdata=count($explodebk);
								            $temp=1;
								            if(!empty($explodebk)){
								            	foreach ($explodebk as $datg) {
								            			$image = wpb_getImageBySize( array( 'attach_id' => $datg, 'thumb_size' => '100', 'class' => 'vc_single_image-img' ) );
														$bkground_image2 =  $image['p_img_large'][0];
														if($temp>6){	
															$sstyle='display:none;padding:'.$padding;
														}else{
															$sstyle='padding:'.$padding;
														}
					$output .='            	<div class="masonry-grid " style="'.$sstyle.'">
								                    <div class="hb-project">
								                    	<a href="'.$bkground_image2.'" rel="prettyPhoto[gallery2]" title="'.get_post_meta( $datg, '_wp_attachment_image_alt', true).'">
								                      	<figure class="hb-galleryimg">
															<img src="'.$bkground_image2.'" alt="'.get_post_meta( $datg, '_wp_attachment_image_alt', true).'">';
													if($temp==6&&$countdata>6){		
														$deldat=$countdata-6;
					$output .='								<figcaption class="hb-gallerycontent">
																<span style="font-size: 30px;">+'.$deldat.'</span>
															</figcaption>';
													}		
					$output .='							</figure>
														</a>
					                       			</div>
							                  </div>';
							                  	 $temp++;
							             }  }     	
				$output .='			       </div>
										</div>
									</div>
								</div>
							</div>
						</section>';
	 		}
        	return $output;
		} /* end of function */
	}
	new fb_gallery;
	if(class_exists('WPBakeryShortCode')){
		class WPBakeryShortCode_fb_gallery extends WPBakeryShortCode {}
	}
}