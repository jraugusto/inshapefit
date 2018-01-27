<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 9/20/2017
 * Time: 10:28 AM
 */
global $single_portfolio_title;
if(!empty($single_portfolio_title)) {
    return;
}
?>
<h4 class="gsf-portfolio-single-title mg-top-0 mg-bottom-30"><?php the_title() ?></h4>
