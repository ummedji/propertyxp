<div class="footer-top">
    <div class="container">

        <?php if(aviators_active_sidebars('footer-first-column', 'footer-second-column', 'footer-third-column', AVIATORS_SIDEBARS_ANY)): ?>
            <div class="row">
                <?php if(is_active_sidebar('footer-first-column')): ?>
                    <div class="region col-sm-4">
                        <?php dynamic_sidebar('footer-first-column'); ?>
                    </div><!-- /.region -->
                <?php endif; ?>

                <?php if(is_active_sidebar('footer-second-column')): ?>
                    <div class="region col-sm-4">
                        <?php dynamic_sidebar('footer-second-column'); ?>
                    </div><!-- /.region-->
                <?php endif; ?>

                <?php if(is_active_sidebar('footer-third-column')): ?>
                    <div class="region col-sm-4">
                        <?php dynamic_sidebar('footer-third-column'); ?>
                    </div><!-- /.region-->
                <?php endif; ?>
            </div><!-- /.row -->
        <?php endif; ?>

        <?php if(aviators_active_sidebars('footer-lower-left', 'footer-lower-right', AVIATORS_SIDEBARS_ANY)): ?>
            <hr>

            <div class="row">
                <div class="footer-lower clearfix">
                    <?php if(is_active_sidebar('footer-lower-left')): ?>
                        <div class="footer-lower-left">
                            <div class="col-sm-9"><?php dynamic_sidebar('footer-lower-left'); ?></div>
                        </div><!-- /.footer-lower-left -->
                    <?php endif; ?>

                    <?php if(is_active_sidebar('footer-lower-right')): ?>
                        <div class="footer-lower-right">
                            <div class="col-sm-3"><?php dynamic_sidebar('footer-lower-right'); ?></div>
                        </div><!-- /.footer-lower-right -->
                    <?php endif; ?>
                </div><!-- /.footer-lower -->
            </div><!-- /.row -->
            <div class="row">
            	<div class="col-md-12">
					<div class="dark-ft-logo"><img src="<?php bloginfo('template_directory')?>/images/footer_logo.png" class="footer_lg" alt=" "></div>
					<div class="light-ft-logo"><img src="<?php bloginfo('template_directory')?>/images/footer_logo-dark.png" class="footer_lg" alt=" "></div>
            		<!--<h3 style="color: #35B54A;">PropertyXP.COM</h3>-->
					<p>The best place to find a new beginning. Catering to India's top developers and real estate agents, the website offers the largest online database of properties for sale and rent in the country. Propertyxp.com is rich in quality listings and user engagement platforms such as Simply ASK - QnA and iConnect with more that 3.5 Lakh subscribers exchanging views and resolving issues. Propertyxp.com, is an 3rd eye Pvt. Ltd, invested Company.</p>
					<h5><a href="<?php bloginfo('url');?>/about-us">Read More</a></h5>
				</div>
				<div class="col-md-12 text-center">
					<div class="col-md-8 text-right ftr_text"><i class="fa fa-envelope" aria-hidden="true"></i> <strong>Email:</strong> <a href="mailto:info@propertyxp.com">info@propertyxp.com1</a></div>
					<div class="col-md-4 text-right ftr_text right-m-f"><i class="fa fa-phone-square" aria-hidden="true"></i> <strong>Phone:</strong> 079 +9179 400400</div>
					<!--<div class="col-md-3">
						<h4>Affordable Housing in India</h4>
						<p style="color:#aaa">Budget flat from 8 to 20 lacs in Mumbai<br />
						Budget flat from 8 to 20 lacs in Ahmedabad<br />
						Budget flat from 8 to 20 lacs in Pune<br />
						Budget flat from 8 to 20 lacs in Delhi<br />
						Budget flat from 8 to 20 lacs in Bangalore</p>
					</div>
					<div class="col-md-3">
						<h4>Popular affordable house 20-35 lacs</h4>
						<p style="color:#aaa">Budget flat from 8 to 20 lacs in Mumbai<br />
						Budget flat from 8 to 20 lacs in Ahmedabad<br />
						Budget flat from 8 to 20 lacs in Pune<br />
						Budget flat from 8 to 20 lacs in Delhi<br />
						Budget flat from 8 to 20 lacs in Bangalore</p>
					</div>
					<div class="col-md-3">
						<h4>New Property Developments</h4>
						<p style="color:#aaa">Budget flat from 8 to 20 lacs in Mumbai<br />
						Budget flat from 8 to 20 lacs in Ahmedabad<br />
						Budget flat from 8 to 20 lacs in Pune<br />
						Budget flat from 8 to 20 lacs in Delhi<br />
						Budget flat from 8 to 20 lacs in Bangalore</p>
					</div>
					<div class="col-md-3"><h4>New</h4>
						<p style="color:#aaa">Information Here</p>
					</div>-->
				</div>
				<!--<div class="col-md-12">
					<div class="col-md-3">
						<h4>Top Indian Properties</h4>
						<p  style="color:#aaa">100 Latest Mumbai Propertoes<br />
						100 Most Popular Pune Properties</p>
					</div>
					<div class="col-md-3">
						<h4>Top Real Estate Listing India</h4>
						<p style="color:#aaa">100 Latest Mumbai Propertoes<br />
						100 Most Popular Pune Properties</p>
					</div>
					<div class="col-md-3">
						<h4>Payment Method</h4>
					</div>
					<div class="col-md-3"></div>
				</div>-->
				<div class="col-md-12">
					<h3 style="color: #35B54A;">Information</h3>
					<h5 class="info-links">
						<a href="<?php bloginfo('url'); ?>/about-us">About Us</a> |
						<a href="<?php bloginfo('url'); ?>/contact-us">Contact Us</a> |
						<a href="<?php bloginfo('url'); ?>/privacy-policy/">Privacy Policy</a> |
						<a href="<?php bloginfo('url'); ?>/refund-cancellation/">Refund & Cancellation</a> |
						<a href="<?php bloginfo('url'); ?>/terms-conditions/">Terms & Conditions</a> |
						<a href="<?php bloginfo('url'); ?>/frontend-property-submission/">Advertise With Us</a></h5>
				</div>
            </div>
        <?php endif; ?>
    </div><!-- /.container -->
</div><!-- /.footer-top -->