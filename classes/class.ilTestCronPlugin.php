<?php

require_once __DIR__ . "/../vendor/autoload.php";

use iLUB\Plugins\TestCron\Helper\DIC;
use iLUB\Plugins\TestCron\Helper\TestCronDBAccess;
use iLUB\Plugins\TestCron\Jobs\RunSync;

/**
 * Class ilTestCronPlugin
 *
 * @package
 */
class ilTestCronPlugin extends ilCronHookPlugin {

	use DIC;

	const PLUGIN_ID = 'tcron';
	const PLUGIN_NAME = 'TestCron';
	const TABLE_NAME = 'tcron_config';
	const COLUMN_NAME = 'expiration';
	const DEFAULT_EXPIRATION_VALUE = 240;
    const EXPIRATION_THRESHOLD = 'expiration_threshold';
    const ILPLUGIN_TABLE = 'il_plugin';
    const LOG_DESTINATION = './Customizing/global/plugins/Services/Cron/CronHook/TestCron/app.log';

	/**
	 * @var ilTestCronPlugin
	 */
	protected static $instance;
    /**
     * @var $this->access
     */
	protected $access;


	/**
	 * @return string
	 */
	public function getPluginName(): string {
		return self::PLUGIN_NAME;
	}


	/**
	 * @return ilTestCronPlugin
	 */
	public static function getInstance(): ilTestCronPlugin {
		if (self::$instance === NULL) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * @return ilCronJob[]
	 */
	public function getCronJobInstances(): array {
		return [ new RunSync() ];
	}


	/**
	 * @param string $a_job_id
	 *
	 * @return ilCronJob
	 */
	public function getCronJobInstance($a_job_id): ilCronJob {
	    $a_job_id = "\iLUB\Plugins\TestCron\Jobs\RunSync";
		return new $a_job_id();
	}


	/**
	 *
	 */
	protected function afterUninstall() {
		$this->access = new TestCronDBAccess();
		$this->access->removePluginTableFromDB();
	}

}
