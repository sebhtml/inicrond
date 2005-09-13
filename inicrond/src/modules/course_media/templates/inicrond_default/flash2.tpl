{* Smarty *}
<html>
	<head>

		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1" />

		
	</head>
	<body>
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
				codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0"
				width="{$chapitre_media_width}"
				height="{$chapitre_media_height}"
				id="" align="middle">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="movie"
			value="download.php?chapitre_media_id={$chapitre_media_id}" />
			<param name="wmode" value="transparent" />
			<param name="quality" value="high" />
			<param name="menu" value="false" />
			<param name="bgcolor" value="#ffffff" />
			<embed src="download.php?chapitre_media_id={$chapitre_media_id}"
			quality="high"
			bgcolor="#ffffff" width="{$chapitre_media_width}"

			height="{$chapitre_media_height}"
			wmode="transparent"
			name="" align="middle" menu="false"
			allowScriptAccess="sameDomain" type="application/x-shockwave-flash"
			pluginspage="http://www.macromedia.com/go/getflashplayer" />
			</object> 


			</body>
</html>
