<?php

if ( ! function_exists( 'diza_tbay_category' ) ) {
	function diza_tbay_category( $post ) {
		// format
		$post_format = get_post_format();
		$header_class = $post_format ? '' : 'border-left';
		echo '<span class="category "> ';
		$cat = wp_get_post_categories( $post->ID );
		$k   = count( $cat );
		foreach ( $cat as $c ) {
			$categories = get_category( $c );
			$k -= 1;
			if ( $k == 0 ) {
				echo '<a href="' . esc_url( get_category_link( $categories->term_id ) ) . '" class="categories-name"><i class="fa fa-bar-chart"></i>' . esc_html($categories->name) . '</a>';
			} else {
				echo '<a href="' . esc_url( get_category_link( $categories->term_id ) ) . '" class="categories-name"><i class="fa fa-bar-chart"></i>' . esc_html($categories->name) . ', </a>';
			}
		}
		echo '</span>';
	}
}

if ( ! function_exists( 'diza_tbay_center_meta' ) ) {
	function diza_tbay_center_meta( $post ) {
		// format
		$post_format = get_post_format();
		$id = get_the_author_meta( 'ID' );
		echo '<div class="entry-meta">';
			the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );

			echo "<div class='entry-create'>";
			echo "<span class='entry-date'>". get_the_date( 'M d, Y' ).'</span>';
			"<span class='author'>". esc_html_e('/ By ', 'diza'); the_author_posts_link() .'</span>';
			echo '</div>';
		echo '</div>';
	}
}



if ( ! function_exists( 'diza_tbay_full_top_meta' ) ) {
	function diza_tbay_full_top_meta( $post ) {
		// format
		$post_format = get_post_format();
		$header_class = $post_format ? '' : 'border-left';
		echo '<header class="entry-header-top ' . esc_attr($header_class) . '">';
		if(!is_single()){
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		// details
		$id = get_the_author_meta( 'ID' );
		echo '<span class="entry-profile"><span class="col"><span class="entry-author-link"><strong>' . esc_html__( 'By:', 'diza' ) . '</strong><span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url( $id )) . '" rel="author">' . get_the_author() . '</a></span></span><span class="entry-date"><strong>'. esc_html__('Posted: ', 'diza') .'</strong>' . esc_html( get_the_date( 'M jS, Y' ) ) . '</span></span></span>';
		// comments
		echo '<span class="entry-categories"><strong>'. esc_html__('In:', 'diza') .'</strong> ';
		$cat = wp_get_post_categories( $post->ID );
		$k   = count( $cat );
		foreach ( $cat as $c ) {
			$categories = get_category( $c );
			$k -= 1;
			if ( $k == 0 ) {
				echo '<a href="' . esc_url( get_category_link( $categories->term_id ) ) . '" class="categories-name">' . esc_html($categories->name) . '</a>';
			} else {
				echo '<a href="' . esc_url( get_category_link( $categories->term_id ) ) . '" class="categories-name">' . esc_html($categories->name) . ', </a>';
			}
		}
		echo '</span>';
		if ( ! is_search() ) {
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				echo '<span class="entry-comments-link">';
				comments_popup_link( '0', '1', '%' );
				echo '</span>';
			}
		}
		echo '</header>';
	}
}

if ( ! function_exists( 'diza_tbay_post_tags' ) ) {
	function diza_tbay_post_tags() {
		$posttags = get_the_tags();
		if ( $posttags ) {
			echo '<div class="tagcloud"><span class="meta-title">'.esc_html__('Tags: ', 'diza').'</span>';

			$size = count( $posttags );
			$space = '';
			$i = 0;
			foreach ( $posttags as $tag ) {

				echo '<a href="' . get_tag_link( $tag->term_id ) . '">';
				if(++$i === $size ) $space ='';
				echo trim($tag->name).$space;
				echo '</a>';
			}
			echo '</div>';
		}
	}
}
if ( ! function_exists( 'diza_tbay_post_wrapper_share_tags' ) ) {
	function diza_tbay_post_wrapper_share_tags() {

		if( !diza_tbay_get_config('enable_code_share',false) &&  !get_the_tags() ) return;

		echo '<div class="wrapper-share-tags">';
		diza_tbay_post_tags();
		diza_tbay_post_share_box();
		echo '</div>';
	}
	add_action('diza_tbay_post_bottom','diza_tbay_post_wrapper_share_tags', 10);
}
if ( ! function_exists( 'diza_tbay_post_info_author' ) ) {
	function diza_tbay_post_info_author() {
		$author_id = diza_tbay_get_id_author_post();

		if( defined('TBAY_ELEMENTOR_ACTIVED') && TBAY_ELEMENTOR_ACTIVED ) {
		?>
		<div class="author-info">
			<div class="avarta">
				<?php echo get_avatar($author_id, 90); ?>
			</div>
			<div class="content">
				<h4 class="name"><?php echo get_the_author(); ?></h4>
				<p><?php the_author_meta( 'description', $author_id ) ?></p>
				<a href="<?php echo get_author_posts_url($author_id); ?>" class="all-post"><?php esc_html_e('See all author post ', 'diza'); ?><i class="tb-icon tb-icon-chevron-right"></i></a>
			</div>
		</div>
		<?php }
	}
	add_action('diza_tbay_post_bottom','diza_tbay_post_info_author', 20);
}

