<?php if ( bp_loggedin_user_id() ) : 
	$months = array( "Januari","Februari","Mars","April","Maj","Juni","Juli","Augusti",'September', 'Oktopber', 'November', 'December' );
?>

      <div class="page-header">
          <h1>Statistik</h1>
      </div>

      <div class="row-fluid">
      	<div class="span6">
			<h4>Topplistan <?php echo strtolower( $months[ intval(date('m'))-1 ] ); ?></h4>
			<ul class="toplist">
			<?php
      			$args = array( 'year' => date('Y'), 'monthnum' => date('m'), 'post_type' => 'insandare', 'posts_per_page' => -1 );
      			$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$terms = wp_get_post_terms( $post->ID, 'paper', array("fields" => "ids") );
						$user_posts[ $post->post_author ] = $user_posts[ $post->post_author ]+count($terms);
					}
				} 
				arsort($user_posts);
				$i = 0;
				foreach ( $user_posts as $userid => $posts) {
					if( $i == 5 )
						break;
					$user = get_userdata( $userid );
					echo '<li>'.get_avatar( $user->ID, 65 ).bp_core_get_user_displayname($userid).' <span class="score">'.$posts.' st</span></li>';
					$i++;
				}
				if( count($user_posts) == 0 )
					echo '<li><center>Inga insändare ännu</center></li>';
				wp_reset_postdata();
      		?>
      		</ul>
      	</div>
      	<div class="span6">
			<h4>Den eviga topplistan</h4>

			<ul class="toplist">
			<?php
      			$args = array( 'post_type' => 'insandare', 'posts_per_page' => -1 );
      			$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$terms = wp_get_post_terms( $post->ID, 'paper', array("fields" => "ids") );
						$user_posts[ $post->post_author ] = $user_posts[ $post->post_author ]+count($terms);
					}
				} 
				arsort($user_posts);
				$i = 0;
				foreach ( $user_posts as $userid => $posts) {
					if( $i == 5 )
						break;
					$user = get_userdata( $userid );
					echo '<li>'.get_avatar( $user->ID, 65 ).bp_core_get_user_displayname($userid).' <span class="score">'.$posts.' st</span></li>';
					$i++;
				}
				if( count($user_posts) == 0 )
					echo '<li><center>Inga insändare ännu</center></li>';
				wp_reset_postdata();
      		?>
      		</ul>
      	</div>
      </div>
      <div class="row-fluid">
      	<div class="span12">
      		<hr/>

      		<h4>Antal publiceringar per månad</h4>
      		<p>I diagrammet nedan kan du se hur många publiceringar som vi användare på <strong>Insändarmaskinen™</strong> gemensamt är ansvariga för <?php echo date('Y') ?>. Ju fler vi är destå finare diagram kommer vi få. Så bjud gärna in era vänner och kamrater!</p>
      		<canvas id="monthChart" width="860" height="370"></canvas>
      		<?php
      			$args = array( 'year' => '2013', 'post_type' => 'insandare', 'posts_per_page' => -1 );
      			$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$time = strtotime($post->post_date);
						$terms = wp_get_post_terms( $post->ID, 'paper', array("fields" => "ids") );
						$month_posts[ date('m',$time) ] = $month_posts[ date('m',$time) ]+count($terms);
					}
				} 
				wp_reset_postdata();
      		?>
      		<script type="text/javascript">
      		var ctx = document.getElementById("monthChart").getContext("2d");
      		var data = {
				labels : ["Januari","Februari","Mars","April","Maj","Juni","Juli","Augusti",'September', 'Oktopber', 'November', 'December'],
				datasets : [
					{
						fillColor : "rgba(220,220,220,0.5)",
						strokeColor : "#ed6b4e",
						pointColor : "#ed6b4e",
						pointStrokeColor : "#fff",
						data : [<?php echo implode(',', $month_posts); ?>]
					}
				]
			};
			var options = {
				scaleOverride : true,
				
				scaleSteps : <?php echo max($month_posts)/10; ?>,
				scaleStepWidth : 10,
				scaleStartValue : 0,

				scaleShowGridLines : false,
				datasetStrokeWidth : 4,
				pointDotRadius : 8,
				scaleLabel : "<%=value%> st",
				pointDotStrokeWidth : 4,
				scaleFontFamily: "Helvetica Neue, Helvetica, Arial, sans-serif",
				scaleFontSize: 12
			};
			new Chart(ctx).Line(data,options);
      		</script>
      	</div>
      </div>

      <p><br/><br/></p>

<?php endif; ?>