<?php
namespace App\Shell;

use Cake\Console\Shell;

/**
 * Demo mode will do a bunch of things to help show off the site to the casual browser, including:
 *  - Populating a username and password in the login form, so you don't need to know them to play around with the site.
 */
class ToggleDemoModeShell extends Shell
{

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $this->loadModel('Settings');
        $settings = $this->Settings->find()->firstOrFail();

        if ($settings->is_demo_site) {
            $this->out("Site currently in demo mode.");
            $this->out("Change to NORMAL mode?");
            $input = $this->in("[y/N]");

            if (strtolower($input) === 'y') {
                $settings->is_demo_site = false;
                $this->Settings->save($settings);
                $this->success("Done. Site is now in NORMAL mode.");
            }
        } else {
            $this->out("Site currently in normal mode.");
            $this->err("Changing to demo mode will allow anyone to log in as an administrator!");
            $this->err("Do you want to change to DEMO mode?");
            $input = $this->in('[y/N]');

            if (strtolower($input) === 'y') {
                $settings->is_demo_site = true;
                $this->Settings->save($settings);
                $this->success('Done. Site is now in DEMO mode.');
            }
        }
    }
}
