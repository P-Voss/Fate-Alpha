<?php

/**
 * Description of Bootstrap
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Feedback_Bootstrap extends Zend_Application_Module_Bootstrap {

    private $namespaces = [
        'Feedback' => APPLICATION_PATH . '/modules/Feedback'
    ];

    /**
     * initiates autoloader for classes of this module
     *
     * @var array
     */
    public function _initAutoloader() {
        foreach ($this->namespaces as $prefix => $base_dir) {
            spl_autoload_register(function ($class) use ($prefix, $base_dir) {
                $len = strlen($prefix);
                if (strncmp($prefix, $class, $len) !== 0) {
                    return;
                }
                $relative_class = substr($class, $len);

                $classPathSteps = explode('\\', $relative_class);
                foreach ($classPathSteps as $step => $identifier) {
                    if ($step === count($classPathSteps) - 1) {
                        $classPathSteps[$step] = $identifier;
                        continue;
                    }
                    $classPathSteps[$step] = lcfirst($identifier);
                }

                $file = $base_dir . implode('/', $classPathSteps) . '.php';

                if (file_exists($file)) {
                    require $file;
                }
            });
        }
    }

}
