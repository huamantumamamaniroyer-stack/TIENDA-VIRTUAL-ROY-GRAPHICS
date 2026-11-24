<div class="wprev-changelog">
<?php
$automotive_car_dealer_entries = automotive_car_dealer_get_changelog_from_readme();

if ( ! empty( $automotive_car_dealer_entries ) ) :
    foreach ( $automotive_car_dealer_entries as $automotive_car_dealer_entry ) :
        $automotive_car_dealer_details = explode( "\n", trim( $automotive_car_dealer_entry[2] ) );
?>
    <details class="wprev-changelog__item">
        <summary><?php echo esc_html( 'v' . $automotive_car_dealer_entry[1] ); ?></summary>
        <ul>
            <?php foreach ( $automotive_car_dealer_details as $automotive_car_dealer_detail ) :
                $automotive_car_dealer_detail = trim( $automotive_car_dealer_detail );
                if ( ! empty( $automotive_car_dealer_detail ) ) : ?>
                    <li><?php echo esc_html( ltrim( $automotive_car_dealer_detail, '* ' ) ); ?></li>
            <?php endif; endforeach; ?>
        </ul>
    </details>
<?php
    endforeach;
else :
?>
    <p><?php esc_html_e( 'No changelog available.', 'automotive-car-dealer' ); ?></p>
<?php endif; ?>
</div>
