<?php
namespace Pulse\Kernel;

class ErrorReporting extends \Pulse\Kernel
{
    /**
     * @var array
     */
    protected $settings;

    /**
     * Constructor
     * @param array $settings
     */
    public function __construct($settings = array())
    {
        $this->settings = $settings;
    }

    /**
     * Call
     */
    public function call()
    {
        try {
            $this->next->call();
        } catch (\Exception $e) {
            $log = $this->app->getLog(); // Force Pulse to append log to env if not already
            $env = $this->app->environment();
            $env['pulse.log'] = $log;
            $env['pulse.log']->error($e);
            $this->app->contentType('text/html');
            $this->app->response()->status(500);
            $this->app->response()->body($this->renderBody($env, $e));
        }
    }

    /**
     * Render response body
     * @param  array      $env
     * @param  \Exception $exception
     * @return string
     */
    protected function renderBody(&$env, $exception)
    {
        $title = 'Oops! Exception detected';
        $code = $exception->getCode();
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();
        $trace = str_replace(array('#', '\n'), array('<div>#', '</div>'), $exception->getTraceAsString());
        $html = sprintf('<h1>%s</h1>', $title);
        $html .= '<p>Something is broken, the application could not run, Pulse has detected the following error:</p>';
        $html .= '<h2>Details</h2>';
        $html .= sprintf('<div><strong>Type:</strong> %s</div>', get_class($exception));
        if ($code) {
            $html .= sprintf('<div><strong>Code:</strong> %s</div>', $code);
        }
        if ($message) {
            $html .= sprintf('<div><strong>Message:</strong> %s</div>', $message);
        }
        if ($file) {
            $html .= sprintf('<div><strong>File:</strong> %s</div>', $file);
        }
        if ($line) {
            $html .= sprintf('<div><strong>Line:</strong> %s</div>', $line);
        }
        if ($trace) {
            $html .= '<h2>Trace</h2>';
            $html .= sprintf('<pre>%s</pre>', $trace);
        }

        return sprintf("<!doctype html><html lang=\"es\"><head><meta charset=\"UTF-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><link rel=\"stylesheet\" href=\"".asset('bootstrap.min.css')."\"><link rel=\"stylesheet\" href=\"".asset('styles.css')."\"><title>%s</title></head><body><nav class=\"navbar navbar-inverse navbar-fixed-top\"> <div class=\"container\"><div class=\"navbar-header\"><button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar\" aria-expanded=\"false\" aria-controls=\"navbar\"><span class=\"sr-only\">Toggle navigation</span><span class=\"icon-bar\"></span><span class=\"icon-bar\"></span><span class=\"icon-bar\"></span></button><a class=\"navbar-brand\" href=\"".basePath()."\">PULSE Framework</a></div><div id=\"navbar\" class=\"collapse navbar-collapse\"><ul class=\"nav navbar-nav\"><li><a href=\"".basePath()."\">Página principal</a></li><li><a href=\"".uri('documentationUrl')."\">Documentation</a></li><li><a href=\"".uri('communityUrl')."\">Pulse Community</a></li><li><a href=\"".uri('tutosUrl')."\">Tutorials</a></li></ul></div></div></nav><div class=\"container\"><div class=\"starter-template\">%s</div></div><script src=\"".asset('jquery.min.js')."\"></script><script src=\"".asset('bootstrap.min.js')."\"></script></body></html>", $title, $html);
    }
}
