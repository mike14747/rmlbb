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

/* @phpbbmodders_adduser/event/acp_overall_footer_after.html */
class __TwigTemplate_d24732d98093afb0cc84c2b5fa66c983a9409acc7f6eb61f1dcfe7b28188d00d extends \Twig\Template
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
        if (($context["S_USER_ADD"] ?? null)) {
            // line 2
            echo "<script type=\"text/javascript\">
(function(\$) {  // Avoid conflicts with other libraries
\t'use strict';
\t\$(function() {
\t\tvar selected_option = \$('#group').val();
\t\tif(selected_option == false) {
\t\t\t\$('.default_group').fadeOut('fast');
\t\t}
\t\t\$('#group').change(function() {
\t\t\tvar group = \$(this).val();
\t\t\tif(group == false) {
\t\t\t\t\$('.default_group').fadeOut('fast', function() {
\t\t\t\t\t\$('#group_default').prop('checked',false);
\t\t\t\t});
\t\t\t}
\t\t\telse {
\t\t\t\t\$('.default_group').fadeIn('fast');
\t\t\t}
\t\t});
\t});
})(jQuery);
</script>
";
        }
    }

    public function getTemplateName()
    {
        return "@phpbbmodders_adduser/event/acp_overall_footer_after.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  32 => 2,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "@phpbbmodders_adduser/event/acp_overall_footer_after.html", "");
    }
}
