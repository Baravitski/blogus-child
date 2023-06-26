<?php get_header(); ?>

<div class="paddingleft paddingright">
    <?php dynamic_sidebar('genre_filter_widget_area'); ?>

    <form id="genre-filter-form" action="<?php echo esc_url(home_url()); ?>" method="GET">
        <select id="genre-dropdown" name="genre">
            <option value="">All Genres</option>
            <?php
            // Retrieve all unique genres
            $genres = array();
            $query = new WP_Query(array('posts_per_page' => -1)); // Query all posts

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $post_genres = get_field('genre'); // Get genres for each post

                    if ($post_genres) {
                        foreach ($post_genres as $post_genre) {
                            if (!in_array($post_genre, $genres)) {
                                $genres[] = $post_genre; // Add unique genres to the array
                                $selected = ($selectedGenre === $post_genre) ? 'selected' : '';
                                ?>
                                <option value="<?php echo esc_attr($post_genre); ?>" <?php echo $selected; ?>><?php echo esc_html($post_genre); ?></option>
                                <?php
                            }
                        }
                    }
                }
            }

            wp_reset_postdata();
            ?>
        </select>
    </form>
</div>

<script>
    // Listen for changes in the dropdown menu
    document.getElementById('genre-dropdown').addEventListener('change', function() {
        // Prevent the form from submitting
        event.preventDefault();

        // Get the selected genre value
        var selectedGenre = document.getElementById('genre-dropdown').value;

        // Send an Ajax request to the server
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '<?php echo esc_url(home_url()); ?>?genre=' + selectedGenre, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Update the flexbox posts container with the Ajax response

				var tempElement = document.createElement('div');
				tempElement.innerHTML = xhr.responseText;
				var allBooksDiv = tempElement.querySelector('#all_books');
				var extractedHTML = allBooksDiv.innerHTML;				

                //document.getElementById('all_books').innerHTML = xhr.responseText;
				document.getElementById('all_books').innerHTML = extractedHTML;
            }
        };
        xhr.send();
    });
</script>

<div class="wrap3"></div>

<div class="paddingleft paddingright">

	<div class="genre-filter-container">
	
	

		<div id="all_books" class="flexbox fb_wrap fb_center gap30">
			<?php
			// Check if a specific genre is selected
			$selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : '';

			// Query posts with selected genre or all posts
			$args = array(
				'posts_per_page' => 100,
				'meta_query' => array(
					array(
						'key' => 'genre',
						'value' => $selectedGenre,
						'compare' => 'LIKE',
					),
				),
			);

			$query = new WP_Query($args);

			// Check if there are any posts
			if ($query->have_posts()) {
				while ($query->have_posts()) {
					$query->the_post();

					// Retrieve ACF fields
					$post_id = get_the_ID();
					$cover = get_field('cover', $post_id);
					$title = get_field('title', $post_id);
					$authors = get_field('authors', $post_id);
					$genre = get_field('genre', $post_id);
					$publisher = get_field('publisher', $post_id);
					$date = get_field('date', $post_id);
					$reviews = get_field('review', $post_id); // Get the reviews
					$review_count = is_array($reviews) ? count($reviews) : 0; // Count the number of reviews or default to 0

					// Check if the cover and title fields are not empty
					if (!empty($cover) && !empty($title)) {
						?>

						<div class="flex_post"> <!-- Added div class "flex_post" -->

							<div class="book-details">
								<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($cover); ?>" alt="Book Cover"></a>
								<a href="<?php the_permalink(); ?>"><h2><?php echo esc_html($title); ?></h2></a>

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

								<div class="wrap2"></div>

								<div class="my_button">
									<a href="<?php the_permalink(); ?>">Read More</a>
								</div>
							</div>

						</div> <!-- Closing div class "flex_post" -->

						<?php
					}
				}
			} else {
				// No posts found
				echo 'No books found.';
			}
			wp_reset_postdata();
			?>
		</div>
		<div class="ajax-loader" style="display: none;"></div>
	<div class="wrap3"></div>
	</div>	
</div>	

<div class="navigation">
    <div class="nav-previous"><?php previous_posts_link('Previous'); ?></div>
    <div class="nav-next"><?php next_posts_link('Next'); ?></div>
</div>



<?php get_footer(); ?>