if ( ! function_exists( 'diza_tbay_post_share_box' ) ) {
  function diza_tbay_post_share_box() {
  		if( !diza_tbay_get_config('enable_code_share',false) ) return;

  		if( diza_tbay_get_config('select_share_type') == 'custom' ) {
			$image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
			diza_custom_share_code( get_the_title(), get_permalink(), $image );
  		} else {
  			?>
  			 <div class="tbay-post-share">
              	<div class="addthis_inline_share_toolbox"></div>
            </div>
  			<?php
  		}

  }
}

if ( ! function_exists( 'diza_tbay_post_format_link_helper' ) ) {
	function diza_tbay_post_format_link_helper( $content = null, $title = null, $post = null ) {
		if ( ! $content ) {
			$post = get_post( $post );
			$title = $post->post_title;
			$content = $post->post_content;
		}
		$link = diza_tbay_get_first_url_from_string( $content );
		if ( ! empty( $link ) ) {
			$title = '<a href="' . esc_url( $link ) . '" rel="bookmark">' . $title . '</a>';
			$content = str_replace( $link, '', $content );
		} else {
			$pattern = '/^\<a[^>](.*?)>(.*?)<\/a>/i';
			preg_match( $pattern, $content, $link );
			if ( ! empty( $link[0] ) && ! empty( $link[2] ) ) {
				$title = $link[0];
				$content = str_replace( $link[0], '', $content );
			} elseif ( ! empty( $link[0] ) && ! empty( $link[1] ) ) {
				$atts = shortcode_parse_atts( $link[1] );
				$target = ( ! empty( $atts['target'] ) ) ? $atts['target'] : '_self';
				$title = ( ! empty( $atts['title'] ) ) ? $atts['title'] : $title;
				$title = '<a href="' . esc_url( $atts['href'] ) . '" rel="bookmark" target="' . $target . '">' . $title . '</a>';
				$content = str_replace( $link[0], '', $content );
			} else {
				$title = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $title . '</a>';
			}
		}
		$out['title'] = '<h2 class="entry-title">' . $title . '</h2>';
		$out['content'] = $content;

		return $out;
	}
}


if ( ! function_exists( 'diza_tbay_breadcrumbs' ) ) {
	function diza_tbay_breadcrumbs() {

		$delimiter = ' / ';
		$home = esc_html__('Home', 'diza');
		$before = '<li class="active">';
		$after = '</li>';
		$title = '';
		if (!is_home() && !is_front_page() || is_paged()) {

			echo '<ol class="breadcrumb">';

			global $post;
			$homeLink = esc_url( home_url() );
			echo '<li><a href="' . esc_url($homeLink) . '" class="active">' . esc_html($home) . '</a> ' . esc_html($delimiter) . '</li> ';

			if (is_category()) {

				global $wp_query;
				$cat_obj = $wp_query->get_queried_object();
				$thisCat = $cat_obj->term_id;
				$thisCat = get_category($thisCat);
				$parentCat = get_category($thisCat->parent);
				if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
				echo trim($before) . esc_html__('blog', 'diza') . $after;

			} elseif (is_day()) {

				echo '<li><a href="' . esc_url( get_year_link(get_the_time('Y')) ) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter) . ' ';
				echo '<li><a href="' . esc_url( get_month_link(get_the_time('Y'),get_the_time('m')) ) . '">' . get_the_time('F') . '</a></li> ' . esc_html($delimiter) . ' ';
				echo trim($before) . get_the_time('d') . $after;

			} elseif (is_month()) {

				echo '<li><a href="' . esc_url( get_year_link(get_the_time('Y')) ) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter) . ' ';
				echo trim($before) . get_the_time('F') . $after;

			} elseif (is_year()) {

				echo trim($before) . get_the_time('Y') . $after;

			} elseif ( is_single()  && !is_attachment()) {
				if ( get_post_type() != 'post' ) {
					$delimiter = '';
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					echo '<li><a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . esc_html($post_type->labels->singular_name) . '</a></li> ' . esc_html($delimiter) . ' ';
				} else {
					$delimiter = '';
					$cat = get_the_category(); $cat = $cat[0];
					echo '<li>'.get_category_parents($cat, TRUE, ' ' . $delimiter . ' ').'</li>';
				}

			} elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {

				$post_type = get_post_type_object(get_post_type());
				if (is_object($post_type)) {
					echo trim($before) . esc_html($post_type->labels->singular_name) . $after;
				}

			}  elseif (is_attachment()) {

				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID);
				if( isset($cat) && !empty($cat) ) {
				 $cat = $cat[0];
				 echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				}
				echo '<li><a href="' . esc_url( get_permalink($parent->ID) ) . '">' . esc_html($parent->post_title) . '</a></li> ' . esc_html($delimiter) . ' ';
				echo trim($before) . get_the_title() . $after;

			} elseif ( is_page() && !$post->post_parent ) {

				echo trim($before) . esc_html__('Page','diza') . $after;

			} elseif ( is_page() && $post->post_parent ) {

				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = '<li><a href="' . esc_url( get_permalink($page->ID) ) . '">' . get_the_title($page->ID) . '</a></li>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				foreach ($breadcrumbs as $crumb) echo trim($crumb) . ' ' . $delimiter . ' ';
				echo trim($before) . esc_html__('Page','diza') . $after;

			} elseif ( is_search() ) {

				echo trim($before) . esc_html__('Search','diza') . $after;

			} elseif ( is_tag() ) {

				echo trim($before) . esc_html__('Tags', 'diza') . $after;

			} elseif ( is_author() ) {

				global $author;
				$userdata = get_userdata($author);
				echo trim($before) . esc_html__('Author', 'diza'). $after;

			} elseif ( is_404() ) {

				echo trim($before) . esc_html__('Error 404', 'diza') . $after;

			}

			echo '</ol>';
		}
	}
}

