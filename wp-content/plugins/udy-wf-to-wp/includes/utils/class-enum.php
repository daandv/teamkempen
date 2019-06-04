<?php
/**
 * Created by PhpStorm.
 * User: Pietro Falco
 * Date: 17/01/2018
 * Time: 16:12
 */

namespace UdyWfToWp\Utils;

abstract class Enum {
	/**
	 * Enum value
	 *
	 * @var mixed
	 */
	protected $value;
	/**
	 * Store existing constants in a static cache per object.
	 *
	 * @var array
	 */
	protected static $cache = array();

	/**
	 * Creates a new value of some type
	 *
	 * @param mixed $value
	 *
	 * @throws \UnexpectedValueException if incompatible type is given.
	 */
	public function __construct( $value ) {
		if ( ! $this->isValid( $value ) ) {
			throw new \UnexpectedValueException( "Value '$value' is not part of the enum " . get_called_class() );
		}
		$this->value = $value;
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Returns the enum key (i.e. the constant name).
	 *
	 * @return mixed
	 */
	public function getKey() {
		return static::search( $this->value );
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return (string) $this->value;
	}

	/**
	 * Compares one Enum with another.
	 *
	 * This method is final, for more information read https://github.com/myclabs/php-enum/issues/4
	 *
	 * @return bool True if Enums are equal, false if not equal
	 */
	final public function equals( Enum $enum ) {
		return $this->getValue() === $enum->getValue() && get_called_class() == get_class( $enum );
	}

	/**
	 * Returns the names (keys) of all constants in the Enum class
	 *
	 * @return array
	 */
	public static function keys() {
		return array_keys( static::toArray() );
	}

	/**
	 * Returns instances of the Enum class of all Enum constants
	 *
	 * @return static[] Constant name in key, Enum instance in value
	 */
	public static function values($only_values = false) {
		$values = array();
		foreach ( static::toArray() as $key => $value ) {
			if($only_values){
				$values[ $value ] = new static( $value );
			}else{
				$values[ $key ] = new static( $value );
			}
		}

		return $values;
	}

	/**
	 * Returns all possible values as an array
	 *
	 * @return array Constant name in key, constant value in value
	 */
	public static function toArray() {
		$class = get_called_class();
		if ( ! array_key_exists( $class, static::$cache ) ) {
			$reflection              = new \ReflectionClass( $class );
			static::$cache[ $class ] = $reflection->getConstants();
		}

		return static::$cache[ $class ];
	}

	/**
	 * Check if is valid enum value
	 *
	 * @param $value
	 *
	 * @return bool
	 */
	public static function isValid( $value ) {
		return in_array( $value, static::toArray(), true );
	}

	/**
	 * Check if is valid enum key
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public static function isValidKey( $key ) {
		$array = static::toArray();

		return isset( $array[ $key ] );
	}

	/**
	 * Return key for value
	 *
	 * @param $value
	 *
	 * @return mixed
	 */
	public static function search( $value ) {
		return array_search( $value, static::toArray(), true );
	}

	public static function __callStatic($name, $arguments)
	{
		$array = static::toArray();
		if (isset($array[$name])) {
			return new static($array[$name]);
		}
		throw new \BadMethodCallException("No static method or enum constant '$name' in class " . get_called_class());
	}

}