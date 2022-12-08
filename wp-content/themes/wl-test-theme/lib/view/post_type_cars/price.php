<?php $price = get_post_meta( get_the_ID(), 'wl_price', true ); ?>

<p>Choose your <b>price</b>:</p>

<input type="number" value="<?= ( empty($price) ? '5000' : $price ) ?>" name="wl_price">