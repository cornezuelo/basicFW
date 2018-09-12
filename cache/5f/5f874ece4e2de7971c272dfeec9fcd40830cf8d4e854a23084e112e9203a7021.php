<?php

/* index.html.twig */
class __TwigTemplate_4ae7540ea7da2cce2a96c0ce0c7737729285ebda1c3dc431d57a35b6041bd918 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "Hello world!

";
        // line 3
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('dump')->getCallable(), array((((isset($context["test_string"]) || array_key_exists("test_string", $context))) ? (_twig_default_filter(($context["test_string"] ?? null), "")) : ("")))), "html", null, true);
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  27 => 3,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "index.html.twig", "/var/www/php7.sudespacho.local/oaviles/basicFW/views/index.html.twig");
    }
}
