<?php

if ( !defined( 'TBAY_ELEMENTOR_ACTIVED' ) ) return;

//convert hex to rgb
if ( !function_exists ('diza_tbay_getbowtied_hex2rgb') ) {
	function diza_tbay_getbowtied_hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);
		
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		return implode(",", $rgb); // returns the rgb values separated by commas
		//return $rgb; // returns an array with the rgb values
	}
}


if ( !function_exists ('diza_tbay_color_lightens_darkens') ) {
	/**
	 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.7
	 * @param str $hex Colour as hexadecimal (with or without hash);
	 * @percent float $percent Decimal ( 0.2 = lighten by 20%(), -0.4 = darken by 40%() )
	 * @return str Lightened/Darkend colour as hexadecimal (with hash);
	 */
	function diza_tbay_color_lightens_darkens( $hex, $percent ) {
		
		// validate hex string
		
		$hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
		$new_hex = '#';
		
		if ( strlen( $hex ) < 6 ) {
			$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
		}
		
		// convert to decimal and change luminosity
		for ($i = 0; $i < 3; $i++) {
			$dec = hexdec( substr( $hex, $i*2, 2 ) );
			$dec = min( max( 0, $dec + $dec * $percent ), 255 ); 
			$new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
		}		
		
		return $new_hex;
	}
}

if ( !function_exists ('diza_tbay_default_theme_primary_color') ) {
	function diza_tbay_default_theme_primary_color() {
		$active_theme = diza_tbay_get_theme();

		$theme_variable = array();

		switch ($active_theme) {
			case 'protective':
				$theme_variable['main_color'] 			= '#075cc9';
				$theme_variable['main_color_second'] 	= '#52d5e6';
				break;
			case 'medicine':
				$theme_variable['main_color'] 			= '#ff9d30';
				break;
			case 'care':
				$theme_variable['main_color'] 			= '#9bc33b';
				break;
		}

		return apply_filters( 'diza_get_default_theme_color', $theme_variable);
	}
}

