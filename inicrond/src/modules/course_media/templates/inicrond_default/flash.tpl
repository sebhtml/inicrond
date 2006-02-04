{* Smarty *}
<html>
        <head>
                <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
                <title>
                        {$chapitre_media_title}
                </title>

        </head>


        <frameset border="0" rows="100%,*">
                <frame noresize  src="flash2.php?chapitre_media_id={$chapitre_media_id}" />

                <frame name="mytarget" src="includes/index.html" />

        </frameset>
</html>