if ( ! function_exists( 'diza_tbay_render_breadcrumbs' ) ) {
	function diza_tbay_render_breadcrumbs() {
		global $post;
		$show = true;
		$img = '';
		$style = array();

		if(  diza_tbay_is_home_page() || is_attachment() ) return;

    $sidebar_configs = diza_tbay_get_blog_layout_configs();


    $breadcrumbs_layout = diza_tbay_get_config('blog_breadcrumb_layout', 'color');

    if(isset($post->ID) && !empty(get_post_meta( $post->ID, 'tbay_page_breadcrumbs_layout', 'color' )) ) {
    	$breadcrumbs_layout = get_post_meta( $post->ID, 'tbay_page_breadcrumbs_layout', 'color' );
    }

    if( isset($_GET['breadcrumbs_layout']) ) {
         $breadcrumbs_layout = $_GET['breadcrumbs_layout'];
    }

    $class_container = '';
    if( isset($sidebar_configs['container_full']) &&  $sidebar_configs['container_full'] ) {
        $class_container = 'container-full';
    }

    switch ($breadcrumbs_layout) {
        case 'image':
            $breadcrumbs_class = ' breadcrumbs-image';
            break;
        case 'color':
            $breadcrumbs_class = ' breadcrumbs-color';
            break;
        case 'text':
            $breadcrumbs_class = ' breadcrumbs-text';
            break;
        default:
            $breadcrumbs_class  = ' breadcrumbs-image';
    }

    if(isset($sidebar_configs['breadscrumb_class'])) {
        $breadcrumbs_class .= ' '.$sidebar_configs['breadscrumb_class'];
    }
	if ( is_page() && is_object($post) ) {

		$show = get_post_meta( $post->ID, 'tbay_page_show_breadcrumb', 'no' );

		if ( isset($show) && $show != 'yes' ) {
			return '';
		}


		$bgimage = get_post_meta( $post->ID, 'tbay_page_breadcrumb_image', true );
		$bgcolor = get_post_meta( $post->ID, 'tbay_page_breadcrumb_color', true );
		$style = array();
		if( $bgcolor && $breadcrumbs_layout !=='image' && $breadcrumbs_layout !=='text' ){
			$style[] = 'background-color:'.$bgcolor;
		}
		if( $bgimage  && $breadcrumbs_layout !=='color' && $breadcrumbs_layout !=='text'  ){
			$img = ' <img src="'.esc_url($bgimage).'" alt="'.get_the_title($post->ID) .'">';
		}

	} elseif (is_singular('post') || is_category() || is_home() || is_tag() || is_author() || is_day() || is_month() || is_year()  || is_search()) {

		$show = diza_tbay_get_config('show_blog_breadcrumb', false);

		if ( !$show  ) {
			return '';
		}
		$breadcrumb_img = diza_tbay_get_config('blog_breadcrumb_image');

    	$breadcrumb_color = diza_tbay_get_config('blog_breadcrumb_color');

	     $style = array();
	     if( $breadcrumb_color && $breadcrumbs_layout !=='image' && $breadcrumbs_layout !=='text'   ){
	        $style[] = 'background-color:'.$breadcrumb_color;
	     }
		if ( isset($breadcrumb_img['url']) && !empty($breadcrumb_img['url']) && $breadcrumbs_layout !=='color' && $breadcrumbs_layout !=='text' ) {
			$img_id = $breadcrumb_img['id'];
            $img    = wp_get_attachment_image($img_id, 'full');
      	}
	}

	$title = $nav = '';


    if( is_category() ) {

        $title = '<h1 class="page-title">'. single_cat_title('', false) .'</h1>';

    } else if ( is_tag() ) {

    	$title = '<h1 class="page-title">'. esc_html__('Posts tagged "', 'diza'). single_tag_title('', false) . '"</h1>';

    } else if ( is_day() ) {

    	$title = '<h1 class="page-title">'. get_the_time('d') . '</h1>';

    } else if ( is_month() ) {

    	$title = '<h1 class="page-title">'. get_the_time('F') . '</h1>';

    } else if ( is_year() ) {

    	$title = '<h1 class="page-title">'. get_the_time('Y') . '</h1>';

    } else if ( is_search() ) {

		$title = '<h1 class="page-title">'. esc_html__('Search results for "','diza')  . get_search_query() . '"</h1>';

	} else if ( is_author() ) {
		global $author;
		$userdata = get_userdata($author);
		$title = '<h1 class="page-title">'. esc_html__('Articles posted by "', 'diza') . esc_html($userdata->display_name) . '"</h1>';

	} else if ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {

		$post_type = get_post_type_object(get_post_type());
		if (is_object($post_type)) {
			$title = '<h1 class="page-title">'. $post_type->labels->singular_name . '</h1>';
		}

	} else if ( ( is_page() && $post->post_parent ) || ( is_page() && !$post->post_parent ) || is_attachment() ) {

		$title 			= '<h1 class="page-title">'. get_the_title() . '</h1>';

	} else if( is_single() ) {
		$title 			= '<h1 class="page-title">'. esc_html__('Blog', 'diza') . '</h1>';
	}

	if ($breadcrumbs_layout !== 'image') {

		if( !diza_tbay_is_home_page() && diza_tbay_get_config('enable_previous_page_post', true) ) {
			$nav .= '<a href="javascript:history.back()" class="diza-back-btn"><i class="tb-icon tb-icon-arrow-left"></i><span class="text">'. esc_html__('Previous page', 'diza') .'</span></a>';
			$breadcrumbs_class .= ' active-nav-right';
		}
		if(!diza_tbay_is_home_page() && isset($post->ID) && !empty(get_the_title($post->ID) && is_page() ) ) {
			$title 				= '<h1 class="page-title">'. get_the_title($post->ID) .'</h1>';
			$breadcrumbs_class .= ' show-title';
		}
		if( is_category() || is_author() ) {
			$breadcrumbs_class .= ' show-title';
		}
		if ( is_archive() ) {
			$breadcrumbs_class .= ' blog';
		}
	}


	if ( class_exists( 'WooCommerce' ) && (is_edit_account_page() || is_add_payment_method_page() || is_lost_password_page() || is_account_page() || is_view_order_page()) ) {
		$breadcrumbs_class = trim(str_replace('show-title','',$breadcrumbs_class));
	}
	$estyle = !empty($style)? ' style="'.implode(";", $style).'"':"";


	echo '<section id="tbay-breadscrumb" '. trim($estyle).' class="tbay-breadscrumb '.esc_attr($breadcrumbs_class).'"><img width="3000px" src="/wp-content/uploads/shop_image/1.jpg"><div class="container"><div class="container"><div class="breadscrumb-inner" >' . $title;
		diza_tbay_breadcrumbs();
	echo ''. trim($nav) .'</div></div></section>';
	}
}

