<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('G5P_Widget_Gallery')) {
	class G5P_Widget_Gallery extends  GSF_Widget
	{
		public function __construct() {
			$this->widget_cssclass    = 'widget-gallery';
			$this->widget_id          = 'gsf-gallery';
			$this->widget_name        = esc_html__( 'G5Plus: Gallery', 'april-framework' );

			$this->settings = array(
				'fields' => array(
					array(
						'id'      => 'title',
						'type'    => 'text',
						'default' => '',
						'title'   => esc_html__('Title', 'april-framework')
					),
					array(
						'id' => 'hover_effect',
						'type'       => 'select',
						'title'    => esc_html__('Hover effect:', 'april-framework'),
						'default' => 'default-effect',
						'options'      => array(
							'default-effect' => esc_html__('Default', 'april-framework'),
							'suprema-effect' => esc_html__('Suprema', 'april-framework'),
							'layla-effect' => esc_html__('Layla', 'april-framework'),
							'bubba-effect'=> esc_html__('Bubba', 'april-framework'),
							'jazz-effect' => esc_html__('Jazz', 'april-framework'),
						)
					),
					array(
						'id'       => 'gallery',
						'title'    => esc_html__('Images:', 'april-framework'),
						'type'     => 'gallery',
					),
					array(
						'id' => 'columns',
						'type' => 'select',
						'title' => esc_html__('Columns:', 'april-framework'),
						'options' =>
							array(
								'1' => esc_html__('1', 'april-framework'),
								'2' => esc_html__('2', 'april-framework'),
								'3' => esc_html__('3', 'april-framework'),
							),
						'default' => '2',
					),
					array(
						'id' => 'columns_gap',
						'type' => 'select',
						'title' => esc_html__('Columns Gap:', 'april-framework'),
						'options' => array(
							'col-gap-30' => esc_html__('30px','april-framework'),
							'col-gap-20' => esc_html__('20px','april-framework'),
							'col-gap-10' => esc_html__('10px','april-framework'),
							'col-gap-0' => esc_html__('0px','april-framework'),
						),
						'default' => 'col-gap-10',
					),
					array(
						'id'          => 'text_button',
						'title'       => esc_html__('Text On Button:', 'april-framework'),
						'type'        => 'text',
						'default'     => 'Text On Button',
					),
					array(
						'id'          => 'link_button',
						'title'       => esc_html__('Link On Button:', 'april-framework'),
						'type'        => 'text',
						'default'     => '',
					),
				)
			);
			parent::__construct();
		}

		public function widget($args, $instance) {
			extract( $args, EXTR_SKIP );
			$columns = $instance['columns'];
			$columns_gap = $instance['columns_gap'];
			$button_text = (!empty($instance['text_button'])) ? $instance['text_button'] : '';
			$button_link = (!empty($instance['link_button'])) ? $instance['link_button'] : '';
			$title = (!empty($instance['title'])) ? $instance['title'] : '';
			$gallery_id = rand();
			$args_gallery = array( 'galleryId' => $gallery_id );
			$title = apply_filters('widget_title', $title, $instance, $this->id_base);
			
			//Process column and grap
			$gallery_item_class = array('gf-gallery-item');
			$gallery_item_class[] = 'col-xs-'.intval(12/$columns);

			if( $columns_gap == 'col-gap-30') {
				$gallery_item_class[] = 'mg-bottom-30';
			} elseif( $columns_gap == 'col-gap-20') {
				$gallery_item_class[] = 'mg-bottom-20';
			} elseif( $columns_gap == 'col-gap-10') {
				$gallery_item_class[] = 'mg-bottom-10';
			}

			$wrapper_classes = array(
				'gf-gallery',
				$columns_gap,
				'row'
			);

			//process image gallery
			$images = $instance['gallery'];
			$images_arr = explode('|', $images);

			$wrapper_class = implode(' ', array_filter($wrapper_classes));
			$gallery_item_class =  implode(' ', array_filter($gallery_item_class));
			
			wp_enqueue_style(G5P()->assetsHandle('g5-gallery'), G5P()->helper()->getAssetUrl('shortcodes/gallery/assets/css/gallery.min.css'), array(), G5P()->pluginVer());
			?>

			<?php echo wp_kses_post($args['before_widget']); ?>
			<?php if ($title) {
			echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
			} ?>
			<div class="wd-gallery-content">
				<div class="<?php echo esc_attr($wrapper_class);?>">
					<?php
					if(!empty($images)):
					    foreach ($images_arr as $image_id) :
						    $attach_id = preg_replace('/[^\d]/', '', $image_id);
						    $attachment_title = get_the_title($attach_id);
						    if(function_exists('g5Theme')) {
                                $thumbnail =  g5Theme()->image_resize()->resize(array(
                                    'image_id' => $attach_id,
                                    'width' => 300,
                                    'height' => 300
                                ));
                                if (isset($thumbnail['url']) && ($thumbnail['url'] !== '')) {
                                    $thumbnail = $thumbnail['url'];
                                }
                                $width = $height = 300;
                            } else {
                                $thumbnail = wp_get_attachment_image_src($attach_id, 'thumbnail');
                                if (sizeof($thumbnail) > 0 && !empty($thumbnail[0])) {
                                    $thumbnail = $thumbnail[0];
                                }
                                $width = $height = 150;
                            }
						    $image_full_src = wp_get_attachment_image_src($attach_id, 'full');
					        ?>

                            <div class="<?php echo esc_attr($gallery_item_class);?>">
                                <div class="gf-gallery-inner <?php echo esc_attr($instance['hover_effect']); ?>">
                                    <a data-magnific="true" data-gallery-id="<?php echo esc_attr($gallery_id); ?>"
                                       data-magnific-options='<?php echo json_encode($args_gallery) ?>' href="<?php echo esc_url($image_full_src[0]) ?>"
                                       class="gallery-zoom"><i class="fa fa-search"></i></a>
                                    <div class="effect-content">
                                        <div class="gallery-item-image">
                                            <img width="<?php echo esc_attr($width); ?>" height="<?php echo esc_attr($height);?>" src="<?php echo esc_url($thumbnail)?>" alt="<?php echo wp_kses_post($attachment_title)?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
					endif;
					if( !empty($button_text) ):?>
					<div class="wd-gallery-action col-xs-12">
						<a href="<?php echo esc_url($button_link);?>" class="btn btn-primary btn-classic btn-rounded btn-responsive"><?php echo esc_attr($button_text);?></a>
					</div>
					<?php endif;?>
				</div>
			</div>
			<?php echo wp_kses_post($args['after_widget']);
		}
	}
}