<?php
function array_csv_download($array, $filename) {
    header( 'Content-Type: application/csv' );
    header( 'Content-Disposition: attachment; filename="' . $filename . '";' );

    // clean output buffer
    ob_end_clean();

    $handle = fopen( 'php://output', 'w' );

    // use keys as column titles
    fputcsv( $handle, array_keys( $array['0'] ) );

    fputcsv( $handle, array_values($array['0']) );

    fclose( $handle );

    // flush buffer
    ob_flush();

    // use exit to get rid of unexpected output afterward
    exit();
}