if ( ! function_exists( 'diza_tbay_render_title' ) ) {
	function diza_tbay_render_title() {
		global $post;

		if ( is_page() && is_object($post) ) {

			$show = get_post_meta( $post->ID, 'tbay_page_show_breadcrumb', 'no' );
			if ( !$show  ) {
                $title = get_the_title($post->ID);
                $class = "";
                if(strstr($title,"privacy policy")){
                    $title = esc_html__("Privacy Policy",'woocommerce');
                    $class = "-PrivacyPolicy";
                }else if(strstr($title,"cart")){
                    $title = esc_html__("Cart",'woocommerce');
                    $class = "-Cart";
                }else if(strstr($title,"checkout")){
                    $title = esc_html__("Checkout",'woocommerce');
                    $class = "-Checkout";
                }else if(strstr($title,"my-account")){
                    $title = esc_html__("My Account",'woocommerce');
                    $class = "-Account";
                }
				echo '<header class="entry-header"><h1 class="entry-title'. $class.'">'. $title.'</h1></header>';
			}
		}

	}
}

if ( ! function_exists( 'diza_tbay_paging_nav' ) ) {
	function diza_tbay_paging_nav() {
		global $wp_query, $wp_rewrite;

		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'     => $pagenum_link,
			'format'   => $format,
			'total'    => $wp_query->max_num_pages,
			'current'  => $paged,
			'mid_size' => 1,
			'add_args' => array_map( 'urlencode', $query_args ),
			'prev_text' => '<i class="tb-icon tb-icon-chevron-left"></i>',
			'next_text' => '<i class="tb-icon tb-icon-chevron-right"></i>'
		) );

		if ( $links ) :

		?>
		<nav class="navigation paging-navigation">
			<h1 class="screen-reader-text hidden"><?php esc_html_e( 'Posts navigation', 'woocommerce' ); ?></h1>
			<div class="tbay-pagination">
				<?php echo trim($links); ?>
			</div><!-- .pagination -->
		</nav><!-- .navigation -->
		<?php
		endif;

	}
}


