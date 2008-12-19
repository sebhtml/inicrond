<script type="text/javascript">
  _editor_url = "../../libs/HTMLArea";
  _editor_lang = "{$HTMLArea_language}";
</script>
{literal}
<script type="text/javascript" src="../../libs/HTMLArea/htmlarea.js"></script>

<!-- load the plugins -->
<script type="text/javascript">
      // WARNING: using this interface to load plugin
      // will _NOT_ work if plugins do not have the language
      // loaded by HTMLArea.

      // In other words, this function generates SCRIPT tags
      // that load the plugin and the language file, based on the
      // global variable HTMLArea.I18N.lang (defined in the lang file,
      // in our case "lang/en.js" loaded above).

      // If this lang file is not found the plugin will fail to
      // load correctly and NOTHING WILL WORK.

      HTMLArea.loadPlugin("TableOperations");
      //HTMLArea.loadPlugin("SpellChecker");
      HTMLArea.loadPlugin("FullPage");
   //   HTMLArea.loadPlugin("CSS");
      HTMLArea.loadPlugin("ContextMenu");
  //    HTMLArea.loadPlugin("HtmlTidy");
     // HTMLArea.loadPlugin("ListType");
   //   HTMLArea.loadPlugin("CharacterMap");
	HTMLArea.loadPlugin("DynamicCSS");
</script>

<script type="text/javascript">
var editor = null;

function initEditor() {
{/literal}
  // create an editor for the "ta" textbox
  editor = new HTMLArea("{$textarea_name}");
{literal}
  // register the FullPage plugin
  editor.registerPlugin(FullPage);

  // register the SpellChecker plugin
  editor.registerPlugin(TableOperations);

  // register the SpellChecker plugin
 // editor.registerPlugin(SpellChecker);

  // register the HtmlTidy plugin
  //editor.registerPlugin(HtmlTidy);

  // register the ListType plugin
 // editor.registerPlugin(ListType);

//  editor.registerPlugin(CharacterMap);
//editor.registerPlugin(DynamicCSS);

  // register the CSS plugin
/*  editor.registerPlugin(CSS, {
    combos : [
      { label: "Syntax:",
                   // menu text       // CSS class
        options: { "None"           : "",
                   "Code" : "code",
                   "String" : 'string',
                   "Comment" : "comment",
                   "Variable name" : "variable-name",
                   "Type" : "type",
                   "Reference" : "reference",
                   "Preprocessor" : "preprocessor",
                   "Keyword" : "keyword",
                   "Function name" : "function-name",
                   "Html tag" : "html-tag",
                   "Html italic" : "html-helper-italic",
                   "Warning" : "warning",
                   "Html bold" : "html-helper-bold"
                 },
        context: "pre"
      },
      { label: "Info:",
        options: { "None"           : "",
                   "Quote"          : "quote",
                   "Highlight"      : "highlight",
                   "Deprecated"     : "deprecated"
                 }
      }
    ]
  });*/

  // add a contextual menu
  editor.registerPlugin("ContextMenu");

  // load the stylesheet used by our CSS plugin configuration
  editor.config.pageStyle = "@import url(custom.css);";

  editor.generate();
  return false;
}

HTMLArea.onload = initEditor;

</script>
{/literal}