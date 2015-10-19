<?php
namespace Ethereal;

use Ethereal\Hooks\Exception;

class Hooks
{
	protected $hooks;

	public function __construct(array $hooks = array())
	{
		$this->hooks = $hooks;
	}

	/**
	 * Add a hook listener
	 * @param string $topic  Topic to subscribe to
	 * @param object $class  Callable object
	 * @param string $method Callable method found in object
	 */
	public function addListener($topic, $class, $method)
	{
		if (!is_string($topic)) {
			throw new Ethereal\Hooks\Exception('Invalid topic type');
		}
		if (!is_string($method)) {
			throw new Ethereal\Hooks\Exception('Invalid method type');
		}
		if (!is_object($class)) {
			throw new Ethereal\Hooks\Exception('$class must be an instance of an object');
		}
		if (!isset($this->hooks[$topic])) {
			$this->hooks[$topic] = array();
		}
		$this->hooks[$topic][] = array(
			'class' => $class,
			'method' => $method
		);
	}

	public function removeListener($topic, $class, $method)
	{
		if (isset($this->hooks[$topic])) {
			foreach ($this->hooks[$topic] as $i => $call) {
				if (get_class($call['class']) == $class && $call['method'] == $method) {
					unset($this->hooks[$topic][$i]);
				}
			}
		}
	}

	public function fire($topic, array $data)
	{
		if (!is_string($topic)) {
			throw new Ethereal\Hooks\Exception('Invalid topic type');
		}
		if (!isset($this->hooks[$topic])) {
			return $data;
		}
		foreach ($this->hooks[$topic] as $call) {
			try {
				$data = call_user_func(
					array(
						$call['class'],
						$call['method']
					),
					$data
				);
			} catch (Exception $e) {
				continue;
			}
		}
		return $data;
	}

    /**
     * Gets the value of hooks.
     *
     * @return mixed
     */
    public function getListeners()
    {
        return $this->hooks;
    }
}
