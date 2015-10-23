# SimpleHooks

Simple hook system

This project adheres to a Contributor Code of Conduct. By participating in this project and its community, you are expected to uphold this code.

Invoke with an associative array containing topic keys with arrays of class (instance of an object) and method

####Example####

	$hooks = array(
		'\Ethereal\Config\Build' => array(
			array(
				'class' => new \Ethereal\Listener(),
				'method' => 'buildConfig'
			)
		)
	);
	$hookSystem = new \Ethereal\Hooks($hooks);

The buildConfig hook will be passed an array to parse and return.