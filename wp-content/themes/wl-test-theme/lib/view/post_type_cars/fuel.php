<?php 
    $fuel = get_post_meta( get_the_ID(), 'wl_fuel', true ); 

    if ( empty( $fuel ) ) {
        $fuel = 'value1';
    }
?>

<p>Choose your <b>fuel</b>:</p>

<select name="wl_fuel">
    <option value="value1" <?= ($fuel === 'value1') ? 'selected' : ''; ?>>Значение 1</option>
    <option value="value2" <?= ($fuel === 'value2') ? 'selected' : ''; ?>>Значение 2</option>
    <option value="value3" <?= ($fuel === 'value3') ? 'selected' : ''; ?>>Значение 3</option>
</select>