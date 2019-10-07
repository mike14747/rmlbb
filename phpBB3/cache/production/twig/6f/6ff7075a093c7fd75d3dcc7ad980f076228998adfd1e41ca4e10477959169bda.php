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

/* navbar_footer.html */
class __TwigTemplate_bb316aee0f86a31a3ae15e0a0d7eb93fdf2efbfeb878ad0210e1cc8fb96aa0af extends \Twig\Template
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
        echo "<div class=\"navbar\" role=\"navigation\">
\t<div class=\"inner\">

\t<ul id=\"nav-footer\" class=\"nav-footer linklist\" role=\"menubar\">
\t\t<li class=\"breadcrumbs\">
\t\t\t";
        // line 6
        if (($context["U_SITE_HOME"] ?? null)) {
            // line 7
            echo "\t\t\t\t";
            ob_start();
            // line 8
            echo "\t\t\t\t<span class=\"crumb\">
\t\t\t\t\t<a href=\"";
            // line 9
            echo ($context["U_SITE_HOME"] ?? null);
            echo "\" data-navbar-reference=\"home\">
\t\t\t\t\t\t<i class=\"icon fa-home fa-fw\" aria-hidden=\"true\"></i><span>";
            // line 10
            echo $this->env->getExtension('phpbb\template\twig\extension')->lang("SITE_HOME");
            echo "</span>
\t\t\t\t\t</a>
\t\t\t\t</span>
\t\t\t\t";
            echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
            // line 14
            echo "\t\t\t";
        }
        // line 15
        echo "\t\t\t";
        // line 16
        echo "\t\t\t";
        ob_start();
        // line 17
        echo "\t\t\t<span class=\"crumb\">
\t\t\t\t<a href=\"";
        // line 18
        echo ($context["U_INDEX"] ?? null);
        echo "\" data-navbar-reference=\"index\">
\t\t\t\t\t";
        // line 19
        if ( !($context["U_SITE_HOME"] ?? null)) {
            echo "<i class=\"icon fa-home fa-fw\" aria-hidden=\"true\"></i>";
        }
        echo "<span>";
        echo $this->env->getExtension('phpbb\template\twig\extension')->lang("INDEX");
        echo "</span>
\t\t\t\t</a>
\t\t\t</span>
\t\t\t";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 23
        echo "\t\t\t";
        // line 24
        echo "\t\t</li>
\t\t";
        // line 25
        if ((($context["U_WATCH_FORUM_LINK"] ?? null) &&  !($context["S_IS_BOT"] ?? null))) {
            // line 26
            echo "\t\t\t<!-- <li data-last-responsive=\"true\">
\t\t\t\t<a href=\"";
            // line 27
            echo ($context["U_WATCH_FORUM_LINK"] ?? null);
            echo "\" title=\"";
            echo ($context["S_WATCH_FORUM_TITLE"] ?? null);
            echo "\" data-ajax=\"toggle_link\" data-toggle-class=\"icon fa-check-square-o fa-square-o fa-fw\" data-toggle-text=\"";
            echo ($context["S_WATCH_FORUM_TOGGLE"] ?? null);
            echo "\" data-toggle-url=\"";
            echo ($context["U_WATCH_FORUM_TOGGLE"] ?? null);
            echo "\">
\t\t\t\t\t<i class=\"icon fa-square-ofa-check-square-o fa-fw\" aria-hidden=\"true\"></i><span>";
            // line 28
            echo ($context["S_WATCH_FORUM_TITLE"] ?? null);
            echo "</span>
\t\t\t\t</a>
\t\t\t</li> -->
\t\t";
        }
        // line 32
        echo "
\t\t";
        // line 33
        // line 34
        echo "\t\t<li class=\"rightside\">";
        echo ($context["S_TIMEZONE"] ?? null);
        echo "</li>
