<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* message_body.html */
class __TwigTemplate_37999a1aa0a01e2dfac9c6e1a749234f12939c0c95000ca8de6edad4f31b589e extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        if (($context["S_SIMPLE_MESSAGE"] ?? null)) {
            // line 2
            echo "\t";
            $location = "simple_header.html";
            $namespace = false;
            if (strpos($location, '@') === 0) {
                $namespace = substr($location, 1, strpos($location, '/') - 1);
                $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
                $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
            }
            $this->loadTemplate("simple_header.html", "message_body.html", 2)->display($context);
            if ($namespace) {
                $this->env->setNamespaceLookUpOrder($previous_look_up_order);
            }
        } else {
            // line 4
            echo "\t";
            $location = "overall_header.html";
            $namespace = false;
            if (strpos($location, '@') === 0) {
                $namespace = substr($location, 1, strpos($location, '/') - 1);
                $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
                $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
            }
            $this->loadTemplate("overall_header.html", "message_body.html", 4)->display($context);
            if ($namespace) {
                $this->env->setNamespaceLookUpOrder($previous_look_up_order);
            }
        }
        // line 6
        echo "
<div class=\"panel\" id=\"message\">
\t<div class=\"inner\">
\t<h2 class=\"message-title\">";
        // line 9
        echo ($context["MESSAGE_TITLE"] ?? null);
        echo "</h2>
\t<p>";
        // line 10
        echo ($context["MESSAGE_TEXT"] ?? null);
        echo "</p>
\t";
        // line 11
        if (((((($context["SCRIPT_NAME"] ?? null) == "search") &&  !($context["S_BOARD_DISABLED"] ?? null)) &&  !($context["S_NO_SEARCH"] ?? null)) && ($context["L_RETURN_TO_SEARCH_ADV"] ?? null))) {
            // line 12
            echo "\t\t<p>
\t\t\t<a href=\"";
            // line 13
            echo ($context["U_SEARCH"] ?? null);
            echo "\" class=\"arrow-";
            echo ($context["S_CONTENT_FLOW_BEGIN"] ?? null);
            echo "\" accesskey=\"r\">
\t\t\t\t<i class=\"icon fa-angle-";
            // line 14
            echo ($context["S_CONTENT_FLOW_BEGIN"] ?? null);
            echo " fa-fw icon-black\" aria-hidden=\"true\"></i><span>";
            echo $this->env->getExtension('phpbb\template\twig\extension')->lang("GO_TO_SEARCH_ADV");
            echo "</span>
\t\t\t</a>
\t\t</p>
\t";
        }
        // line 18
        echo "\t</div>
</div>

";
        // line 21
        if (($context["S_SIMPLE_MESSAGE"] ?? null)) {
            // line 22
            echo "\t";
            $location = "simple_footer.html";
            $namespace = false;
            if (strpos($location, '@') === 0) {
                $namespace = substr($location, 1, strpos($location, '/') - 1);
                $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
                $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
            }
            $this->loadTemplate("simple_footer.html", "message_body.html", 22)->display($context);
            if ($namespace) {
                $this->env->setNamespaceLookUpOrder($previous_look_up_order);
            }
        } else {
            // line 24
            echo "\t";
            $location = "overall_footer.html";
            $namespace = false;
            if (strpos($location, '@') === 0) {
                $namespace = substr($location, 1, strpos($location, '/') - 1);
                $previous_look_up_order = $this->env->getNamespaceLookUpOrder();
                $this->env->setNamespaceLookUpOrder(array($namespace, '__main__'));
            }
            $this->loadTemplate("overall_footer.html", "message_body.html", 24)->display($context);
            if ($namespace) {
                $this->env->setNamespaceLookUpOrder($previous_look_up_order);
            }
        }
    }

    public function getTemplateName()
    {
        return "message_body.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  114 => 24,  100 => 22,  98 => 21,  93 => 18,  84 => 14,  78 => 13,  75 => 12,  73 => 11,  69 => 10,  65 => 9,  60 => 6,  46 => 4,  32 => 2,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "message_body.html", "");
    }
}