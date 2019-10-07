<?php
// added this empty tag to stop code sniffer from complaining
?>
<script>
    $(function() {
        $("#sortable").sortable();
    });

    function saveOrder() {
        var selectedLanguage = new Array();
        $('ul#sortable li').each(function() {
            selectedLanguage.push($(this).attr("id"));
        });
        document.getElementById("sort_order").value = selectedLanguage;
    }
</script>