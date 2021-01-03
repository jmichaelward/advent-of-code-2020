<?php
# Advent of Code 2020, Day 1: https://adventofcode.com/2020/day/1

$data = array_map( function( $integer ) { return (int) $integer; }, explode( PHP_EOL, file_get_contents( __DIR__ . '/input.txt' ) ) );

foreach ( $data as $datum ) {
	$sum = array_values( array_filter( $data, function( $comparison ) use ( $datum ) {
		return $comparison !== $datum && 2020 === $datum + $comparison;
	} ) );

	if ( empty( $sum ) ) {
		continue;
	}

	echo "************** RESULT 1 *******************" . PHP_EOL;
	echo "{$datum} + {$sum[0]} equals 2020!" . PHP_EOL;
	echo "Result: " . $datum * $sum[0] . PHP_EOL;
	break;
}

foreach ( $data as $datum ) {
	$found = false;
	$possible_values = array_filter( $data, function( $comparison ) use ( $datum ) {
		return ( $datum - $comparison ) < 2020;
	} );

	foreach ( $possible_values as $possible ) {
		$sum = array_values( array_filter( $possible_values, function( $comparison ) use ( $datum, $possible ) {
			return $comparison !== $possible && 2020 === $datum + $possible + $comparison;
		} ) );

		if ( empty( $sum ) ) {
			continue;
		}

		echo "***************** RESULT 2 ******************" . PHP_EOL;
		echo "{$datum} + {$possible} + {$sum[0]} equals 2020!" . PHP_EOL;
		echo "Result: " . $datum * $possible * $sum[0];
		$found = true;
		break;
	}

	if ( $found ) {
		break;
	}
}
