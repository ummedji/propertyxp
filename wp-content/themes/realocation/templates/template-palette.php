<div class="palette-wrapper palette-closed">
    <div class="palette-inner">
        <div class="palette-toggle">
            <div class="palette-toggle-inner">
                <span><i class="fa fa-cog"></i><?php echo __('Options', 'aviators'); ?></span>
            </div>
        </div>
        <!-- /.palette-toggle -->

        <h2 class="palette-title"><?php echo __('Color Variant', 'aviators'); ?></h2>

        <ul class="palette-colors clearfix">
            <li class="palette-color-red"><a href="<?php echo get_template_directory_uri(); ?>/assets/css/variants/red.css"></a></li>
            <li class="palette-color-pink"><a href="<?php echo get_template_directory_uri(); ?>/assets/css/variants/pink.css"></a></li>
            <li class="palette-color-blue"><a href="<?php echo get_template_directory_uri(); ?>/assets/css/variants/blue.css"></a></li>
            <li class="palette-color-green"><a href="<?php echo get_template_directory_uri(); ?>/assets/css/variants/green.css"></a></li>
            <li class="palette-color-cyan"><a href="<?php echo get_template_directory_uri(); ?>/assets/css/variants/cyan.css"></a></li>
            <li class="palette-color-purple"><a href="<?php echo get_template_directory_uri(); ?>/assets/css/variants/purple.css"></a></li>
            <li class="palette-color-orange"><a href="<?php echo get_template_directory_uri(); ?>/assets/css/variants/orange.css"></a></li>
            <li class="palette-color-brown"><a href="<?php echo get_template_directory_uri(); ?>/assets/css/variants/brown.css"></a></li>
        </ul>

        <h2 class="palette-title"><?php echo __('Layout', 'aviators'); ?></h2>
        <?php
        $options = array(
            'layout-wide' => __('Wide', 'aviators'),
            'layout-boxed' => __('Boxed', 'aviators'),
        );
        $default = get_theme_mod('general_layout', 'layout-wide');
        ?>

        <select class="palette-layout">
            <?php foreach ($options as $value => $label): ?>
            <?php if ($default == $value): ?>
            <option value="<?php echo $value; ?>" selected="selected"><?php echo $label; ?>
                <?php else: ?>
            <option value="<?php echo $value; ?>"><?php echo $label; ?>
                <?php endif; ?>
                <?php endforeach; ?>
        </select>


        <h2 class="palette-title"><?php echo __('Patterns', 'aviators'); ?></h2>

        <?php
        $options = array(
            "pattern-cloth-alike" => "cloth-alike",
            "pattern-corrugation" => "corrugation",
            "pattern-diagonal-noise" => "diagonal-noise",
            "pattern-dust" => "dust",
            "pattern-fabric-plaid" => "fabric-plaid",
            "pattern-farmer" => "farmer",
            "pattern-grid-noise" => "grid-noise",
            "pattern-lghtmesh" => "lghtmesh",
            "pattern-pw-maze-white" => "pw-maze-white",
            "pattern-none" => "none",
            "pattern-cloth-alike-dark" => "cloth-alike",
            "pattern-corrugation-dark" => "corrugation",
            "pattern-diagonal-noise-dark" => "diagonal-noise",
            "pattern-dust-dark" => "dust",
            "pattern-fabric-plaid-dark" => "fabric-plaid",
            "pattern-farmer-dark" => "farmer",
            "pattern-grid-noise-dark" => "grid-noise",
            "pattern-lghtmesh-dark" => "lghtmesh",
            "pattern-pw-maze-white-dark" => "pw-maze-white",
            "pattern-none-dark" => "none"
        );
        $default = get_theme_mod('background_pattern', 'pattern-none');
        ?>

        <ul class="palette-patterns clearfix">
            <?php foreach ($options as $class => $label): ?>
                <?php if($default == $class): ?>
                    <li><a class="<?php echo $class; ?> active"><?php echo $label; ?></a></li>
                <?php else: ?>
                    <li><a class="<?php echo $class; ?>"><?php echo $label; ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>


        <h2 class="palette-title"><?php echo __('Header Variant', 'aviators'); ?></h2>

        <?php
        $options = array(
            'header-dark' => __('Dark', 'aviators'),
            'header-light' => __('Light', 'aviators'),
        );

        $default = get_theme_mod('header_variant', 'header-dark');
        ?>
        <select class="palette-header">
            <?php foreach ($options as $value => $label): ?>
            <?php if ($default == $value): ?>
            <option value="<?php echo $value; ?>" selected="selected"><?php echo $label; ?>
                <?php else: ?>
            <option value="<?php echo $value; ?>"><?php echo $label; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>

        <h2 class="palette-title"><?php echo __('Map Filter', 'aviators'); ?></h2>

        <?php
        $options = array(
            'map-navigation-dark' => __('Dark', 'aviators'),
            'map-navigation-light' => __('Light', 'aviators'),
        );

        $default = get_theme_mod('map_navigation_variant', 'map-navigation-dark');
        ?>

        <select class="palette-map-navigation">
            <?php foreach ($options as $value => $label): ?>
                <?php if ($default == $value): ?>
                    <option value="<?php echo $value; ?>" selected="selected"><?php echo $label; ?>
                <?php else: ?>
                    <option value="<?php echo $value; ?>"><?php echo $label; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>


        <h2 class="palette-title"><?php echo __('Footer Variant', 'aviators'); ?></h2>
        <?php
        $options = array(
            'footer-dark' => __('Dark', 'aviators'),
            'footer-light' => __('Light', 'aviators'),
        );
        $default = get_theme_mod('footer_variant', 'footer-dark');
        ?>
        <select class="palette-footer">
            <?php foreach ($options as $value => $label): ?>
                <?php if ($default == $value): ?>
                    <option value="<?php echo $value; ?>" selected="selected"><?php echo $label; ?>
                <?php else: ?>
                    <option value="<?php echo $value; ?>"><?php echo $label; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
    <!-- /.palette-inner -->
</div>