\t\t";
        // line 35
        // line 36
        echo "\t\t";
        if ( !($context["S_IS_BOT"] ?? null)) {
            // line 37
            echo "\t\t\t<li class=\"rightside\">
\t\t\t\t<a href=\"";
            // line 38
            echo ($context["U_DELETE_COOKIES"] ?? null);
            echo "\" data-ajax=\"true\" data-refresh=\"true\" role=\"menuitem\">
\t\t\t\t\t<i class=\"icon fa-trash fa-fw\" aria-hidden=\"true\"></i><span>";
            // line 39
            echo $this->env->getExtension('phpbb\template\twig\extension')->lang("DELETE_COOKIES");
            echo "</span>
\t\t\t\t</a>
\t\t\t</li>
\t\t\t";
            // line 42
            if (($context["S_DISPLAY_MEMBERLIST"] ?? null)) {
                // line 43
                echo "\t\t\t\t<!-- <li class=\"rightside\" data-last-responsive=\"true\">
\t\t\t\t\t<a href=\"";
                // line 44
                echo ($context["U_MEMBERLIST"] ?? null);
                echo "\" title=\"";
                echo $this->env->getExtension('phpbb\template\twig\extension')->lang("MEMBERLIST_EXPLAIN");
                echo "\" role=\"menuitem\">
\t\t\t\t\t\t<i class=\"icon fa-group fa-fw\" aria-hidden=\"true\"></i><span>";
                // line 45
                echo $this->env->getExtension('phpbb\template\twig\extension')->lang("MEMBERLIST");
                echo "</span>
\t\t\t\t\t</a>
\t\t\t\t</li> -->
\t\t\t";
            }
            // line 49
            echo "\t\t";
        }
        // line 50
        echo "
\t\t";
        // line 51
        // line 52
        echo "
\t\t";
        // line 53
        if (($context["U_TEAM"] ?? null)) {
            // line 54
            echo "\t\t\t<!-- <li class=\"rightside\" data-last-responsive=\"true\">
\t\t\t\t<a href=\"";
            // line 55
            echo ($context["U_TEAM"] ?? null);
            echo "\" role=\"menuitem\">
\t\t\t\t\t<i class=\"icon fa-shield fa-fw\" aria-hidden=\"true\"></i><span>";
            // line 56
            echo $this->env->getExtension('phpbb\template\twig\extension')->lang("THE_TEAM");
            echo "</span>
\t\t\t\t</a>
\t\t\t</li> -->
\t\t";
        }
        // line 60
        echo "
\t\t";
        // line 61
        // line 62
        echo "\t\t";
        if (($context["U_CONTACT_US"] ?? null)) {
            // line 63
            echo "\t\t\t<!-- <li class=\"rightside\" data-last-responsive=\"true\">
\t\t\t\t<a href=\"";
            // line 64
            echo ($context["U_CONTACT_US"] ?? null);
            echo "\" role=\"menuitem\">
\t\t\t\t\t<i class=\"icon fa-envelope fa-fw\" aria-hidden=\"true\"></i><span>";
            // line 65
            echo $this->env->getExtension('phpbb\template\twig\extension')->lang("CONTACT_US");
            echo "</span>
\t\t\t\t</a>
\t\t\t\ttesting contact us
\t\t\t</li> -->
\t\t";
        }
        // line 70
        echo "\t</ul>

\t</div>
</div>
";
    }

    public function getTemplateName()
    {
        return "navbar_footer.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  201 => 70,  193 => 65,  189 => 64,  186 => 63,  183 => 62,  182 => 61,  179 => 60,  172 => 56,  168 => 55,  165 => 54,  163 => 53,  160 => 52,  159 => 51,  156 => 50,  153 => 49,  146 => 45,  140 => 44,  137 => 43,  135 => 42,  129 => 39,  125 => 38,  122 => 37,  119 => 36,  118 => 35,  113 => 34,  112 => 33,  109 => 32,  102 => 28,  92 => 27,  89 => 26,  87 => 25,  84 => 24,  82 => 23,  71 => 19,  67 => 18,  64 => 17,  61 => 16,  59 => 15,  56 => 14,  49 => 10,  45 => 9,  42 => 8,  39 => 7,  37 => 6,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "navbar_footer.html", "");
    }
}