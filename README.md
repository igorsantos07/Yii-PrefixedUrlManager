Prefixed URL Routes for Yii 1.1
===============================

  This extension provides the ability to include fixed prefixes in URLs, in the case you need those for external
routing (your infrastructure splits application servers based on subpaths) or any other reason that creating a module
would be too much trouble - since it makes little sense to have an application comprised of only one module and nothing
else, right?

  By default, it uses "path" URL format and hides the script. First, because that's usually the most common use case,
so it makes more sense to change it when you're different; second, because that's how the extension was implemented -
it was easier to create it with those options and I didn't yet had time to test and implement with other formats. If
you feel the need of this class with other options, feel free to send a pull-request :D

  Also, this was not tested with modules yet. The behaviour is unpredictable. :( You can test it and see if it works,
or if you can adapt to make it work for you as well (and, again, send a PR after it!).


Instalation and usage
---------------------

Simply change your urlManager to use the given class and set a prefix. The other options you can see as usual in the
[URL Management guide](guide) and [CUrlManager docs](docs). Here's a sample:

```php
'urlManager' => [
	'class'     => 'vendor.igorsantos07.yii-prefixed-url.PrefixedUrlManager',
	'urlPrefix' => 'admin/',
	'rules'     => require('_routes.php'),
],
```

[guide]:http://www.yiiframework.com/doc/guide/1.1/en/topics.url
[docs]: http://www.yiiframework.com/doc/api/1.1/CUrlManager
