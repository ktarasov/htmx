<?php

namespace Concrete\Package\Htmx;

defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Package\Package;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Asset\Asset;

class Controller extends Package
{
    protected $pkgHandle = 'htmx';
    protected $appVersionRequired = '8.0.0';
    protected $pkgVersion = '2.0.8';

	protected $pkgAutoloaderRegistries = [
    	'src' => '\HTMx',
	];

    public function getPackageDescription()
    {
        return t('Adds a HTMx support classes.');
    }

    public function getPackageName()
    {
        return t('HTMx');
    }

	public function on_start()
	{
		$al = AssetList::getInstance();
		$al->register(
            'javascript', 'htmx', 'assets/js/htmx.min.js', [
                'version' => '2.0.8',
                'position' => Asset::ASSET_POSITION_FOOTER,
                'minify' => false,
                'combine' => false
            ], $this
        );
	}
}