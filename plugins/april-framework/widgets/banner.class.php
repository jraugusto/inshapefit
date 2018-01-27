<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('G5P_Widget_Banner')) {
	class G5P_Widget_Banner extends  GSF_Widget
	{
		public function __construct() {
			$this->widget_cssclass    = 'widget-banner';
			$this->widget_id          = 'gsf-banner';
			$this->widget_name        = esc_html__( 'G5Plus: Banner', 'april-framework' );

			$this->settings = array(
				'fields' => array(
					array(
						'id'      => 'title',
						'type'    => 'text',
						'default' => '',
						'title'   => esc_html__('Title:', 'april-framework')
					),
                    array(
                        'id'          => 'image',
                        'title'       => esc_html__('Image:', 'april-framework'),
                        'type'        => 'image',
                        'sort'     => true,
                    ),
					array(
						'id'          => 'link',
						'title'       => esc_html__('Url redirect:', 'april-framework'),
						'type'        => 'text',
						'default'     => '',
                        'required' => array('image[id]', '!=', '')
					),
					array(
						'id'      => 'alt',
						'type'    => 'text',
						'default' => '',
						'title'   => esc_html__('Alt:', 'april-framework'),
                        'required' => array('image[id]', '!=', '')
					),
                    array(
                        'type' => 'select',
                        'title' => esc_html__( 'Height Mode', 'april-framework' ),
                        'id' => 'height_mode',
                        'options' => array(
                            '100' => '1:1',
                            'original' => esc_html__( 'Original', 'april-framework' ),
                            '133.333333333' => '4:3',
                            '75' => '3:4',
                            '177.777777778' => '16:9',
                            '56.25' => '9:16',
                            'custom' => esc_html__( 'Custom (image mode: background)', 'april-framework' )
                        ),
                        'default' => 'original',
                        'required' => array('image[id]', '!=', '')
                    ),
                    array(
                        'type' => 'text',
                        'input_type' => 'number',
                        'title' => esc_html__( 'Height', 'april-framework' ),
                        'id' => 'height',
                        'default' => '200',
                        'args' => array(
                            'min' => '0',
                            'max' => '500',
                            'step' => '1'
                        ),
                        'required' => array(
                            array('image[id]', '!=', ''),
                            array('height_mode', '=', 'custom')
                        )
                    ),
					array(
						'id'        => 'effect',
						'title'     => esc_html__('Hover Effect: ', 'april-framework'),
						'type'      => 'select',
						'default'      => 'normal-effect',
						'options' => array(
							'normal-effect' => esc_html__('Normal', 'april-framework'),
							'suprema-effect' => esc_html__('Suprema', 'april-framework'),
							'layla-effect' => esc_html__('Layla', 'april-framework'),
							'bubba-effect'=> esc_html__('Bubba', 'april-framework'),
							'jazz-effect' => esc_html__('Jazz', 'april-framework'),
                            'flash-effect' => esc_html__('Flash', 'april-framework')
						),
                        'required' => array('image[id]', '!=', '')
					)
				)
			);

			parent::__construct();
		}

		public function widget($args, $instance) {
			extract( $args, EXTR_SKIP );
			$wrapper_classes = array(
				'widget-banner-content',
				$instance['effect'],
			);
            $title = (!empty($instance['title'])) ? $instance['title'] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);
            echo wp_kses_post($args['before_widget']);
            if ($title) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            }
            $image = apply_filters( 'widget_image', $instance['image'] );
            if(!empty($image['id']) && !empty($image['url']) && function_exists('g5Theme')) {
                $alt = (!empty($instance['alt'])) ? $instance['alt'] : '';
                $link = $image_url = $attachment_title = "";
                $height_mode = (!empty($instance['height_mode'])) ? $instance['height_mode'] : '100';
                $height = (!empty($instance['height'])) ? $instance['height'] : '200';

                $banner_bg_css = '';
                $banner_class = 'gf-banner-'.random_int( 1000, 9999 );
                $img_width = $img_height = '';
                list( $img_width, $img_height ) = getimagesize( $image['url'] );
                if($height_mode != 'custom') {
                    if($height_mode !== 'original') {
                        $height = round($img_width*$height_mode/100);
                        if($img_height < $height) {
                            $img_width = $img_height;
                            $img_height = round($img_width*$height_mode/100);
                        } else {
                            $img_height = $height;
                        }
                    }
                    if($img_width > 400) {
                        $img_height = round($img_height/($img_width/400));
                        $img_width = 400;
                    }
                } else {
                    $wrapper_classes[] = 'banner-mode-background';
                    $img_url = $image['url'];
                    $banner_bg_css =<<<CSS
			.{$banner_class} {
			    background-image: url('{$img_url}');
				height: {$height}px;
			}
CSS;
                }
                GSF()->customCss()->addCss($banner_bg_css);
                $wrapper_class = implode(' ', array_filter($wrapper_classes));

                $attachment_title = get_the_title($image['id']);
                $alt_image = (!empty($alt)) ? $alt : $attachment_title;
                $image =  g5Theme()->image_resize()->resize(array(
                    'image_id' => $image['id'],
                    'width' => $img_width,
                    'height' => $img_height
                ));
                $img_html = '<img width="' . $img_width . '" height="' . $img_height . '" src="' . $image['url'] . '" alt="' . $alt_image . '">';

                if (!empty($instance['link'])) {
                    $link = $instance['link'];
                }
                ?>
                <div class="<?php echo esc_attr($wrapper_class) ?>">
                    <div class="effect-bg-image <?php echo esc_attr($banner_class); ?>"></div>
                    <?php if (!empty($link)): ?>
                        <a href="<?php echo esc_url($link) ?>" title="<?php echo esc_attr($alt_image); ?>" class="effect-content">
                            <span class="banner-overlay"></span>
                            <?php if($height_mode !== 'custom'): ?>
                                <?php echo wp_kses_post($img_html); ?>
                            <?php endif; ?>
                        </a>
                    <?php else: ?>
                        <div class="effect-content">
                            <span class="banner-overlay"></span>
                            <?php if($height_mode !== 'custom'): ?>
                                <?php echo wp_kses_post($img_html); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php
            }
			echo wp_kses_post($args['after_widget']);
		}
	}
}