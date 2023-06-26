<?php get_header(); ?>
<div class="paddingleft paddingright">
   <div id="content" class="site-content">
      <div id="primary" class="content-area">
         <main id="main" class="site-main">
            <?php
               // Get the post ID
               $post_id = get_the_ID();
               
               // Retrieve ACF fields
               $cover = get_field('cover', $post_id);
               $title = get_field('title', $post_id);
               $authors = get_field('authors', $post_id);
               $genre = get_field('genre', $post_id);
               $publisher = get_field('publisher', $post_id);
               $date = get_field('date', $post_id);
               $reviews = get_field('review', $post_id); // Get the reviews
               $review_count = is_array($reviews) ? count($reviews) : 0; // Count the number of reviews or default to 0
               ?>
			   
	
            <div class="flexbox fb_wrap fb_center gap30">
               <div class="flex_post">
                  <div class="book-details">
                     <img src="<?php echo esc_url($cover); ?>" alt="Book Cover">
                     <a href="<?php the_permalink(); ?>">
                        <h2><?php echo esc_html($title); ?></h2>
                     </a>
                     <?php if ($authors) : ?>
                     <div><strong>Authors:</strong> <?php echo esc_html(implode(', ', $authors)); ?></div>
                     <?php endif; ?>
                     <div class="wrap1"></div>
                     <?php if ($genre) : ?>
                     <div><strong>Genre:</strong> <?php echo esc_html(implode(', ', $genre)); ?></div>
                     <?php endif; ?>
                     <div class="wrap1"></div>
                     <?php if ($publisher) : ?>
                     <div><strong>Publisher:</strong> <?php echo esc_html($publisher); ?></div>
                     <?php endif; ?>
                     <div class="wrap1"></div>
                     <?php if ($date) : ?>
                     <div><strong>Date:</strong> <?php echo esc_html($date); ?></div>
                     <?php endif; ?>
                     <div class="wrap1"></div>
                     <div><strong>Reviews:</strong> <?php echo esc_html($review_count); ?></div>
                  </div>
               </div>
            </div>
            <div class="wrap3"></div>
            <div class="reviews">
               <?php if ($reviews) : ?>
               <div align="center">
                  <h3>Reviews</h3>
               </div>
               <div class="wrap2"></div>
               <?php foreach ($reviews as $review) : ?>
               <div class="review">
                  <?php if ($review['review_author']) : ?>
                  <p><strong>Author:</strong> <?php echo esc_html($review['review_author']); ?></p>
                  <?php endif; ?>
                  <?php if ($review['review_date']) : ?>
                  <p><strong>Date:</strong> <?php echo esc_html($review['review_date']); ?></p>
                  <?php endif; ?>
                  <?php if ($review['review_text']) : ?>
                  <p><strong>Review:</strong> <?php echo esc_html($review['review_text']); ?></p>
                  <?php endif; ?>
               </div>
               <div class="wrap2"></div>
               <?php endforeach; ?>
               <?php endif; ?>
            </div>
            <div class="navigation" align="center">
               <span class="nav-previous"><?php previous_post_link('%link', '←&nbsp;Prev'); ?></span>
               <span>&nbsp;</span>
               <span class="nav-next"><?php next_post_link('%link', 'Next&nbsp;→'); ?></span>
            </div>
         </main>
         <!-- #main -->
      </div>
      <!-- #primary -->
   </div>
   <!-- #content -->
</div>
<?php get_footer(); ?>