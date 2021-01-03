<?php
# Advent of Code 2020, Day 2: https://adventofcode.com/2020/day/2

define( 'PASSWORD_POLICY', 2 );

function get_data_segments( $data ) {
	$parts = explode( ' ', $data, 3 );

	if ( count( $parts ) !== 3 ) {
		echo 'Invalidly parsed policy.';
		return;
	}

	$parsed = new stdClass();

	$policy = explode( '-' , $parts[0] );

	$parsed->policy = new stdClass();
	$parsed->policy->min = $policy[0];
	$parsed->policy->max = $policy[1];
	$parsed->requirement = trim( $parts[1], ':' );
	$parsed->password = $parts[2];

	return $parsed;
}

function is_valid_password( $parts ) {
	if ( PASSWORD_POLICY === 1 ) {
		$count = substr_count( $parts->password, $parts->requirement );

		return $count >= $parts->policy->min && $count <= $parts->policy->max;
	}

	$matches = array_filter( [ $parts->policy->min - 1, $parts->policy->max - 1 ], function( $location ) use ( $parts ) {
		return $parts->password[ $location ] === $parts->requirement;
	} );

	return count( $matches ) === 1;
}


$valid = 0;
$data = array_filter( explode( PHP_EOL, file_get_contents( __DIR__ . '/input.txt' ) ), function( $value ) {
	return ! empty( $value );
});

foreach ( $data as $datum ) {
	$parts = get_data_segments( $datum );

	if ( ! is_object( $parts ) ) {
		throw new Error( 'There is a flaw in your logic, bud.' );
	}

	if ( is_valid_password( $parts ) ) {
		$valid++;
	}
}

echo $valid;
