<?php
# Advent of Code 2020, Day 4: https://adventofcode.com/2020/day/4

$file = explode( PHP_EOL, file_get_contents( __DIR__ . '/input.txt' ) );

$data = '';
$count = 0;

foreach ( $file as $line ) {
	if ( empty( $line ) ) {
		if ( is_valid_passport( $data ) ) {
			$count++;
		}

		$data = '';
		continue;
	}

	$data .= $line . ' ';
}

function is_valid_passport( string $data ) {
	$required_keys = [ 'byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid' ];
	$values = explode( ' ', rtrim( $data ) );

	$keys = [];

	foreach ( $values as $value ) {
		$field = substr( $value, 0, 3 );
		$field_value = substr( $value, 4 );

		if ( is_valid_field( $field, $field_value ) ) {
			$keys[ $field ] = $field_value;
		}
	}

	return count( $required_keys ) === count( array_filter( $keys, function( $key ) use ( $required_keys ) {
		return in_array( $key, $required_keys );
	}, ARRAY_FILTER_USE_KEY ) );
}

function is_valid_field( $field, $value ) {
	switch( $field ) {
		case 'byr':
			return is_valid_birth_year( (int) $value );
		case 'iyr':
			return is_valid_issue_year( (int) $value );
		case 'eyr':
			return is_valid_expiration_year( (int) $value );
		case 'hgt':
			return is_valid_height( $value );
		case 'hcl':
			return is_valid_hair_color( $value );
		case 'ecl':
			return is_valid_eye_color( $value );
		case 'pid':
			return is_valid_passport_id( $value );
		default:
			return false;
	}
}

function is_valid_birth_year( $value ) {
	return $value >= 1920 && $value <= 2002;
}

function is_valid_issue_year( $value ) {
	return $value >= 2010 && $value <= 2020;
}

function is_valid_expiration_year( $value ) {
	return $value >= 2020 && $value <= 2030;
}

function is_valid_height( $value ) {
	$unit = substr( $value, -2 );
	$height = (int) str_replace( $unit, '', $value );

	switch ( $unit ) {
		case 'cm':
			return $height >= 150 && $height <= 193;
		case 'in':
			return $height >= 59 && $height <= 76;
		default:
			return false;
	}
}

// a # followed by exactly six characters 0-9 or a-f.
function is_valid_hair_color( $value ) {
	if ( 7 !== strlen( $value ) || 0 !== strpos( $value, '#' ) ) {
		return false;
	}

	$color = substr( $value, 1 );

	return ctype_xdigit( substr( $value, 1 ) );
}

function is_valid_eye_color( $value ) {
	return in_array( $value, [ 'amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth' ], true );
}

function is_valid_passport_id( $value ) {
	return is_numeric( $value ) && strlen( $value ) === 9;
}

echo $count;
