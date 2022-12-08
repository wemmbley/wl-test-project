<?php $power = get_post_meta( get_the_ID(), 'wl_power', true ); ?>

<p>Choose your <b>power</b>:</p>

<input type="number" value="<?= (!empty($power)) ? $power : '100' ?>" name="wl_power">