if ( ! function_exists( 'diza_tbay_post_nav' ) ) {
	function diza_tbay_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		$prevPost = get_previous_post();
		$nextPost  = get_next_post();
		if (is_object($prevPost) ) {
			$prevthumbnail = get_the_post_thumbnail($prevPost->ID, 'diza_avatar_post_carousel' );
		}
		if (is_object($nextPost) ) {
			$nextthumbnail = get_the_post_thumbnail($nextPost->ID, 'diza_avatar_post_carousel');
		}
		?>
		<nav class="navigation post-navigation">
			<h3 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'woocommerce' ); ?></h3>
			<div class="nav-links clearfix">
				<?php
				if ( is_attachment() ) :
					previous_post_link( '%link','<div class="col-lg-6"><span class="meta-nav">'. esc_html__('Published In', 'diza').'</span></div>');
				else :
					if(isset($prevthumbnail) )
					previous_post_link( '%link','<div class="media">'. $prevthumbnail .'<div class="wrapper-title-meta media-body">'.'<span class="meta-nav">'. esc_html__('Previous', 'diza').'</span><span class="post-title">%title</span></div></div>' );
					if(isset($nextthumbnail) )
					next_post_link( '%link', '<div class="media">'. $nextthumbnail .'<div class="wrapper-title-meta media-body">'.'<span class="meta-nav">' . esc_html__('Next', 'diza').'</span><span></span><span class="post-title">%title</span></div></div>');
				endif;
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}

if ( !function_exists('diza_tbay_pagination') ) {
    function diza_tbay_pagination($per_page, $total, $max_num_pages = '') {
    	global $wp_query, $wp_rewrite;
        ?>
        <div class="tbay-pagination">
        	<?php
        	$prev = esc_html__('Previous','diza');
        	$next = esc_html__('Next','diza');
        	$pages = $max_num_pages;
        	$args = array('class'=>'pull-left');

        	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	        if ( empty($pages) ) {
	            global $wp_query;
	            $pages = $wp_query->max_num_pages;
	            if ( !$pages ) {
	                $pages = 1;
	            }
	        }
	        $pagination = array(
	            'base' => @add_query_arg('paged','%#%'),
	            'format' => '',
	            'total' => $pages,
	            'current' => $current,
	            'prev_text' => $prev,
	            'next_text' => $next,
	            'type' => 'array'
	        );

	        if( $wp_rewrite->using_permalinks() ) {
	            $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	        }

	        if ( isset($_GET['s']) ) {
	            $cq = $_GET['s'];
	            $sq = str_replace(" ", "+", $cq);
	        }

	        if ( !empty($wp_query->query_vars['s']) ) {
	            $pagination['add_args'] = array( 's' => $sq);
	        }
	        $paginations = paginate_links( $pagination );
	        if ( !empty($paginations) ) {
	            echo '<ul class="pagination '.esc_attr( $args["class"] ).'">';
	                foreach ($paginations as $key => $pg) {
	                    echo '<li>'. esc_html($pg) .'</li>';
	                }
	            echo '</ul>';
	        }
        	?>

        </div>
    <?php
    }
}

if ( !function_exists('diza_tbay_get_post_galleries') ) {
	function diza_tbay_get_post_galleries( $size='full' ){

	    $ids = get_post_meta( get_the_ID(),'tbay_post_gallery_files' );

	    $output = array();

	    if( !empty($ids) ) {
		    $id = $ids[0];

		    if (is_array($id) || is_object($id)) {
			    foreach( $id as $id_img => $link_img ){
			    	$image = wp_get_attachment_image_src($id_img, $size);
			        $output[] = $image[0];
			    }
		    }
	    }

	  	return $output;

	}
}

if ( !function_exists('diza_tbay_comment_form') ) {
	function diza_tbay_comment_form($arg, $class = 'btn-primary btn-outline ') {
		global $post;
		if ('open' == $post->comment_status) {
			ob_start();
	      	comment_form($arg);
	      	$form = ob_get_clean();
	      	?>
	      	<div class="commentform reset-button-default">
		    	<?php
		      	echo str_replace('id="submit"','id="submit"', $form);
		      	?>
	      	</div>
	      	<?php
	      }
	}
}

if (!function_exists('diza_tbay_display_header_builder') ) {
	function diza_tbay_display_header_builder() {
		echo diza_get_display_header_builder();
	}
}

if (!function_exists('diza_get_elementor_css_print_method') ) {
	function diza_get_elementor_css_print_method() {
		if( 'internal' !== get_option( 'elementor_css_print_method' ) ) {
			return false;
		} else {
			return true;
		}
	}
}

