<?php

namespace Kanboard\Plugin\SkillMatrix;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
        $this->route->addRoute('/skillmatrix', 'SkillMatrixController', 'load', 'SkillMatrix');
        $this->template->hook->attach('template:dashboard:sidebar', 'SkillMatrix:dashboard/sidebar');

        $this->hook->on('template:layout:css', array('template' => 'plugins/SkillMatrix/Assets/css/custom.css'));
        $this->hook->on('template:layout:js', array('template' => 'plugins/SkillMatrix/Assets/js/functions.js'));

        $this->helper->register('skillDatabaseHelper', '\Kanboard\Plugin\SkillMatrix\Helper\SkillDatabaseHelper');
        $this->helper->register('skillFunctionsHelper', '\Kanboard\Plugin\SkillMatrix\Helper\SkillFunctionsHelper');




    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'Skill Matrix';
    }

    public function getPluginDescription()
    {
        return t('Plugin for monitoring knowledge of existing users');
    }

    public function getPluginAuthor()
    {
        return 'Jan Válka';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-myplugin';
    }
}

