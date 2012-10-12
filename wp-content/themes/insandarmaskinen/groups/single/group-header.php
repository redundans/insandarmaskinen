<?php

do_action( 'bp_before_group_header' );

?>

<div id="item-header-content">

	<?php do_action( 'bp_before_group_header_meta' ); ?>

</div><!-- #item-header-content -->

<?php
do_action( 'bp_after_group_header' );
do_action( 'template_notices' );
?>