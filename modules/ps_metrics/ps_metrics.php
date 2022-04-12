<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

class Ps_metrics extends Module
{
    /** @var string */
    public $oauthAdminController;

    /** @var array */
    public $controllers;

    /** @var bool */
    public $psVersionIs17;

    /** @var array */
    public $moduleSubstitution;

    /** @var string */
    public $graphqlController;

    /** @var string */
    public $ajaxDashboardController;

    /** @var string */
    public $ajaxSettingsController;

    /** @var string */
    public $metricsStatsController;

    /** @var string */
    public $metricsSettingsController;

    /** @var string */
    public $legacyStatsController;

    /** @var string */
    public $metricsUpgradeController;

    /** @var bool */
    public $bootstrap;

    /** @var string */
    public $confirmUninstall;

    /** @var PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer */
    private $container;

    /** @var string */
    public $idPsAccounts;

    /** @var string */
    public $idPsMetrics;

    /** @var string */
    public $template_dir;

    /** @var string */
    public $emailSupport;

    /** @var string */
    public $ajaxMetricsController;

    public function __construct()
    {
        $this->name = 'ps_metrics';
        $this->tab = 'advertising_marketing';
        $this->version = '2.8.0';
        $this->author = 'PrestaShop';
        $this->need_instance = 0;
        $this->module_key = '697657ffe038d20741105e95a10b12d1';
        $this->bootstrap = false;
        $this->oauthAdminController = 'AdminOauthCallback';
        $this->ajaxDashboardController = 'AdminAjaxDashboard';
        $this->graphqlController = 'AdminGraphql';
        $this->ajaxSettingsController = 'AdminAjaxSettings';
        $this->metricsSettingsController = 'AdminMetricsSettings';
        $this->metricsStatsController = 'AdminMetricsStats';
        $this->metricsUpgradeController = 'AdminMetricsUpgrade';
        $this->ajaxMetricsController = 'AdminAjaxMetrics';
        $this->idPsAccounts = '49648';
        $this->idPsMetrics = '49583';
        $this->emailSupport = 'support-metrics@prestashop.com';
        $this->controllers = [
            $this->oauthAdminController,
            $this->graphqlController,
            $this->ajaxDashboardController,
            $this->ajaxSettingsController,
            $this->metricsSettingsController,
            $this->metricsUpgradeController,
            $this->ajaxMetricsController,
        ];
        $this->moduleSubstitution = [
            'dashactivity',
            'dashtrends',
            'dashgoals',
            'dashproducts',
        ];

        parent::__construct();

        $this->displayName = $this->l('PrestaShop Metrics');
        $this->description = $this->l('Module for Prestashop Metrics.');
        $this->psVersionIs17 = (bool) version_compare(_PS_VERSION_, '1.7', '>=');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');
        $this->ps_versions_compliancy = ['min' => '1.7.5', 'max' => _PS_VERSION_];
        $this->template_dir = '../../../../modules/' . $this->name . '/views/templates/admin/';

        if ($this->container === null) {
            $this->container = new \PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer($this->name, $this->getLocalPath());
        }
    }

    /**
     * This method is trigger at the installation of the module
     *
     * @return bool
     */
    public function install()
    {
        /** @var PrestaShop\Module\Ps_metrics\Module\Install $installModule */
        $installModule = $this->getService('ps_metrics.module.install');

        /** @var PrestaShop\Module\Ps_metrics\Handler\NativeStatsHandler $nativeStats */
        $nativeStats = $this->container->getService('ps_metrics.handler.native.stats');

        return parent::install() &&
            $this->registerHook('displayAdminAfterHeader') &&
            $this->registerHook('actionAdminControllerSetMedia') &&
            $this->registerHook('dashboardZoneTwo') &&
            $installModule->updateModuleHookPosition('dashboardZoneTwo', 0) &&
            $installModule->setConfigurationValues() &&
            $installModule->installTabs() &&
            $nativeStats->install();
    }

