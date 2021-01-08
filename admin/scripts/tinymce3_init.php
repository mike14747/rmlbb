<?php
// added this empty tag to stop code sniffer from complaining
?>
<script type="text/javascript" src="tinymce3/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    tinymce.init({
        mode: "textareas",
        theme: "advanced",
        theme_advanced_font_sizes: "8px,10px,12px,14px,16px,18px,24px",
        plugins: "advlist,spellchecker,advhr,preview,paste",
        theme_advanced_buttons1: "bold,italic,underline,sub,sup,charmap,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect",
        theme_advanced_buttons2: "bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,code,preview,|,spellchecker,advhr,removeformat,|,backcolor,forecolor",
        theme_advanced_buttons3: "",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "center",
        // paste_text_sticky: true,
        // setup: function(ed) {
        //     ed.onInit.add(function(ed) {
        //         ed.pasteAsPlainText = true;
        //     });
        // }
    });
</script>