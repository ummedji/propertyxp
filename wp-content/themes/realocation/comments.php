<?php if ( !post_password_required() ) : ?>
    <?php if ( ! comments_open() ): ?>
        <div class="alert alert-info">
            <?php echo __('Comments are closed.', 'aviators'); ?>
        </div><!-- /.alert -->
    <?php else: ?>
        <div id="comments" class="comments-area">
            <?php if ( have_comments() ) : ?>
                <div class="decorated-title">
                    <div class="decorated-title-inner">
                        <div class="rules"></div><!-- /.rules-->
                        <h2 class="title"><?php echo get_comments_number() ?> Comments</h2>
                        <div class="rules"></div><!-- /.rules-->
                    </div><!-- /.decorated-title-inner -->
                </div>

                <ol class="comment-list">
                    <?php wp_list_comments( array( 'callback' => 'aviators_comment', 'style' => 'ul' ) ); ?>
                </ol>

                <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                    <nav class="navigation comment-navigation" role="navigation">
                        <h1 class="screen-reader-text section-heading"><?php __( 'Comment navigation', 'aviators' ); ?></h1>
                        <div class="nav-previous"><?php previous_comments_link(__( '&larr; Older Comments', 'aviators')) ?></div>
                        <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'aviators')) ?></div>
                    </nav><!-- .comment-navigation -->
                <?php endif; ?>

                <?php if ( !comments_open() && get_comments_number() ) : ?>
                    <p class="no-comments"><?php __('Comments are closed.', 'aviators'); ?></p>
                <?php endif; ?>
            <?php endif; ?>
            <hr />
            <?php aviators_comment_form(array(
                'aria_req' => true,
                'comment_notes_after' => null,
                'comment_field' => '<div class="form-group comment-form-comment"><label for="comment">' . __( 'Comment', 'aviators' ) . '</label> <textarea id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>',
                'fields' => array(
                    'author' => '<div class="row"><div class="col-sm-6"><div class="form-group comment-form-author">' . '<label for="author">' . __( 'Name', 'aviators' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                        '<input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"></div></div>',
                    'email'  => '<div class="col-sm-6"><div class="form-group comment-form-email"><label for="email">' . __( 'Email', 'aviators' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                        '<input id="email" name="email" type="email" class="form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"></div></div></div>',
                )
            )); ?>
        </div><!-- /#comments -->
    <?php endif; ?>
<?php endif; ?>