    /**
     * Triggered at the uninstall of the module
     *
     * @return bool
     */
    public function uninstall()
    {
        /** @var PrestaShop\Module\Ps_metrics\Module\Uninstall $uninstallModule */
        $uninstallModule = $this->getService('ps_metrics.module.uninstall');

        /** @var PrestaShop\Module\Ps_metrics\StatsTabManager $tabManager */
        $tabManager = $this->container->getService('ps_metrics.statstab.manager');

        /** @var PrestaShop\Module\Ps_metrics\Tracker\Segment $segment */
        $segment = $this->container->getService('ps_metrics.tracker.segment');
        $segment->setMessage('[MTR] Uninstall Module');
        $segment->track();

        /** @var PrestaShop\Module\Ps_metrics\Handler\NativeStatsHandler $nativeStats */
        $nativeStats = $this->container->getService('ps_metrics.handler.native.stats');

        return parent::uninstall() &&
            $uninstallModule->resetConfigurationValues() &&
            $uninstallModule->uninstallTabs() &&
            $uninstallModule->unsubscribePsEssentials() &&
            $nativeStats->uninstall();
    }

    /**
     * Activate current module.
     *
     * @param bool $force_all If true, enable module for all shop
     *
     * @return bool
     */
    public function enable($force_all = false)
    {
        /** @var PrestaShop\Module\Ps_metrics\Tracker\Segment $segment */
        $segment = $this->container->getService('ps_metrics.tracker.segment');
        $segment->setMessage('[MTR] Enable Module');
        $segment->track();

        return parent::enable($force_all);
    }

    /**
     * Desactivate current module.
     *
     * @param bool $force_all If true, disable module for all shop
     *
     * @return bool
     */
    public function disable($force_all = false)
    {
        /** @var PrestaShop\Module\Ps_metrics\Tracker\Segment $segment */
        $segment = $this->container->getService('ps_metrics.tracker.segment');
        $segment->setMessage('[MTR] Disable Module');
        $segment->track();

        return parent::disable($force_all);
    }

    /**
     * hookDashboardZoneTwo
     *
     * @return string
     */
    public function hookDashboardZoneTwo()
    {
        $this->loadDashboardAssets();

        return $this->display(__FILE__, '/views/templates/hook/HookDashboardZoneTwo.tpl');
    }

    /**
     * Load the configuration form.
     *
     * @return string
     * @return void
     */
    public function getContent()
    {
        /** @var PrestaShop\Module\Ps_metrics\Adapter\LinkAdapter $link */
        $link = $this->container->getService('ps_metrics.adapter.link');

        \Tools::redirectAdmin($link->getAdminLink($this->metricsSettingsController));
    }

    /**
     * Load VueJs App Dashboard and set JS variable for Vuex
     *
     * @param string $responseApiMessage
     * @param int $countProperty
     *
     * @return void
     */
    private function loadDashboardAssets($responseApiMessage = 'null', $countProperty = 0)
    {
        $this->context->smarty->assign('pathMetricsApp', $this->_path . 'views/js/app-metrics.' . $this->version . '.js');
        $this->context->smarty->assign('pathVendorMetrics', $this->_path . 'views/js/chunk-vendor-metrics.' . $this->version . '.js');
        $this->context->smarty->assign('pathMetricsAssets', $this->_path . 'views/css/style-metrics.' . $this->version . '.css');

        /** @var PrestaShop\Module\Ps_metrics\Presenter\Store\StorePresenter $storePresenter */
        $storePresenter = $this->getService('ps_metrics.presenter.store.store');
        $storePresenter->setProperties(null, (string) $responseApiMessage, (int) $countProperty);

        Media::addJsDef([
            'storePsMetrics' => $storePresenter->present(),
        ]);
    }

    /**
     * Retrieve service
     *
     * @param string $serviceName
     *
     * @return mixed
     */
    public function getService($serviceName)
    {
        if ($this->container === null) {
            $this->container = new \PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer(
                $this->name,
                $this->getLocalPath()
            );
        }

        return $this->container->getService($serviceName);
    }
}