if ( !function_exists ('diza_tbay_custom_styles') ) {
	function diza_tbay_custom_styles() {
		global $reduxConfig;	

		$output 		= $reduxConfig->output;
		$default_color 	= diza_tbay_default_theme_primary_color();

		$enable_second = ( isset($default_color['main_color_second']) && !empty($default_color['main_color_second']) ) ? true : false;

		$main_color  		= $main_bg_color =  $main_border_color  = diza_tbay_get_config('main_color');
		$main_color_2    	= diza_tbay_get_config('main_color_second');

		$skin = diza_tbay_get_theme();

		$logo_img_width        		= diza_tbay_get_config( 'logo_img_width' );
		$logo_padding        		= diza_tbay_get_config( 'logo_padding' );	

		$logo_img_width_mobile 		= diza_tbay_get_config( 'logo_img_width_mobile' );
		$logo_mobile_padding 		= diza_tbay_get_config( 'logo_mobile_padding' );

		$container_max_width 		= diza_tbay_get_config( 'container_max_width' );
		$container_margin 			= diza_tbay_get_config( 'container_margin' );

		$custom_css 			= diza_tbay_get_config( 'custom_css' );
		$css_desktop 			= diza_tbay_get_config( 'css_desktop' );
		$css_tablet 			= diza_tbay_get_config( 'css_tablet' );
		$css_wide_mobile 		= diza_tbay_get_config( 'css_wide_mobile' );
		$css_mobile         	= diza_tbay_get_config( 'css_mobile' );

		$show_typography        = (bool) diza_tbay_get_config( 'show_typography', false );

		$bg_buy_now 		  = diza_tbay_get_config( 'bg_buy_now' );

		ob_start();	
		?>
		
		/* Theme Options Styles */
		
		<?php if( $show_typography ) : ?>	
			/* Typography */
			/* Main Font */
			<?php
				$font_source = diza_tbay_get_config('font_source');
				$main_font = diza_tbay_get_config('main_font');
				$main_font = isset($main_font['font-family']) ? $main_font['font-family'] : false;
				$main_google_font_face = diza_tbay_get_config('main_google_font_face');
				$main_custom_font_face = diza_tbay_get_config('main_custom_font_face');


				$primary_font 	= $output['primary-font'];
			?>
			<?php if ( ($font_source == "2" && $main_google_font_face) || ($font_source == "3" && $main_custom_font_face) ): ?>
				<?php echo trim($primary_font); ?> {
				{font-family: 
					<?php 
						switch ($font_source) {
							case '3':
								echo trim($main_custom_font_face);
								break;								
							case '2':
								echo trim($main_google_font_face);
								break;							
							
							default:
								echo trim($main_google_font_face);
								break;
						}
					?>
				}
			<?php endif; ?>
			/* Second Font */
			<?php
				$secondary_font = diza_tbay_get_config('secondary_font');
				$secondary_font = isset($secondary_font['font-family']) ? $secondary_font['font-family'] : false;
				$secondary_google_font_face = diza_tbay_get_config('secondary_google_font_face');
				$secondary_custom_font_face = diza_tbay_get_config('secondary_custom_font_face');

				$secondary_font = $output['secondary-font'];
			?>
			<?php if ( ($font_source == "2" && $secondary_google_font_face)  || ($font_source == "3" && $secondary_custom_font_face) ): ?>
				<?php echo trim($secondary_font); ?> {
				{font-family:  
					<?php 
						switch ($font_source) {
							case '3':
								echo trim($secondary_custom_font_face);
								break;								
							case '2':
								echo trim($secondary_google_font_face);
								break;							
							
							default:
								echo trim($secondary_google_font_face);
								break;
						}
					?>
				}		
			<?php endif; ?>

		<?php endif; ?>


			/* Custom Color (skin) */ 


			/* check main color */ 
			<?php if ( $main_color != "" ) : ?>

				/*background*/
				<?php if( isset($output['background_hover']) && !empty($output['background_hover']) ) : ?>
				<?php echo trim($output['background_hover']); ?> {
					background: <?php echo esc_html( diza_tbay_color_lightens_darkens( $main_bg_color, -0.1) ); ?>;
				}
				<?php endif; ?>

				<?php if ( $skin !== 'protective') : ?>
					/*Color*/
					<?php if( isset($output['main_color_second']['color']) && !empty($output['main_color_second']['color']) ) : ?>
					<?php echo trim($output['main_color_second']['color']); ?> {
						color: <?php echo esc_html( $main_bg_color ); ?>;
					}
					<?php endif; ?>
					
					/*Background*/
					<?php if( isset($output['main_color_second']['background-color']) && !empty($output['main_color_second']['background-color']) ) : ?>
					<?php echo trim($output['main_color_second']['background-color']); ?> {
						background: <?php echo esc_html( diza_tbay_color_lightens_darkens( $main_bg_color, -0.13) ); ?>;
					}
					<?php endif; ?>

					/*Border Color*/
					<?php if( isset($output['main_color_second']['border-color']) && !empty($output['main_color_second']['border-color']) ) : ?>
					<?php echo trim($output['main_color_second']['border-color']); ?> {
						border-color: <?php echo esc_html( diza_tbay_color_lightens_darkens( $main_bg_color, -0.13) ); ?>;
					}
					<?php endif; ?>

					/*Border Top Color*/
					<?php if( isset($output['main_color_second']['border-top-color']) && !empty($output['main_color_second']['border-top-color']) ) : ?>
					<?php echo trim($output['main_color_second']['border-top-color']); ?> {
						border-top-color: <?php echo esc_html( diza_tbay_color_lightens_darkens( $main_bg_color, -0.13) ); ?>;
					}
					<?php endif; ?>

					/*Border Bottom Color*/
					<?php if( isset($output['main_color_second']['border-bottom-color']) && !empty($output['main_color_second']['border-bottom-color']) ) : ?>
					<?php echo trim($output['main_color_second']['border-bottom-color']); ?> {
						border-bottom-color: <?php echo esc_html( diza_tbay_color_lightens_darkens( $main_bg_color, -0.13) ); ?>;
					}
					<?php endif; ?>

					/*Border Left Color*/
					<?php if( isset($output['main_color_second']['border-left-color']) && !empty($output['main_color_second']['border-left-color']) ) : ?>
					<?php echo trim($output['main_color_second']['border-left-color']); ?> {
						border-left-color: <?php echo esc_html( diza_tbay_color_lightens_darkens( $main_bg_color, -0.13) ); ?>;
					}
					<?php endif; ?>

					/*Border Right Color*/
					<?php if( isset($output['main_color_second']['border-right-color']) && !empty($output['main_color_second']['border-right-color']) ) : ?>
					<?php echo trim($output['main_color_second']['border-right-color']); ?> {
						border-right-color: <?php echo esc_html( diza_tbay_color_lightens_darkens( $main_bg_color, -0.13) ); ?>;
					}
					<?php endif; ?>

				<?php endif; ?>

			<?php endif; ?> 

			<?php if( !empty($bg_buy_now) ) : ?>
				.has-buy-now .tbay-buy-now.button, .has-buy-now .tbay-buy-now.button.disabled,
				.mobile-btn-cart-click #tbay-click-buy-now {
					background-color: <?php echo esc_html( $bg_buy_now ) ?> !important;
				}
				  
			<?php endif; ?>
			
			/* check main color second */ 
			<?php if ( $enable_second && $main_color_2 != "" ) : ?>
				/*background*/
				<?php if( isset($output['main_color_second']['color']) && !empty($output['main_color_second']['color']) ) : ?>
					<?php echo trim($output['main_color_second']['color']); ?> {
					color: <?php echo esc_html( $main_color_2 ) ?>;
				}
				<?php endif; ?>

				<?php if( isset($output['main_color_second']['background-color']) && !empty($output['main_color_second']['background-color']) ) : ?>
					<?php echo trim($output['main_color_second']['background-color']); ?> {
					background: <?php echo esc_html( $main_color_2 ) ?>;
				}
				<?php endif; ?>

				<?php if( isset($output['main_color_second']['border-color']) && !empty($output['main_color_second']['border-color']) ) : ?>
					<?php echo trim($output['main_color_second']['border-color']); ?> {
					border-color: <?php echo esc_html( $main_color_2 ) ?>;
				}  
				<?php endif; ?>

			<?php endif; ?>

			<?php if ( $logo_img_width != "" ) : ?>
			.site-header .logo img {
	            max-width: <?php echo esc_html( $logo_img_width ); ?>px;
	        } 
	        <?php endif; ?>

	        <?php if ( $logo_padding != "" ) : ?>
	        .site-header .logo img {

	            <?php if( !empty($logo_padding['padding-top'] ) ) : ?>
					padding-top: <?php echo esc_html( $logo_padding['padding-top'] ); ?>;
	        	<?php endif; ?>

	        	<?php if( !empty($logo_padding['padding-right'] ) ) : ?>
					padding-right: <?php echo esc_html( $logo_padding['padding-right'] ); ?>;
	        	<?php endif; ?>
	        	
	        	<?php if( !empty($logo_padding['padding-bottom'] ) ) : ?>
					padding-bottom: <?php echo esc_html( $logo_padding['padding-bottom'] ); ?>;
	        	<?php endif; ?>

	        	<?php if( !empty($logo_padding['padding-left'] ) ) : ?>
					 padding-left: <?php echo esc_html( $logo_padding['padding-left'] ); ?>;
	        	<?php endif; ?>

	        }
			<?php endif; ?> 
			<?php if (  diza_body_box_shadow() ) : ?>
			<?php
				$screen = 1200;

				$container_max_width = (float)$container_max_width;
				if ($container_max_width > $screen) {
					$screen =  $container_max_width + 100;
				}
			?>
			@media (min-width: <?php echo trim($screen) ?>px) {
				<?php if( $container_max_width != "" ) : ?> 
				#wrapper-container {
					max-width: <?php echo trim( $container_max_width ); ?>px;
				}   

				<?php endif; ?>       

				<?php if ( $container_margin != "" ) : ?>
					#wrapper-container {
						<?php if( !empty($container_margin['margin-top'] ) ) : ?>
							margin-top: <?php echo esc_html( $container_margin['margin-top'] ); ?>;
						<?php endif; ?>

						<?php if( !empty($container_margin['margin-right'] ) ) : ?>
							margin-right: <?php echo esc_html( $container_margin['margin-right'] ); ?>;
						<?php endif; ?>

						<?php if( !empty($container_margin['margin-bottom'] ) ) : ?>
							margin-bottom: <?php echo esc_html( $container_margin['margin-bottom'] ); ?>;
						<?php endif; ?>

						<?php if( !empty($container_margin['margin-left'] ) ) : ?>
							margin-left: <?php echo esc_html( $container_margin['margin-left'] ); ?>;
						<?php endif; ?>
					
					}
				<?php endif; ?>
			}


			<?php endif; ?>


	        <?php if ( $main_color != "" ) : ?>

        	/*Tablet*/
	        @media (max-width: 1199px)  and (min-width: 768px) {
				/*color*/
				<?php if( isset($output['tablet_color']) && !empty($output['tablet_color']) ) : ?>
					<?php echo trim($output['tablet_color']); ?> {
						color: <?php echo esc_html( $main_color ) ?>;
					}
				<?php endif; ?>


				/*background*/
				<?php if( isset($output['tablet_background']) && !empty($output['tablet_background']) ) : ?>
					<?php echo trim($output['tablet_background']); ?> {
						background-color: <?php echo esc_html( $main_bg_color ) ?>;
					}
				<?php endif; ?>

				/*Border*/
				<?php if( isset($output['tablet_border']) && !empty($output['tablet_border']) ) : ?>
				<?php echo trim($output['tablet_border']); ?> {
					border-color: <?php echo esc_html( $main_border_color ) ?>;
				}
				<?php endif; ?>

				<!-- color 2 -->
				<?php if ( $skin !== 'protective') : ?>
					/*Color*/
					<?php if( isset($output['tablet_second']['color']) && !empty($output['tablet_second']['color']) ) : ?>
					<?php echo trim($output['tablet_second']['color']); ?> {
						color: <?php echo esc_html( $main_bg_color ); ?>;
					}
					<?php endif; ?>
					
					/*Background*/
					<?php if( isset($output['tablet_second']['background-color']) && !empty($output['tablet_second']['background-color']) ) : ?>
					<?php echo trim($output['tablet_second']['background-color']); ?> {
						background: <?php echo esc_html( $main_bg_color ); ?>;
					}
					<?php endif; ?>

					/*Border Color*/
					<?php if( isset($output['tablet_second']['border-color']) && !empty($output['tablet_second']['border-color']) ) : ?>
					<?php echo trim($output['tablet_second']['border-color']); ?> {
						border-color: <?php echo esc_html( $main_bg_color ); ?>;
					}
					<?php endif; ?>

				<?php else: ?>

					<?php if ( $enable_second && $main_color_2 != "" ) : ?>
						/*Color*/
						<?php if( isset($output['tablet_second']['color']) && !empty($output['tablet_second']['color']) ) : ?>
						<?php echo trim($output['tablet_second']['color']); ?> {
							color: <?php echo esc_html( $main_color_2 ); ?>;
						}
						<?php endif; ?>
						
						/*Background*/
						<?php if( isset($output['tablet_second']['background-color']) && !empty($output['tablet_second']['background-color']) ) : ?>
						<?php echo trim($output['tablet_second']['background-color']); ?> {
							background: <?php echo esc_html( $main_color_2 ); ?>;
						}
						<?php endif; ?>

						/*Border Color*/
						<?php if( isset($output['tablet_second']['border-color']) && !empty($output['tablet_second']['border-color']) ) : ?>
						<?php echo trim($output['tablet_second']['border-color']); ?> {
							border-color: <?php echo esc_html( $main_color_2 ); ?>;
						}
						<?php endif; ?>
					<?php endif; ?>

				<?php endif; ?>
		    }

		    /*Mobile*/
		    @media (max-width: 767px) {
				/*color*/
				<?php if( isset($output['mobile_color']) && !empty($output['mobile_color']) ) : ?>
					<?php echo trim($output['mobile_color']); ?> {
						color: <?php echo esc_html( $main_color ) ?>;
					}
				<?php endif; ?>

				/*background*/
				<?php if( isset($output['mobile_background']) && !empty($output['mobile_background']) ) : ?>
					<?php echo trim($output['mobile_background']); ?> {
						background-color: <?php echo esc_html( $main_bg_color ) ?>;
					}
				<?php endif; ?>

				/*Border*/
				<?php if( isset($output['mobile_border']) && !empty($output['mobile_border']) ) : ?>
				<?php echo trim($output['mobile_border']); ?> {
					border-color: <?php echo esc_html( $main_border_color ) ?>;
				}
				<?php endif; ?>

				
				<!-- color 2 -->
				<?php if ( $skin !== 'protective') : ?>
					/*Color*/
					<?php if( isset($output['mobile_second']['color']) && !empty($output['mobile_second']['color']) ) : ?>
					<?php echo trim($output['mobile_second']['color']); ?> {
						color: <?php echo esc_html( $main_bg_color ); ?>;
					}
					<?php endif; ?>
					
					/*Background*/
					<?php if( isset($output['mobile_second']['background-color']) && !empty($output['mobile_second']['background-color']) ) : ?>
					<?php echo trim($output['mobile_second']['background-color']); ?> {
						background: <?php echo esc_html( $main_bg_color ); ?>;
					}
					<?php endif; ?>

					/*Border Color*/
					<?php if( isset($output['mobile_second']['border-color']) && !empty($output['mobile_second']['border-color']) ) : ?>
					<?php echo trim($output['mobile_second']['border-color']); ?> {
						border-color: <?php echo esc_html( $main_bg_color ); ?>;
					}
					<?php endif; ?>

				<?php else: ?>

					<?php if ( $enable_second && $main_color_2 != "" ) : ?>
						/*Color*/
						<?php if( isset($output['mobile_second']['color']) && !empty($output['mobile_second']['color']) ) : ?>
						<?php echo trim($output['mobile_second']['color']); ?> {
							color: <?php echo esc_html( $main_color_2 ); ?>;
						}
						<?php endif; ?>
						
						/*Background*/
						<?php if( isset($output['mobile_second']['background-color']) && !empty($output['mobile_second']['background-color']) ) : ?>
						<?php echo trim($output['mobile_second']['background-color']); ?> {
							background: <?php echo esc_html( $main_color_2 ); ?>;
						}
						<?php endif; ?>

						/*Border Color*/
						<?php if( isset($output['mobile_second']['border-color']) && !empty($output['mobile_second']['border-color']) ) : ?>
						<?php echo trim($output['mobile_second']['border-color']); ?> {
							border-color: <?php echo esc_html( $main_color_2 ); ?>;
						}
						<?php endif; ?>
					<?php endif; ?>

				<?php endif; ?>
		    }

		    /*No edit code customize*/	
		    @media (max-width: 1199px)  and (min-width: 768px) {	       
		    	/*color*/
				.footer-device-mobile > * a:hover,.footer-device-mobile > *.active a,.footer-device-mobile > *.active a i , body.woocommerce-wishlist .footer-device-mobile > .device-wishlist a,body.woocommerce-wishlist .footer-device-mobile > .device-wishlist a i,.vc_tta-container .vc_tta-panel.vc_active .vc_tta-panel-title > a span,.cart_totals table .order-total .woocs_special_price_code {
					color: <?php echo esc_html( $main_color ) ?>;
				}

				/*background*/
				.topbar-device-mobile .top-cart a.wc-continue,.topbar-device-mobile .cart-dropdown .cart-icon .mini-cart-items,.footer-device-mobile > * a .mini-cart-items,.tbay-addon-newletter .input-group-btn input {
					background-color: <?php echo esc_html( $main_bg_color ) ?>;
				}

				/*Border*/
				.topbar-device-mobile .top-cart a.wc-continue {
					border-color: <?php echo esc_html( $main_border_color ) ?>;
				}
			}


		   <?php endif; ?>

	        @media (max-width: 1199px) {

	        	<?php if ( $logo_img_width_mobile != "" ) : ?>
	            /* Limit logo image height for mobile according to mobile header height */
	            .mobile-logo a img {
	               	max-width: <?php echo esc_html( $logo_img_width_mobile ); ?>px;
	            }     
	            <?php endif; ?>       

	            <?php if ( $logo_mobile_padding != "" ) : ?>
	            .mobile-logo a img {

		            <?php if( !empty($logo_mobile_padding['padding-top'] ) ) : ?>
						padding-top: <?php echo esc_html( $logo_mobile_padding['padding-top'] ); ?>;
		        	<?php endif; ?>

		        	<?php if( !empty($logo_mobile_padding['padding-right'] ) ) : ?>
						padding-right: <?php echo esc_html( $logo_mobile_padding['padding-right'] ); ?>;
		        	<?php endif; ?>

		        	<?php if( !empty($logo_mobile_padding['padding-bottom'] ) ) : ?>
						padding-bottom: <?php echo esc_html( $logo_mobile_padding['padding-bottom'] ); ?>;
		        	<?php endif; ?>

		        	<?php if( !empty($logo_mobile_padding['padding-left'] ) ) : ?>
						 padding-left: <?php echo esc_html( $logo_mobile_padding['padding-left'] ); ?>;
		        	<?php endif; ?>
		           
	            }
	            <?php endif; ?>
			}

			@media screen and (max-width: 782px) {
				html body.admin-bar{
					top: -46px !important;
					position: relative;
				}
			}

			/* Custom CSS */
	        <?php 
	        if( $custom_css != '' ) {
	            echo trim($custom_css);
	        }
	        if( $css_desktop != '' ) {
	            echo '@media (min-width: 1024px) { ' . ($css_desktop) . ' }'; 
	        }
	        if( $css_tablet != '' ) {
	            echo '@media (min-width: 768px) and (max-width: 1023px) {' . ($css_tablet) . ' }'; 
	        }
	        if( $css_wide_mobile != '' ) {
	            echo '@media (min-width: 481px) and (max-width: 767px) { ' . ($css_wide_mobile) . ' }'; 
	        }
	        if( $css_mobile != '' ) {
	            echo '@media (max-width: 480px) { ' . ($css_mobile) . ' }'; 
	        }
	        ?>


	<?php
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) {
			if (!empty($line)) {
				$new_lines[] = trim($line);
			} 
		}

		$custom_css = implode($new_lines);

		wp_enqueue_style( 'diza-style', DIZA_THEME_DIR . '/style.css', array(), '1.0' );

		wp_add_inline_style( 'diza-style', $custom_css );

		if( class_exists( 'WooCommerce' ) && class_exists( 'YITH_Woocompare' ) ) {
			wp_add_inline_style( 'diza-woocommerce', $custom_css );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'diza_tbay_custom_styles', 2000 ); 