if (!function_exists('diza_get_display_header_builder') ) {
	function diza_get_display_header_builder() {
		$header 	= apply_filters( 'diza_tbay_get_header_layout', 'default' );

		$args = array(
			'name'		 => $header,
			'post_type'   => 'tbay_header',
			'post_status' => 'publish',
			'numberposts' => 1
		);

		$posts = get_posts($args);
		foreach ( $posts as $post ) {
			if( diza_is_elementor_activated() && Elementor\Plugin::$instance->db->is_built_with_elementor( $post->ID ) ) {
				return Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $post->ID, diza_get_elementor_css_print_method() );
			} else {
				return do_shortcode( $post->post_content );
			}
		}
	}
}

if (!function_exists('diza_get_display_footer_builder') ) {
	function diza_get_display_footer_builder($footer) {
		$args = array(
			'name'        => $footer,
			'post_type'   => 'tbay_footer',
			'post_status' => 'publish',
			'numberposts' => 1
		);

		$posts = get_posts($args);
		foreach ( $posts as $post ) {
			if( diza_is_elementor_activated() && Elementor\Plugin::$instance->db->is_built_with_elementor( $post->ID ) ) {
				return Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $post->ID, diza_get_elementor_css_print_method() );
			} else {
				return do_shortcode( $post->post_content );
			}
		}
	}
}

if (!function_exists('diza_tbay_display_footer_builder') ) {
	function diza_tbay_display_footer_builder($footer) {
		echo diza_get_display_footer_builder($footer);
	}
}

