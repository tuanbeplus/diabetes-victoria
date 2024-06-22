<?php

if ( ! function_exists( 'dv_suffix' ) ) {
	/**
	 * Define DV_SCRIPT_SUFFIX
	 *
	 * @return     string $suffix
	 */
	function dv_suffix( $type = false ) {
        $suffix_type = ( $type )? $type : 'bundle';
		$suffix = ( defined( 'DV_SCRIPT_SUFFIX' ) && DV_SCRIPT_SUFFIX == 'true' ) ? '' : '.' . $suffix_type;

		return $suffix;
	}
}
