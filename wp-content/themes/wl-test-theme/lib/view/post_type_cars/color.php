<?php $color = get_post_meta( get_the_ID(), 'wl_color', true ); ?>

<p>Choose your <b>color</b>:</p>

<div>
    <input type="color" name="wl_color"
           value="<?= (!empty($color)) ? $color : '#000000' ?>">
    <label for="color">Color</label>
</div>