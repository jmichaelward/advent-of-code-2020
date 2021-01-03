<?php
# Advent of Code 2020, Day 3: https://adventofcode.com/2020/day/3

function traverse_the_map( $shift, $advance = 1 ) {
	$data = array_filter( explode( PHP_EOL, file_get_contents( __DIR__ . '/input.txt' ) ), function( $value ) {
		return ! empty( $value );
	});

	$position = $shift;
	$encounters = [];

	foreach ( $data as $index => $section ) {
		if ( $index % $advance !== 0 || $index === 0 ) {
			continue;
		}

		$section_length = strlen( $section );

		if ( $position > $section_length - 1 ) {
			$position = abs( $position - $section_length );
		}

		$encounters[] = $section[ $position ];

		$position += $shift;
	}

	return array_filter( $encounters, function( $encounter ) { return '#' === $encounter; } );
}

$paths = [];

foreach ( [ 1, 3, 5, 7, [ 1, 2 ] ] as $route ) {
	if ( is_array( $route ) ) {
		$paths[] = traverse_the_map( $route[0], $route[1] ?? 1 );
		continue;
	}

	$paths[] = traverse_the_map( $route );
}

echo array_reduce( $paths, function( $value, $result ) {
	echo count( $result ) . PHP_EOL;

	if ( $value === 0 ) {
		return count( $result );
	}

	return count( $result ) * $value;
}, 0 );
