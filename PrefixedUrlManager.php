<?php
class PrefixedUrlManager extends CUrlManager {

	public $urlFormat = self::PATH_FORMAT;
	public $showScriptName = false;
	public $urlPrefix;
	public $urlRuleClass = 'PrefixedUrlRule';

	public function setUrlFormat($format) {
		if ($format !== self::PATH_FORMAT && $format !== self::GET_FORMAT)
			throw new CException(Yii::t('yii', 'PrefixedUrlManager.urlFormat must be either "path" or "get".'));

		$this->urlFormat = $format;
	}

	public function getUrlFormat() {
		return $this->urlFormat;
	}

	public function removeUrlPrefix($pathInfo, $prefix) {
		if ($prefix !== '') {
			$length = strlen($prefix);
			if (substr($pathInfo, 0, $length) === $prefix)
				$pathInfo = substr($pathInfo, $length);
			else {
				$slash = strpos($prefix, '/');
				if ($slash == 0)
					$prefix = ltrim($prefix, '/');
				elseif ($slash == $length - 1)
					$prefix = rtrim($prefix, '/');

				$length = strlen($prefix);
				if (substr($pathInfo, 0, $length) === $prefix)
					$pathInfo = substr($pathInfo, $length);
			}

		}

		return $pathInfo?: '';
	}

}

class PrefixedUrlRule extends CUrlRule {

	public $urlPrefix;

	public function __construct($route, $pattern) {
		parent::__construct($route, $pattern);
	}

	public function getPrefix($manager) {
		return $this->urlPrefix === null? $manager->urlPrefix : $this->urlPrefix;
	}

	public function createUrl($manager, $route, $params, $ampersand) {
		$url = parent::createUrl($manager, $route, $params, $ampersand);

		if ($url === false)
			return $url;
		else {
			$prefix = $this->getPrefix($manager);
			if ($prefix)
				$url = $prefix.$url;

			return $url;
		}
	}

	/**
	 * @inheritdoc
	 * @param PrefixedUrlManager $manager
	 */
	public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
		$prefix = $this->getPrefix($manager);
		if ($prefix)
			$pathInfo = $manager->removeUrlPrefix($rawPathInfo, $prefix);

		//URL suffix is always required, but not found in the requested URL
		if ($pathInfo === $rawPathInfo && ($prefix != '' && $prefix !== '/'))
				return false;

		return parent::parseUrl($manager, $request, $pathInfo, $pathInfo);
	}

}