if (!function_exists('diza_tbay_get_random_blog_cat') ) {
	function diza_tbay_get_random_blog_cat() {
		$post_category = "";
		$categories = get_the_category();

		$number = rand(0, count($categories) - 1);

		if($categories){

			$post_category .= '<a href="'.esc_url( get_category_link( $categories[$number]->term_id ) ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s", 'diza' ), $categories[$number]->name ) ) . '">'.$categories[$number]->cat_name.'</a>';
		}

		echo trim($post_category);
	}
}

if (!function_exists('diza_tbay_get_id_author_post') ) {
	function diza_tbay_get_id_author_post() {
		global $post;

		$author_id = $post->post_author;

		if( isset($author_id) ) {
			return $author_id;
		}
	}
}


if ( ! function_exists( 'diza_active_mobile_footer_icon' ) ) {
	function diza_active_mobile_footer_icon( ) {

  		$active = diza_tbay_get_config('mobile_footer_icon', true);

  		if( $active ) {
  			return true;
  		} else {
  			return false;
  		}

	}
}



if ( ! function_exists( 'diza_body_class_mobile_footer' ) ) {
	function diza_body_class_mobile_footer( $classes ) {

  		$mobile_footer = diza_tbay_get_config('mobile_footer',true);

		if( isset($mobile_footer) && !$mobile_footer ) {
			$classes[] = 'mobile-hidden-footer';
		}
		return $classes;

	}
	add_filter( 'body_class', 'diza_body_class_mobile_footer',99 );
}

if ( ! function_exists( 'diza_body_class_header_mobile' ) ) {
	function diza_body_class_header_mobile( $classes ) {

  		$layout = diza_tbay_get_config('header_mobile', 'center');

		if( isset($layout) ) {
			$classes[] = 'header-mobile-'.$layout;
		}
		return $classes;

	}
	add_filter( 'body_class', 'diza_body_class_header_mobile',99 );
}

//Add div wrapper author and name in comment form
if ( !function_exists('diza_tbay_comment_form_fields_open') ) {
	function diza_tbay_comment_form_fields_open() {
		echo '<div class="comment-form-fields-wrapper">';
	}
}
if ( !function_exists('diza_tbay_comment_form_fields_close') ) {
	function diza_tbay_comment_form_fields_close() {
		echo '</div>';
	}
}
add_action('comment_form_before_fields' , 'diza_tbay_comment_form_fields_open');
add_action('comment_form_after_fields' , 'diza_tbay_comment_form_fields_close');

if ( !function_exists('diza_the_post_category_full') ) {
	function diza_the_post_category_full ($has_separator = true) {
		  $post_category = "";
		  $categories = get_the_category();
		  $separator = ($has_separator) ?  ', ' : '';
		  $output = '';
	  if($categories){
	    foreach($categories as $category) {
	      $output .= '<a href="'.esc_url( get_category_link( $category->term_id ) ).'" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'diza' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
	    }
	  	$post_category = trim($output, $separator);
	  }

		echo trim($post_category);
	}
}

//Check active WPML
if ( !function_exists('diza_tbay_wpml') ) {
	function diza_tbay_wpml() {
		if(is_active_sidebar('wpml-sidebar')) {
			dynamic_sidebar('wpml-sidebar');
		}
	}

	add_action('diza_tbay_header_custom_language','diza_tbay_wpml', 10);
}

//Config Layout Blog
if ( !function_exists('diza_tbay_get_blog_layout_configs') ) {
	function diza_tbay_get_blog_layout_configs() {

        if( !is_singular( 'post' ) ){
            $page = 'blog_archive_sidebar';
        } else {
            $page = 'blog_single_sidebar';
        }

        $sidebar = diza_tbay_get_config($page);



		if ( !is_singular( 'post' ) ) {

			$blog_archive_layout =  ( isset($_GET['blog_archive_layout']) )  ? $_GET['blog_archive_layout'] : diza_tbay_get_config('blog_archive_layout', 'main-right');

			if( isset($blog_archive_layout) ) {

        		switch ( $blog_archive_layout ) {
					case 'left-main':
				 		$configs['sidebar'] = array( 'id' => $sidebar, 'class' => 'col-12 col-xl-3'  );
				 		$configs['main'] = array( 'class' => 'col-xl-9' );
				 		break;
				 	case 'main-right':
				 		$configs['sidebar'] = array( 'id' => $sidebar,  'class' => 'col-12 col-xl-3' );
				 		$configs['main'] = array( 'class' => 'col-xl-9' );
				 		break;
			 		case 'main':
			 			$configs['main'] = array( 'class' => '' );
			 			break;
				 	default:
			 			$configs['main'] = array( 'class' => '' );
				 		break;
       			}

				if( ( $blog_archive_layout === 'left-main' ||  $blog_archive_layout === 'main-right' ) && (empty($configs['sidebar']['id']) || !is_active_sidebar($configs['sidebar']['id']) )) {
					$configs['main'] = array( 'class' => '' );
				}

      		}

		}
		else {
				$blog_single_layout =	( isset($_GET['blog_single_layout']) ) ? $_GET['blog_single_layout']  :  diza_tbay_get_config('blog_single_layout', 'left-main');

				if( isset($blog_single_layout) ) {

					switch ( $blog_single_layout ) {
					 	case 'left-main':
					 		$configs['sidebar'] = array( 'id' => $sidebar, 'class' => 'col-12 col-xl-3'  );
					 		$configs['main'] = array( 'class' => 'col-xl-9' );
					 		break;
					 	case 'main-right':
					 		$configs['sidebar'] = array( 'id' => $sidebar,  'class' => 'col-12 col-xl-3' );
					 		$configs['main'] = array( 'class' => 'col-xl-9' );
					 		break;
				 		case 'main':
				 			$configs['main'] = array( 'class' => 'single-full' );
				 			break;
					 	default:
					 		$configs['main'] = array( 'class' => 'single-full' );
					 		break;
					 }

	                if( ( $blog_single_layout === 'left-main' ||  $blog_single_layout === 'main-right' ) && (empty($configs['sidebar']['id']) || !is_active_sidebar($configs['sidebar']['id']) )) {
	                    $configs['main'] = array( 'class' => '' );
	                }

				}
		}


		return $configs;
	}
}

if ( ! function_exists( 'diza_tbay_add_bg_close_canvas_menu' ) ) {
	function diza_tbay_add_bg_close_canvas_menu() {
		$sidebar_id = 'canvas-menu';
		if( !is_active_sidebar($sidebar_id) ) return;
		?>
			<div class="bg-close-canvas-menu"></div>
 			<div class="sidebar-content-wrapper">

				<div class="sidebar-header">
					<a href="javascript:void(0);" class="close-canvas-menu"><?php esc_html_e('Close' ,'diza'); ?><i class="tb-icon tb-icon-cross2"></i></a>
				</div>

				<div class="sidebar-content">
					<?php dynamic_sidebar($sidebar_id); ?>
				</div>

			</div>
		<?php
	}
	add_action( 'wp_footer', 'diza_tbay_add_bg_close_canvas_menu' );
}

if ( ! function_exists( 'diza_get_social_html' ) ) {
	function diza_get_social_html($key, $value, $title, $link, $media) {
		if( !$value ) return;

		switch ($key) {
			case 'facebook':
				$output = sprintf(
					'<a class="share-facebook diza-facebook" title="%s" href="http://www.facebook.com/sharer.php?u=%s&t=%s" target="_blank"><i class="fab fa-facebook-f"></i></a>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
				break;
			case 'twitter':
				$output = sprintf(
					'<a class="share-twitter diza-twitter" href="http://twitter.com/share?text=%s&url=%s" title="%s" target="_blank"><i class="fab fa-twitter"></i></a>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
				break;
			case 'linkedin':
				$output = sprintf(
					'<a class="share-linkedin diza-linkedin" href="http://www.linkedin.com/shareArticle?url=%s&title=%s" title="%s" target="_blank"><i class="fab fa-linkedin-in"></i></a>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
				break;

			case 'pinterest':
				$output = sprintf(
					'<a class="share-pinterest diza-pinterest" href="http://pinterest.com/pin/create/button?media=%s&url=%s&description=%s" title="%s" target="_blank"><i class="fab fa-pinterest"></i></a>',
					urlencode( $media ),
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
				break;

			case 'whatsapp':
				$output = sprintf(
					'<a class="share-whatsapp diza-whatsapp" href="https://api.whatsapp.com/send?text=%s" title="%s" target="_blank"><i class="fab fa-whatsapp"></i></a>',
					urlencode( $link ),
					esc_attr( $title )
				);
				break;

			case 'email':
				$output = sprintf(
					'<a class="share-email diza-email" href="mailto:?subject=%s&body=%s" title="%s" target="_blank"><i class="far fa-envelope"></i></a>',
					esc_html( $title ),
					urlencode( $link ),
					esc_attr( $title )
				);
				break;

			default:
				# code...
				break;
		}

		return $output;
	}
}

if ( ! function_exists( 'diza_custom_share_code' ) ) {
	function diza_custom_share_code( $title, $link, $media ) {
		if( !diza_tbay_get_config('enable_code_share', true) ) return;

		if( !is_singular( 'post') && !is_singular( 'product' ) ) return;

		$socials = diza_tbay_get_config('sortable_sharing');

		$socials_html = '';
		foreach ($socials as $key => $value) {
			$socials_html .= diza_get_social_html($key, $value, $title, $link, $media);
		}


		if ( $socials_html ) {
			$socials_html = apply_filters('diza_addons_share_link_socials', $socials_html);
			printf( '<div class="diza-social-links">%s</div>', $socials_html );
		}

	}
}


if ( ! function_exists( 'diza_tbay_nav_description' ) ) {
	/**
	 * Display descriptions in main navigation.
	 *
	 * @since Diza 1.0
	 *
	 * @param string  $item_output The menu item output.
	 * @param WP_Post $item        Menu item object.
	 * @param int     $depth       Depth of the menu.
	 * @param array   $args        wp_nav_menu() arguments.
	 * @return string Menu item with possible description.
	 */
	function diza_tbay_nav_description( $item_output, $item, $depth, $args ) {
		if ( 'primary' == $args->theme_location && $item->description ) {
			$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
		}

		return $item_output;
	}
	add_filter( 'walker_nav_menu_start_el', 'diza_tbay_nav_description', 10, 4 );
}


if ( ! function_exists( 'diza_body_box_shadow' ) ) {
    function diza_body_box_shadow( ) {

        if( diza_tbay_get_global_config('body_box_shadow',false) ) {
            $active = true;
        } else {
			$active = false;
		}
        if( isset($_GET['body_box_shadow']) ) {
            if( $_GET['body_box_shadow'] ) {
                $active = true;
            } else {
                $active = false;
            }
        }

        return $active;
    }
}

if ( ! function_exists( 'diza_class_body_box_shadow' ) ) {
    function diza_class_body_box_shadow( ) {

        $active = diza_body_box_shadow();

        if( $active ) {
            $class = 'boxed-layout';
        } else {
            $class = '';
        }

        return $class;
    }
}

if ( ! function_exists( 'diza_add_class_wrapper_container' ) ) {
    function diza_add_class_wrapper_container( $class_ar ) {

        $class_ar     = explode(', ', $class_ar);

        if( !empty( diza_class_body_box_shadow() ) ) {
            $class_ar[] = diza_class_body_box_shadow();
        }

        $class         = join( ' ', $class_ar );

        return $class;
    }
    add_filter( 'diza_class_wrapper_container', 'diza_add_class_wrapper_container', 10, 1 );
}
if ( ! function_exists( 'diza_tbay_custom_countdown_flash_sale_day' ) ) {
    function diza_tbay_custom_countdown_flash_sale_day() {
        $output = '<span class="label">'. esc_html__('days', 'diza') .'</span>';

        return $output;
    }

    add_filter( 'diza_tbay_countdown_flash_sale_day', 'diza_tbay_custom_countdown_flash_sale_day', 10 ,1 );
}

if ( ! function_exists( 'diza_tbay_custom_countdown_flash_sale_hour' ) ) {
    function diza_tbay_custom_countdown_flash_sale_hour() {
        $output = '<span class="label">'. esc_html__('hours', 'diza') .'</span>';

        return $output;
    }

    add_filter( 'diza_tbay_countdown_flash_sale_hour', 'diza_tbay_custom_countdown_flash_sale_hour', 10 ,1 );
}

if ( ! function_exists( 'diza_tbay_custom_countdown_flash_sale_mins' ) ) {
    function diza_tbay_custom_countdown_flash_sale_mins() {
        $output = '<span class="label">'. esc_html__('mins', 'diza') .'</span>';

        return $output;
    }

    add_filter( 'diza_tbay_countdown_flash_sale_mins', 'diza_tbay_custom_countdown_flash_sale_mins', 10 ,1 );
}

if ( ! function_exists( 'diza_tbay_custom_countdown_flash_sale_secs' ) ) {
    function diza_tbay_custom_countdown_flash_sale_secs() {
        $output = '<span class="label">'. esc_html__('secs', 'diza') .'</span>';

        return $output;
    }

    add_filter( 'diza_tbay_countdown_flash_sale_secs', 'diza_tbay_custom_countdown_flash_sale_secs', 10 ,1 );
}

if ( ! function_exists( 'diza_tbay_woocs_redraw_cart' ) ) {
    function diza_tbay_woocs_redraw_cart() {
        return 0;
    }
    add_filter( 'woocs_redraw_cart', 'diza_tbay_woocs_redraw_cart', 10 ,1 );
}
